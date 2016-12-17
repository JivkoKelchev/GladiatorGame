<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 13.12.2016 г.
 * Time: 16:15
 */

namespace GameBundle\Services;


use Doctrine\ORM\EntityManager;
use GameBundle\Entity\Fights;
use GameBundle\Entity\gladArmor;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\gladWeapons;
use GameBundle\Entity\notification;
use GameBundle\Entity\Reports;
use GameBundle\Repository\gladArmorRepository;
use Symfony\Component\Finder\Iterator\ExcludeDirectoryFilterIterator;

class FightService
{
    const ATT_MAX = 5;
    const ATT_MIN = 0;

    public function goToArena(gladiators $gladiator,EntityManager $em)
    {
        $gladId=$gladiator->getId();
        $user = $gladiator->getUser();


        $fightRepository = $em->getRepository(Fights::class);


        $rows=$fightRepository->findBy(['glad2'=>null]);
        if (!empty($rows)) {
            //Check if opponent glad is your own glad
            $check=false;
            foreach ($rows as $row) {
                $opponentId=$row->getGlad1();
                $gladiators = $user->getGladiators();

                //Get all your Glads
                foreach ($gladiators as $gladiator){
                    $ownId=$gladiator->getId();
                    $ownGlads[]=$ownId;
                }
                if (!in_array($opponentId,$ownGlads)){
                    $row->setGlad2($gladId);
                    $em->persist($row);
                    $em->flush();
                    Break;
                }
                $check = true;
            }
            // If check = true all free opponents are your Glads
            if($check){
                $fights= new Fights();
                $fights->setGlad1($gladId);
                $em->persist($fights);
                $em->flush();
                // redirect to waitingOpponentToConnect screen
                return 'waiting';
            }else{
                //redirect to NextRound screen
                return 'next_round';
            }


        }  else {
            $fights= new Fights();
            $fights->setGlad1($gladId);
            $em->persist($fights);
            $em->flush();
            //redirect to waitingOpponentToConnect screen
            return 'waiting';
        }
    }

    public function checkIfGladIsAlreadyInArena(gladiators $gladiator,EntityManager $em)
    {
        $ownId=$gladiator->getId();
        $result1=$em->getRepository(Fights::class)->findOneBy(['glad1'=> $ownId]);
        $result2=$em->getRepository(Fights::class)->findOneBy(['glad2'=> $ownId]);
        if($result1){
            return true;
        }elseif ($result2){
            return true;
        }else{
            return false;
        }
    }

    public function allItems(EntityManager $em, $id)
    {
        $fight = $em->getRepository(Fights::class)->findOneBy(['glad1'=>$id]);
        if ($fight){
            $oponentId = $fight->getGlad2();
        }else{
            $fight = $em->getRepository(Fights::class)->findOneBy(['glad2'=>$id]);
            $oponentId=$fight->getGlad1();
        }
        $opponentGlad=$em->getRepository(gladiators::class)->findOneBy(['id'=>$oponentId]);
        $ownGlad=$em->getRepository(gladiators::class)->findOneBy(['id'=>$id]);

        return $allItems[]=['ownGlad'=>$ownGlad,'opponent'=>$opponentGlad];
    }

    private function dice()
    {
        return rand(1,6);
    }


    public function calculateAttakStat(EntityManager $em, gladiators $gladiator)
    {
        //attMin=dex + weapon att
        //attMax = str + weapon att
        // but if dex > str attMin=attMax

        $gladId = $gladiator->getId();

        $str=$gladiator->getGladStats()->getStr();
        $dex=$gladiator->getGladStats()->getDex();
        if ($dex>$str){$dex=$str;}
        $weapons=[];
        $attModifyArray=$em->getRepository(gladWeapons::class)->findBy(['gladiator'=>$gladId,'equipped'=>1]);
        foreach ($attModifyArray as $weapon){
            $weapons[]=$weapon->getWeapons()->getAttackModify();
        }
        $attModify = array_sum($weapons);

        $attMin = $dex + $attModify;
        $attMax = $str + $attModify;
        $att = ['attMin'=>$attMin,'attMax'=>$attMax];
        return $att;
    }

