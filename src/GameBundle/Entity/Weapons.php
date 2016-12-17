<?php

namespace GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Weapons
 *
 * @ORM\Table(name="weapons")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\WeaponsRepository")
 */
class Weapons
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="goldCost", type="integer")
     */
    private $goldCost;

    /**
     * @var int
     *
     * @ORM\Column(name="requiredStr", type="integer")
     */
    private $requiredStr;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="attackModify", type="integer")
     */
    private $attackModify;

    /**
     * @var int
     *
     * @ORM\Column(name="roundLife", type="integer")
     */
    private $roundLife;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, unique=true)
     */
    private $img;

    /**
     * @var gladWeapons []
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\gladWeapons", mappedBy="weapons")
     */
    private $gladWeapons;

    public function __construct()
    {
        $this->gladWeapons = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Weapons
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Weapons
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set goldCost
     *
     * @param integer $goldCost
     * @return Weapons
     */
    public function setGoldCost($goldCost)
    {
        $this->goldCost = $goldCost;

        return $this;
    }

    /**
     * Get goldCost
     *
     * @return integer 
     */
    public function getGoldCost()
    {
        return $this->goldCost;
    }

    /**
     * Set requiredStr
     *
     * @param integer $requiredStr
     * @return Weapons
     */
    public function setRequiredStr($requiredStr)
    {
        $this->requiredStr = $requiredStr;

        return $this;
    }

    /**
     * Get requiredStr
     *
     * @return integer 
     */
    public function getRequiredStr()
    {
        return $this->requiredStr;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Weapons
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set attackModify
     *
     * @param integer $attackModify
     * @return Weapons
     */
    public function setAttackModify($attackModify)
    {
        $this->attackModify = $attackModify;

        return $this;
    }

    /**
     * Get attackModify
     *
     * @return integer 
     */
    public function getAttackModify()
    {
        return $this->attackModify;
    }

    /**
     * Set roundLife
     *
     * @param integer $roundLife
     * @return Weapons
     */
    public function setRoundLife($roundLife)
    {
        $this->roundLife = $roundLife;

        return $this;
    }

    /**
     * Get roundLife
     *
     * @return integer 
     */
    public function getRoundLife()
    {
        return $this->roundLife;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return Weapons
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return gladWeapons[]
     */
    public function getGladWeapons()
    {
        return $this->gladWeapons;
    }

    /**
     * @param gladWeapons[] $gladWeapons
     */
    public function setGladWeapons($gladWeapons)
    {
        $this->gladWeapons = $gladWeapons;
    }


}
