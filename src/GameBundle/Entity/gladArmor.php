<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * gladArmor
 *
 * @ORM\Table(name="glad_armor")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\gladArmorRepository")
 */
class gladArmor
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
     * @ORM\Column(name="equipped", type="integer")
     */
    private $equipped;

    /**
     * @var gladiators
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\gladiators", inversedBy="gladArmor")
     * @ORM\JoinColumn(name="glad_id")
     */
    private $gladiator;

    /**
     * @var Armor
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Armor", inversedBy="gladArmor")
     * @ORM\JoinColumn(name="armor_id")
     */
    private $armor;


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
     * Set equipped
     *
     * @param integer $equipped
     * @return gladArmor
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
     * @return Armor
     */
    public function getArmor()
    {
        return $this->armor;
    }

    /**
     * @param Armor $armor
     */
    public function setArmor($armor)
    {
        $this->armor = $armor;
    }

}
