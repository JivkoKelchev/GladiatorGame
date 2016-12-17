<?php

namespace GameBundle\Controller;

use GameBundle\Entity\Fights;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FightController extends Controller
{
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/arena", name="arena")
     *
     */
    public function goToArenaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $gladRepository = $this->getDoctrine()->getRepository(gladiators::class);
        $gladiator=$gladRepository->findOneBy(['id'=>$id]);
        //Fill up Fight Table
        $route = $this->get('fight_service')->goToArena($gladiator,$em);
        return $this->redirectToRoute($route,['id'=>$id]);


    }

    public function checkIfGladIsAtArenaAction(gladiators $gladiator)
    {
        $em = $this->getDoctrine()->getManager();
        $check = $this->get('fight_service')->checkIfGladIsAlreadyInArena($gladiator,$em);
        return $this->render('partials/arenaCheck.html.twig', array('check' => $check,'gladiator'=>$gladiator));
    }

    /**
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/fight/{id}", name="next_round")
     */
    public function nextRoundAction(string $id)
    {

        $em = $this->getDoctrine()->getManager();
        $allItemsToFilltheView = $this->get('fight_service')->allItems($em,$id);
        return $this->render('game/fight.html.twig', $allItemsToFilltheView);
    }

    /**
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/waiting/{id}", name="waiting")
     */
    public function waitingAction(string $id)
    {
        return $this->render('game/arena_waiting_connect.html.twig', array('id'=>$id));
    }

    /**
     * @param $id
     * @Route("/fight/dices/{id}", name="dices")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function throwDicesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        // check if is your turn
        $isYourTurn=$this->get("fight_service")->isYourTurn($em,$id);
        if ($isYourTurn) {
            $round = $this->get("fight_service")->getRoundNumber($em, $id);
            $dices = $this->get('fight_service')->throwDices($em, $id, $round);
            $roundResult = $dices['roundResult'];
            //check is FightFinished
            $checkFight = $this->get('fight_service')->checkIfFightIsFinished($em, $roundResult);
            $notification = $this->get('fight_service')->notificationSend($em, $roundResult, $checkFight);
            if ($checkFight) {
                return $this->render('game/dices_end.html.twig', ['dices' => $dices]);
            }else{
            return $this->render('game/dices.html.twig', ['dices' => $dices]);
             }
        } else {
            return $this->render('game/arena_waiting_turn.html.twig', array('id'=>$id));
        }
    }

    public function renderNotificationAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository(notification::class)->findBy(['toUser'=>$id]);
        return $this->render('partials/notification_list.html.twig',['notifications'=>$notifications,'id'=>$id]);
    }

    /**
     * @param $notId
     * @Route("/fight/delete-notification/{notId}", name="delete_notification")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function geleteNotification( $notId)
    {
        $em = $this->getDoctrine()->getManager();
        $not=$em->getRepository(notification::class)->findOneBy(['id'=>$notId]);
        $em->remove($not);
        $em->flush();
        return $this->redirectToRoute('dashboard');

    }
}