    public function calculateMaxDef(EntityManager $em, gladiators $gladiator)
    {
        // def = armorDefModyfay
        // every 5p dex add 1p def

        $gladId = $gladiator->getId();
        $dex=$gladiator->getGladStats()->getDex();

        $defModifyArray=$em->getRepository(gladArmor::class)->findBy(['gladiator'=>$gladId,'equipped'=>1]);
        $armors=[];
        foreach ($defModifyArray as $armor){
            $armors [] = $armor->getArmor()->getDefModify();
        }
        $armorDefModify = array_sum($armors);
        $dexDefModfy = floor($dex/5);
        $def=$armorDefModify+$dexDefModfy;
        return $def;
    }

    public function getRoundNumber(EntityManager $em, string $id)
    {
        $fight=$em->getRepository(Fights::class)->findOneBy(['glad1'=> $id]);
        if ($fight == null){$fight = $em->getRepository(Fights::class)->findOneBy(['glad2'=> $id]);}
        $fightId = $fight->getId();
        $reports = $em->getRepository(Reports::class)->findBy(['fightId'=>$fightId]);
        if ($reports==null){
            return $roundNumber = 1;
        }else{
            foreach ($reports as $report){
                $numbersFromReports [] = $report->getRound();
            }

            $bigestNumber = max($numbersFromReports);

            $countValues = count($numbersFromReports);
            if (($countValues % 2) == 1){
                $evenOrOdd = 0; // odd
            }
            else{
                $evenOrOdd = 1; // even
            }

            if ($evenOrOdd == 0){
                return $roundNumber = $bigestNumber;
            } else {
                return $roundNumber = $bigestNumber + 1;
            }
        }
    }

    public function isYourTurn(EntityManager $em, $id)
    {
        $fight=$em->getRepository(Fights::class)->findOneBy(['glad1'=> $id]);
        if ($fight == null){
            $fight=$em->getRepository(Fights::class)->findOneBy(['glad2'=> $id]);
            $player = 2;
        } else {
            $player = 1;
        }

        $fightId = $fight->getId();
        $reports = $em->getRepository(Reports::class)->findBy(['fightId'=>$fightId]);
        if ($reports==null and $player == 2) {
            return $itsYourTurn = true;
        } elseif ($reports==null and $player == 1){
            return $itsYourTurn = false;
        }else {

            foreach ($reports as $report) {
                $numbersFromReports [] = $report->getRound();
            }
            $countValues = count($numbersFromReports);

            if (($countValues % 2) == 1){
                $evenOrOdd = 0; // odd
            }
            else{
                $evenOrOdd = 1; // even
            }

            if ($evenOrOdd == 0 and $player == 1){
                return $itsYourTurn = true;
            } elseif ($evenOrOdd == 0 and $player == 2) {
                return $itsYourTurn = false;
            } elseif ($evenOrOdd == 1 and $player == 1) {
                return $itsYourTurn = false;
            } else {
                return $itsYourTurn = true;
            }
        }
    }

    private function isRoundFinished(EntityManager $em, $fightId)
    {
        //This function is used after throw dice. 100% there is reports for this fight

        //Check if round is finished
        $reports = $em->getRepository(Reports::class)->findBy(['fightId'=>$fightId]);

        foreach ($reports as $report) {
            $numbersFromReports [] = $report->getRound();
        }
        $countValues = count($numbersFromReports);

        if (($countValues % 2) == 1){
            $evenOrOdd = 0; // odd
            return false;
        }
        else{
            $evenOrOdd = 1; // even
            return true;
        }
    }


