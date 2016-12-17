<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 12.12.2016 г.
 * Time: 20:56
 */

namespace GameBundle\Services;


use Doctrine\ORM\EntityManager;
use GameBundle\Entity\Armor;
use GameBundle\Entity\gladArmor;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\gladWeapons;
use GameBundle\Entity\Weapons;


class InventoryService
{
    public function renderArmorPicture(gladiators $gladiator)
    {

        $armors = $gladiator->getGladArmor();
        $image = 'Images/Armors/0.png';
        if ($armors == null) {
            $image = 'Images/Armors/0.png';
        } else {
            foreach ($armors as $armor) {
                $imageId = $armor->getArmor()->getImg();
                $equipped = $armor->getEquipped();
                if ($equipped === 1) {
                    $image = 'Images/Armors/' . $imageId . '.png';
                    break;
                }
            }
        }
        return $image;
    }


    public function renderWeaponsPicture(gladiators $gladiator)
    {
        $images  = 1;
        $weapons = $gladiator->getGladWeapons();
        if (count($weapons) < 1) {
            return $images  = 1;
        } else {
            foreach ($weapons as $weapon) {
                $imageId = $weapon->getWeapons()->getImg();
                $equipped = $weapon->getEquipped();
                if ($equipped == 1) {
                    $images = 'Images/Weapons/' . $imageId . '.png' ;
                    break;
                }
            }
            return $images;
        }

    }

    public function checkGladWeaponDependency(EntityManager $em, $gladId, $weaponId)
    {
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $weapon = $em->getRepository(Weapons::class)->findOneBy(['id'=>$weaponId]);
        $weaponGoldCost = $weapon->getGoldCost();
        $gladStr = $glad->getGladStats()->getStr();
        $requiredStr = $weapon->getRequiredStr();
        $userGold = $glad->getUser()->getStats()->getGold();
        if($gladStr<$requiredStr){
            $msg = 'Your gladiator doesn\'t have enough STR ';
            return $msg;
        } elseif ($userGold<$weaponGoldCost) {
            $msg = 'You  don\'t have enough GOLD ';
            return $msg;
        } else{
            return true;
        }
    }

    public function buyWeapon(EntityManager $em, $gladId, $weaponId)
    {
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $weapon = $em->getRepository(Weapons::class)->findOneBy(['id'=>$weaponId]);
        $user = $glad->getUser();

        $newGladWeapons = new gladWeapons();
        $newGladWeapons->setEquipped(0);
        $newGladWeapons->setGladiator($glad);
        $newGladWeapons->setRoundLeft($weapon->getRoundLife());
        $newGladWeapons->setWeapons($weapon);


        $userGold = $user->getStats()->getGold();
        $newUserGold = $userGold - $weapon->getGoldCost();
        $user->getStats()->setGold($newUserGold);

        $em->persist($newGladWeapons);
        $em->flush();
        $em->persist($user);
        $em->flush();
    }

    public function checkGladArmorDependency(EntityManager $em, $gladId, $armorId)
    {
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $armor = $em->getRepository(Armor::class)->findOneBy(['id'=>$armorId]);
        $armorGoldCost = $armor->getGoldCost();
        $gladStr = $glad->getGladStats()->getStr();
        $requiredStr = $armor->getReqiredStr();
        $gladLevel = $glad->getLevel();
        $requiredLevel = $armor->getRequiredLevel();
        $userGold = $glad->getUser()->getStats()->getGold();
        if($gladStr<$requiredStr){
            $msg = 'Your gladiator doesn\'t have enough STR ';
            return $msg;
        } elseif ($userGold<$armorGoldCost) {
            $msg = 'You  don\'t have enough GOLD ';
            return $msg;
        } elseif ($gladLevel<$requiredLevel){
            $msg = 'your gladiator is lower LEVEL';
            return $msg;
        } else{
            return true;
        }
    }

    public function buyArmor(EntityManager $em, $gladId, $armorId)
    {
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $armor = $em->getRepository(Armor::class)->findOneBy(['id'=>$armorId]);
        $user = $glad->getUser();

        $newGladArmor = new gladArmor();
        $newGladArmor->setEquipped(0);
        $newGladArmor->setGladiator($glad);
        $newGladArmor->setArmor($armor);


        $userGold = $user->getStats()->getGold();
        $newUserGold = $userGold - $armor->getGoldCost();
        $user->getStats()->setGold($newUserGold);

        $em->persist($newGladArmor);
        $em->flush();
        $em->persist($user);
        $em->flush();
    }

}
