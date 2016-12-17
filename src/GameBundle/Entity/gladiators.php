<?php

namespace GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * gladiators
 *
 * @ORM\Table(name="gladiators")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\gladiatorsRepository")
 */
class gladiators
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name='';

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level=1;

    /**
     * @var int
     *
     * @ORM\Column(name="XP", type="integer")
     */
    private $xP=0;

    /**
     * @var int
     *
     * @ORM\Column(name="HP", type="integer")
     */
    private $hP=25;

    /**
     * @var int
     *
     * @ORM\Column(name="LP", type="integer")
     */
    private $lP=2;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\User", inversedBy="gladiators")
     * @ORM\JoinColumn(name="user_id")
     */
    private $user;

    /**
     * @var gladStats
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\gladStats", mappedBy="gladiator")
     */
    private $gladStats;

    /**
     * @var gladArmor []
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\gladArmor", mappedBy="gladiator")
     */
    private $gladArmor;

    /**
     * @var gladWeapons []
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\gladWeapons", mappedBy="gladiator")
     */
    private $gladWeapons;

    public function __construct()
    {
        $this->gladArmor = new ArrayCollection();
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
     * @return gladiators
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
     * Set level
     *
     * @param integer $level
     * @return gladiators
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set xP
     *
     * @param integer $xP
     * @return gladiators
     */
    public function setXP($xP)
    {
        $this->xP = $xP;

        return $this;
    }

    /**
     * Get xP
     *
     * @return integer 
     */
    public function getXP()
    {
        return $this->xP;
    }

    /**
     * Set hP
     *
     * @param integer $hP
     * @return gladiators
     */
    public function setHP($hP)
    {
        $this->hP = $hP;

        return $this;
    }

    /**
     * Get hP
     *
     * @return integer 
     */
    public function getHP()
    {
        return $this->hP;
    }

    /**
     * Set lP
     *
     * @param integer $lP
     * @return gladiators
     */
    public function setLP($lP)
    {
        $this->lP = $lP;

        return $this;
    }

    /**
     * Get lP
     *
     * @return integer 
     */
    public function getLP()
    {
        return $this->lP;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return gladStats
     */
    public function getGladStats()
    {
        return $this->gladStats;
    }

    /**
     * @param gladStats $gladStats
     */
    public function setGladStats($gladStats)
    {
        $this->gladStats = $gladStats;
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
