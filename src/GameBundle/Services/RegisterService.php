<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 11.12.2016 г.
 * Time: 14:05
 */

namespace GameBundle\Services;


use Doctrine\Common\Collections\ArrayCollection;
use GameBundle\Entity\gladiators;
use GameBundle\Entity\gladStats;
use GameBundle\Entity\PlayerStats;
use GameBundle\Entity\User;

class RegisterService
{
    const REGISTER_GLADIATOR_NUMBER = 3;

    public function registerStats(User $user)
    {
        $stats = new PlayerStats();
        $stats->setUsers($user);
        return $stats;
    }

    public function registerGladiators(User $user)
    {
        $gladiators=[];
        for ($i=0;$i<self::REGISTER_GLADIATOR_NUMBER;$i++){
            $gladiator= new gladiators();
            $gladiator->setUser($user);
            $gladiator->setName($user->getUsername().'_'.($i+1));
            $gladiators[]=$gladiator;
        }
        return $gladiators;
    }

    public function registerGladStats(gladiators $gladiator)
    {
        $gladStats = new gladStats($gladiator);
        $gladStats->setGladiator($gladiator);
        return $gladStats;
    }

}