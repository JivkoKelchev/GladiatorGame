<?php

namespace GameBundle\Controller;

use GameBundle\Entity\gladiators;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class StatsRenderController extends Controller
{

    public function renderStatsAction()
    {

        $user=$this->getUser();

        /** @var \GameBundle\Entity\User $user */
        $gold= $user->getStats()->getGold();
        $score= $user->getStats()->getPoints();
        $username=$user->getUsername();
        return $this->render("partials\stats.html.twig",['username'=>$username,
                                                         'gold'=>$gold,
                                                          'score'=> $score  ]);

    }

    public function renderAttMinMaxAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$id]);
        $result = $this->get('fight_service')->calculateAttakStat($em,$glad);
        return $this->render('partials/att_min_max.html.twig',$result);
    }

    public function renderDefAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$id]);
        $result = $this->get('fight_service')->calculateMaxDef($em,$glad);
        return $this->render('partials/def_max.html.twig',['max_def'=>$result]);
    }

    public function renderXpForNexLevelAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$id]);
        $xp = $glad->getXP();
        $level = $glad->getLevel();
        $xpForNexLevel = $this->get('fight_service')->calculateXpForNextLevel($glad);
        return $this->render('partials/xp_for_next_level.html.twig',['xp_for_next_level'=>$xpForNexLevel,
                                                                     'xp'=>$xp,
                                                                     'level'=>$level]);
    }
}
