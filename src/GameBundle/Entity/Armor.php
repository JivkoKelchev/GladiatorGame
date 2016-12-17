<?php

namespace GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Armor
 *
 * @ORM\Table(name="armor")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\ArmorRepository")
 */
class Armor
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
     * @ORM\Column(name="requiredLevel", type="integer")
     */
    private $requiredLevel;

    /**
     * @var int
     *
     * @ORM\Column(name="reqiredStr", type="integer")
     */
    private $reqiredStr;

    /**
     * @var int
     *
     * @ORM\Column(name="defModify", type="integer")
     */
    private $defModify;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, unique=true)
     */
    private $img;

    /**
     * @var gladArmor []
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\gladArmor", mappedBy="armor")
     */
    private $gladArmor;

    public function __construct()
    {
        $this->gladArmor = new ArrayCollection();
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
     * @return Armor
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
     * @return Armor
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
     * @return Armor
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
     * Set requiredLevel
     *
     * @param integer $requiredLevel
     * @return Armor
     */
    public function setRequiredLevel($requiredLevel)
    {
        $this->requiredLevel = $requiredLevel;

        return $this;
    }

    /**
     * Get requiredLevel
     *
     * @return integer 
     */
    public function getRequiredLevel()
    {
        return $this->requiredLevel;
    }

    /**
     * Set reqiredStr
     *
     * @param integer $reqiredStr
     * @return Armor
     */
    public function setReqiredStr($reqiredStr)
    {
        $this->reqiredStr = $reqiredStr;

        return $this;
    }

    /**
     * Get reqiredStr
     *
     * @return integer 
     */
    public function getReqiredStr()
    {
        return $this->reqiredStr;
    }

    /**
     * Set defModify
     *
     * @param integer $defModify
     * @return Armor
     */
    public function setDefModify($defModify)
    {
        $this->defModify = $defModify;

        return $this;
    }

    /**
     * Get defModify
     *
     * @return integer 
     */
    public function getDefModify()
    {
        return $this->defModify;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return Armor
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
     * @return gladArmor[]
     */
    public function getGladArmor()
    {
        return $this->gladArmor;
    }

    /**
     * @param gladArmor[] $gladArmor
     */
    public function setGladArmor($gladArmor)
    {
        $this->gladArmor = $gladArmor;
    }


}