    public function throwDices(EntityManager $em, string $id, int $round)
        //1. throw Dices and persist new report
        //2. check if round is finished
        //if 2. is true
        //2.1 calculate results and persist results
        //2.2 check if there is a winner
        // if 2.2 is true persist results
        //3. persist notification
    {
        //for debuging
        //some default values DO NOT DELETE!!!
        $newGladHp='';
        $newOpponentHp='';
        $gladDamageDone='';
        $opponentDamageDone='';
        $opponentAttDice='';
        $opponentDefDice='';
        //1. throw Dices and persist new report
        $fight=$em->getRepository(Fights::class)->findOneBy(['glad1'=> $id]);

        if ($fight == null){
            $fight = $em->getRepository(Fights::class)->findOneBy(['glad2'=> $id]);
            $opponentId = $fight->getGlad1();
        } else {
            $opponentId = $fight->getGlad2();
        }

        $fightId=$fight->getId();
        $attDice = $this->dice();
        $defDice = $this->dice();

        $newReport = new Reports();
        $newReport->setFightId($fightId);
        $newReport->setGladId(intval($id));
        $newReport->setRound($round);
        $newReport->setAttDice($attDice);
        $newReport->setDefDice($defDice);
        $em->persist($newReport);
        $em->flush();


        //2. check if round is finished
        $isRoundFinished = $this->isRoundFinished($em, $fightId);

        //if 2. is true
        if ($isRoundFinished){
            $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$id]);
            $opponentGlad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$opponentId]);
                //calculate damage
            $gladAtt = $this ->calculateAttakStat($em,$glad);
            $opponentGladAtt = $this ->calculateAttakStat($em,$opponentGlad);
            $gladDef = $this->calculateMaxDef($em, $glad);
            $opponentGladDef = $this->calculateMaxDef($em, $opponentGlad);
            $opponentReport = $em->getRepository(Reports::class)->findOneBy(['fightId'=>$fightId,'gladId'=>$opponentId,'round'=>$round]);
            $opponentDefDice = $opponentReport->getDefDice();
            $opponentAttDice = $opponentReport->getAttDice();
                //damage made from glad
            if ($attDice == 6){
                $gladAttForThisRound = $gladAtt['attMax'];
                $opponentGladDefForThisRound = floor(($opponentGladDef - floor($opponentGladDef*2/10))*($opponentDefDice/6));
                if ($opponentGladDefForThisRound>$gladAttForThisRound){
                    $gladDamageDone = 0;
                } else {
                    $gladDamageDone = $gladAttForThisRound-$opponentGladDefForThisRound;
                }
            } else {
                $gladAttForThisRound = floor(($gladAtt['attMax']-$gladAtt['attMin'])/6*$attDice)+$gladAtt['attMin'];
                $opponentGladDefForThisRound = floor($opponentGladDef*($opponentDefDice/6));
                if ($opponentGladDefForThisRound>$gladAttForThisRound){
                    $gladDamageDone = 0;
                } else {
                    $gladDamageDone = $gladAttForThisRound-$opponentGladDefForThisRound;
                }

            }
                //damage made from opponent
            if ($opponentAttDice == 6){
                $opponentAttForThisRound = $opponentGladAtt['attMax'];
                $gladDefForThisRound = floor(($gladDef - floor($gladDef*2/10))*($defDice/6));
                if ($gladDefForThisRound>$opponentAttForThisRound){
                    $opponentDamageDone = 0;
                }else{
                    $opponentDamageDone = $opponentAttForThisRound-$gladDefForThisRound;
                }
            } else {
                $opponentAttForThisRound = floor(($opponentGladAtt['attMax']-$opponentGladAtt['attMin'])/6*$opponentAttDice)+$opponentGladAtt['attMin'];
                $gladDefForThisRound = floor($gladDef*($defDice/6));
                if ($gladDefForThisRound>$opponentAttForThisRound){
                    $opponentDamageDone = 0;
                }else{
                    $opponentDamageDone = $opponentAttForThisRound-$gladDefForThisRound;
                }
            }

                // persist new HP values
            $gladHp = $glad->getHP();
            $newGladHp = $gladHp - $opponentDamageDone;
            if($newGladHp<0){$newGladHp=0;}

            $glad->setHP($newGladHp);
            $em->persist($glad);
            $em->flush();

            $opponentHp = $opponentGlad->getHP();
            $newOpponentHp = $opponentHp - $gladDamageDone;
            if($newOpponentHp<0){$newOpponentHp=0;}

            $opponentGlad->setHP($newOpponentHp);
            $em->persist($opponentGlad);
            $em->flush();
        }

        //Fill array with results and send it to controller
        $opponentDices = [$opponentAttDice,$opponentDefDice];
        $gladId = $id;

        $roundResults=[
                        $gladId,//0
                        $opponentId,//1
                        $newGladHp,//2
                        $newOpponentHp,//3
                        $gladDamageDone,//4
                        $opponentDamageDone,//5
                        $fightId
                      ];

        return $dices = ['attDice'=>$attDice,'defDice'=>$defDice,'roundResult'=>$roundResults,'opponentDices'=>$opponentDices];
    }

    public function checkIfFightIsFinished(EntityManager $em, array $roundResults)
    {
        $fightId = $roundResults[6];

        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$roundResults[0]]);
        $opponent = $em->getRepository(gladiators::class)->findOneBy(['id'=>$roundResults[1]]);

        if ($roundResults[2]===''){
            return false;
        } elseif ($roundResults[2]==0 and $roundResults[3]==0 ){
            $winner = $opponent;
            $loser = $glad;

        } elseif ($roundResults[2]<=0){
            $winner = $opponent;
            $loser = $glad;
        } elseif ($roundResults[3]<=0){
            $winner = $glad;
            $loser = $opponent;
        } else {return false;}
        // winner and loser Player stats
            //points

        $points = $this->calculatePoints($winner,$loser);
        $winnerPoints = $points['winner'];
        $loserPoints = $points['loser'];

        $winnerScore = $winner->getUser()->getStats()->getPoints();
        $winnerNewPoints = $winnerScore + $winnerPoints;
        $winner->getUser()->getStats()->setPoints($winnerNewPoints);

        $loserScore = $loser->getUser()->getStats()->getPoints();
        $loserNewPoints = $loserScore + $loserPoints;
        $loser->getUser()->getStats()->setPoints($loserNewPoints);
            //gold
        $winnerGold = $winner->getUser()->getStats()->getGold();
        $winnerNewGold = $winnerGold + 5;
        $winner->getUser()->getStats()->setGold($winnerNewGold);
            //win/lose
        $winnerWins = $winner->getUser()->getStats()->getWins();
        $winnerNewWins = $winnerWins + 1;
        $winner->getUser()->getStats()->setWins($winnerNewWins);
        $loserLosses = $loser->getUser()->getStats()->getLosses();
        $loserNewLosses = $loserLosses+1 ;
        $loser->getUser()->getStats()->setLosses($loserNewLosses);
        // winner and losser gladStats
            //xp
        $winnerXp = $winner->getXP();
        $winnerNewXp = $winnerXp + $winnerPoints;
        $winner->setXP($winnerNewXp);

        $loserXp = $loser->getXP();
        $loserNewXp = $loserXp + $loserPoints;
        $loser->setXP($loserNewXp);
            //levels and LP
        $winnerXpForNextLevel = $this->calculateXpForNextLevel($winner);
        $loserXpForNextLevel = $this->calculateXpForNextLevel($loser);
        if ($winnerNewXp>=$winnerXpForNextLevel){
            $winnerLevel=$winner->getLevel();
            $winnerNewLevel = $winnerLevel+1;
            $winner->setLevel($winnerNewLevel);
            $winnerLp = $winner->getLP();
            $winnerNewLp = $winnerLp+2;
            $winner->setLP($winnerNewLp);
        }
        if ($loserNewXp>=$loserXpForNextLevel){
            $loserLevel = $loser->getLevel();
            $loserNewLevel =$loserLevel+1;
            $loser->setLevel($loserNewLevel);
            $loserLp = $loser->getLP();
            $loserNewLp = $loserLp + 2;
            $loser->setLP($loserNewLp);
        }
            //reset HP to max
        $winnerMaxHp = $this->calculateMaxHp($winner);
        $loserMaxHp = $this->calculateMaxHp($loser);
        $winner->setHP($winnerMaxHp);
        $loser->setHP($loserMaxHp);

        //persist
        $em->persist($winner);
        $em->flush();
        $em->persist($loser);
        $em->flush();

        $this->deleteFightAndReportsEntities($em,$fightId);

        return $winner;
    }

    public function calculateMaxHp(gladiators $glad){
        $str = $glad->getGladStats()->getStr();
        $maxHp = $str*5;
        return $maxHp;
    }
    public function calculateXpForNextLevel(gladiators $glad)
    {
        $level = $glad->getLevel();
        $i=1;
        $xpForPrevLevel = 0;
        while ($i<$level){
            $xpForPrevLevel=$i*20+$xpForPrevLevel;
            $i++;
        }
        $xpForNextLevel = $level*20 + $xpForPrevLevel;

        return $xpForNextLevel;
    }

    private function calculatePoints(gladiators $winner, gladiators $loser)
    {
        $winnerLevel = $winner->getLevel();
        $loserLevel = $loser->getLevel();

        if($winnerLevel==$loserLevel){
            $winnerPoints = 15;
            $loserPoints = 3;
        } elseif ($winnerLevel>$loserLevel) {
            $winnerPoints = 10;
            $loserPoints = 3;
        } else {
            $winnerPoints = 20;
            $loserPoints = 3;
        }

        return $points = ['winner'=>$winnerPoints,'loser'=>$loserPoints];
    }

    private function deleteFightAndReportsEntities(EntityManager $em, $fightId)
    {
        //remove fight
        $fight = $em->getRepository(Fights::class)->findOneBy(['id'=>$fightId]);
        $em->remove($fight);
        $em->flush();

        //remove Reports
        $reports = $em->getRepository(Reports::class)->findBy(['fightId'=>$fightId]);
        foreach ($reports as $report){
            $em->remove($report);
            $em->flush();
        }

        return true;
    }


    public function notificationSend(EntityManager $em, array $roundResults, $checkIfFightIsFinished)
    {
        date_default_timezone_set('Europe/Sofia');
//                 0       $gladId,
//                 1       $opponentId,
//                 2       $newGladHp,
//                 3       $newOpponentHp,
//                  4      $gladDamageDone,
//                  5      $opponentDamageDone,
//                        $fightId
        $opponentGladId=$roundResults[1];
        $opponentGlad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$opponentGladId]);
        $time = new \DateTime('now');
        if($checkIfFightIsFinished){
            if ($roundResults[2]<=0 and $roundResults[3]<=0 ){
                $winner = $opponentGlad;
            } elseif ($roundResults[2]<=0){
                $winner = $opponentGlad;
            } elseif ($roundResults[3]<=0) {
                $winner=null;
                $loser = $opponentGlad;
            }
            if ($winner==$opponentGlad){
                $msg = $opponentGlad->getName().' WIN HIS BATTLE!!! Clikc to delete this notification';
            } else{
                $msg = $opponentGlad->getName().' lost his battle. Clikc to delete this notification';
            }
        }else{
            $msg = 'Its your turn with. Clikc to delete this notification '.$opponentGlad->getName().'.';
        }

        $toUser = $opponentGlad->getUser()->getId();
        $notificatinEntity = new notification();
        $notificatinEntity->setToUser($toUser);
        $notificatinEntity->setMsg($msg);
        $notificatinEntity->setTime($time);
        $em->persist($notificatinEntity);
        $em->flush();
        return true;
    }


}