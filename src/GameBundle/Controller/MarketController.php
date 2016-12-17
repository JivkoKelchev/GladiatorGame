<?php

namespace GameBundle\Controller;

use GameBundle\Entity\Armor;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\Weapons;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MarketController extends Controller
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/market/{id}", name="market")
     */
    public function indexAction($id)
    {
        $weapons = $this->getDoctrine()->getRepository(Weapons::class);
        $weapons = $weapons->findAll();
        $armors = $this->getDoctrine()->getRepository(Armor::class);
        $armors = $armors->findAll();
        return $this->render('game/market.html.twig', array('weapons' => $weapons,'armors'=>$armors,'gladId'=>$id));
    }

    /**
     * @param $gladId
     * @param $weaponId
     * @Route("/market/buy-weapon/{gladId}/{weaponId}", name="buy_weapon")
     */
    public function buyWeaponAction($gladId, $weaponId)
    {
        $em=$this->getDoctrine()->getManager();
        $weapon = $em->getRepository(Weapons::class)->findOneBy(['id'=>$weaponId]);
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $checkGladStr = $this->get("inventory_service")->checkGladWeaponDependency($em, $gladId, $weaponId);
        if ($checkGladStr=== true){
            $this->get('inventory_service')->buyWeapon($em,$gladId,$weaponId);
            return $this->render('game/market_success.html.twig', array('weapon' => $weapon,'glad'=>$glad));
        } else {
            return $this->render('game/market_fail.html.twig', array('weapon' => $weapon,'glad'=>$glad, 'msg'=>$checkGladStr));
        }
    }

    /**
     * @param $gladId
     * @param $armorId
     * @Route("/market/buy-armor/{gladId}/{armorId}", name="buy_armor")
     */
    public function buyArmorAction($gladId, $armorId)
    {
        $em=$this->getDoctrine()->getManager();
        $armor = $em->getRepository(Weapons::class)->findOneBy(['id'=>$armorId]);
        $glad = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $checkGladStr = $this->get("inventory_service")->checkGladArmorDependency($em, $gladId, $armorId);
        if ($checkGladStr=== true){
            $this->get('inventory_service')->buyArmor($em,$gladId,$armorId);
            return $this->render('game/market_success.html.twig', array('weapon' => $armor,'glad'=>$glad));
        } else {
            return $this->render('game/market_fail.html.twig', array('weapon' => $armor,'glad'=>$glad, 'msg'=>$checkGladStr));
        }
    }
}
