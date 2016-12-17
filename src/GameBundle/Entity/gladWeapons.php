<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * gladWeapons
 *
 * @ORM\Table(name="glad_weapons")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\gladWeaponsRepository")
 */
class gladWeapons
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="roundLeft", type="integer")
     */
    private $roundLeft;

    /**
     * @var int
     *
     * @ORM\Column(name="equipped", type="integer")
     */
    private $equipped;

    /**
     * @var gladiators
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\gladiators", inversedBy="gladWeapons")
     * @ORM\JoinColumn(name="glad_id")
     */
    private $gladiator;

    /**
     * @var Weapons;
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Weapons", inversedBy="gladWeapons")
     * @ORM\JoinColumn(name="weapon_id")
     */
    private $weapons;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roundLeft
     *
     * @param integer $roundLeft
     * @return gladWeapons
     */
    public function setRoundLeft($roundLeft)
    {
        $this->roundLeft = $roundLeft;

        return $this;
    }

    /**
     * Get roundLeft
     *
     * @return integer 
     */
    public function getRoundLeft()
    {
        return $this->roundLeft;
    }

    /**
     * Set equipped
     *
     * @param integer $equipped
     * @return gladWeapons
     */
    public function setEquipped($equipped)
    {
        $this->equipped = $equipped;

        return $this;
    }

    /**
     * Get equipped
     *
     * @return integer 
     */
    public function getEquipped()
    {
        return $this->equipped;
    }

    /**
     * @return gladiators
     */
    public function getGladiator()
    {
        return $this->gladiator;
    }

    /**
     * @param gladiators $gladiator
     */
    public function setGladiator($gladiator)
    {
        $this->gladiator = $gladiator;
    }

    /**
     * @return Weapons
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

    /**
     * @param Weapons $weapons
     */
    public function setWeapons($weapons)
    {
        $this->weapons = $weapons;
    }


}
