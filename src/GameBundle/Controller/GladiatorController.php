<?php

namespace GameBundle\Controller;

use GameBundle\Entity\Armor;
use GameBundle\Entity\gladArmor;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\gladStats;
use GameBundle\Entity\gladWeapons;
use GameBundle\Entity\Weapons;
use GameBundle\Form\LpType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;

class GladiatorController extends Controller
{
    /**
     * @param $id
     * @Route("/gladiator/{id}", name="gladiator_stats")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $gladRepository = $this->getDoctrine()->getRepository(gladiators::class);
        /**
         * @var gladiators
         */
        $gladiator=$gladRepository->findOneBy(['id'=>$id]);
        return $this->render('game/gladiator.html.twig', array('gladiator' => $gladiator));
    }

    public function gladInventoryWeaponsAction(gladiators $gladiator)
    {
        $weapons = $gladiator->getGladWeapons();
        return $this->render('partials/InventoryWeapons.html.twig',['weapons'=>$weapons,'gladiator'=>$gladiator]);
    }

    public function gladInventoryArmorAction(gladiators $gladiator)
    {
        $armors = $gladiator->getGladArmor();
        return $this->render('partials/InventoryArmor.html.twig',['armors'=>$armors,'gladiator'=>$gladiator]);
    }


    public function renderArmorEquippedAction(gladiators $gladiator)
    {
        $image = $this->get('inventory_service')->renderArmorPicture($gladiator);
        return $this->render('partials/armorEquppedImage.html.twig',['image'=>$image]);
    }


    public function renderWeaponsEquippedAction(gladiators $gladiator)
    {
        $images = $this->get('inventory_service')->renderWeaponsPicture($gladiator);

        return $this->render('partials/weaponsEquppedImage.html.twig',['images'=>$images]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/gladiator/lp/{id}", name="manage_lp")
     */
    public function mangeLpAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $gladRepository = $this->getDoctrine()->getRepository(gladiators::class);
        $gladiator=$gladRepository->findOneBy(['id'=>$id]);
        $gladLp = $gladiator->getLP();
        $gladStats = $this->getDoctrine()->getRepository(gladStats::class)->findOneBy(['gladiator'=>$id]);
        $msg='';
        $data = [];
        $form = $this->createFormBuilder($data)
            ->add('str', NumberType::class)
            ->add('dex', NumberType::class)
            ->add('int', NumberType::class)->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();
            if(array_sum($data)>$gladLp) {
                $msg = 'You have only ' . $gladLp . ' LP';
                return $this->render('game/gladiator_lp.html.twig', array('gladiator' => $gladiator, 'form' => $form->createView(), 'msg' => $msg));
            }else{
               $newStr = $gladStats->getStr() + $data['str'];
               $newDex = $gladStats->getDex() + $data['dex'];
                $newInt = $gladStats->getIntelligence() + $data['int'];
                $gladStats->setStr($newStr);
                $gladStats->setDex($newDex);
                $gladStats->setIntelligence($newInt);
                $em->persist($gladStats);
                $em->flush();
                return $this->redirectToRoute('gladiator_stats',['id'=>$gladiator->getId()]);
            }
        }
        return $this->render('game/gladiator_lp.html.twig', array('gladiator' => $gladiator,'form' =>$form->createView(),'msg'=>$msg ));
    }

    public function renderHpStatsAction (gladiators $gladiator)
    {
        $maxHp = $this->get('fight_service')->calculateMaxHp($gladiator);
        $hp = $gladiator->getHP();
        $percentage=$hp/$maxHp*100;
        return $this->render('partials/hp.html.twig',['hp'=>$hp,'maxHp'=>$maxHp,'percentage'=>$percentage]);
    }


    /**
     * @param $gladId
     * @param $weaponId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param gladiators $gladiator
     * @internal param Weapons $weapon
     * @Route("/gladiator/equip-weapon/{gladId}/{weaponId}",name="equip_weapon")
     */
    public function equipWeaponAction($gladId, $weaponId)
    {
        $em = $this->getDoctrine()->getManager();
        $gladiator = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $weapon = $em->getRepository(Weapons::class)->findOneBy(['id'=>$weaponId]);
        $oldWeapon = $em->getRepository(gladWeapons::class)->findOneBy(['gladiator'=>$gladiator->getId(),'equipped'=>1]);
        $newWeapon = $em->getRepository(gladWeapons::class)->findOneBy(['gladiator'=>$gladiator->getId(),'weapons'=>$weapon->getId()]);
        if($oldWeapon) {
            $oldWeapon->setEquipped(0);
            $em->persist($oldWeapon);
            $em->flush();
        }
        $newWeapon->setEquipped(1);
        $em->persist($newWeapon);
        $em->flush();
        return $this->redirectToRoute('gladiator_stats',['id'=>$gladiator->getId()]);
    }

    /**
     * @param $gladId
     * @param $armorId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/gladiator/equip-armor/{gladId}/{armorId}",name="equip_armor")
     */
    public function equipArmorAction($gladId, $armorId)
    {
        $em = $this->getDoctrine()->getManager();
        $gladiator = $em->getRepository(gladiators::class)->findOneBy(['id'=>$gladId]);
        $armor = $em->getRepository(Armor::class)->findOneBy(['id'=>$armorId]);
        $oldArmor = $em->getRepository(gladArmor::class)->findOneBy(['gladiator'=>$gladiator->getId(),'equipped'=>1]);
        $newArmor = $em->getRepository(gladArmor::class)->findOneBy(['gladiator'=>$gladiator->getId(),'armor'=>$armor->getId()]);
        if($oldArmor) {
            $oldArmor->setEquipped(0);
            $em->persist($oldArmor);
            $em->flush();
        }
        $newArmor->setEquipped(1);
        $em->persist($newArmor);
        $em->flush();
        return $this->redirectToRoute('gladiator_stats',['id'=>$gladiator->getId()]);
    }
}
