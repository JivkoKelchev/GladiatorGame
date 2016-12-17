<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * gladStats
 *
 * @ORM\Table(name="glad_stats")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\gladStatsRepository")
 */
class gladStats
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
     * @ORM\Column(name="str", type="integer")
     */
    private $str=5;

    /**
     * @var int
     *
     * @ORM\Column(name="dex", type="integer")
     */
    private $dex=0;

    /**
     * @var int
     *
     * @ORM\Column(name="intelligence", type="integer")
     */
    private $intelligence=5;

    /**
     * @var int
     *
     * @ORM\Column(name="deff", type="integer")
     */
    private $deff=0;

    /**
     * @var gladiators
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\gladiators", inversedBy="gladStats")
     * @ORM\JoinColumn(name="glad_id")
     */
    private $gladiator;


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
     * Set str
     *
     * @param integer $str
     * @return gladStats
     */
    public function setStr($str)
    {
        $this->str = $str;

        return $this;
    }

    /**
     * Get str
     *
     * @return integer 
     */
    public function getStr()
    {
        return $this->str;
    }

    /**
     * Set dex
     *
     * @param integer $dex
     * @return gladStats
     */
    public function setDex($dex)
    {
        $this->dex = $dex;

        return $this;
    }

    /**
     * Get dex
     *
     * @return integer 
     */
    public function getDex()
    {
        return $this->dex;
    }

    /**
     * Set intelligence
     *
     * @param integer $intelligence
     * @return gladStats
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    /**
     * Get intelligence
     *
     * @return integer 
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set deff
     *
     * @param integer $deff
     * @return gladStats
     */
    public function setDeff($deff)
    {
        $this->deff = $deff;

        return $this;
    }

    /**
     * Get deff
     *
     * @return integer 
     */
    public function getDeff()
    {
        return $this->deff;
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



}
