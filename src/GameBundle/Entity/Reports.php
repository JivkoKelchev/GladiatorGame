<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reports
 *
 * @ORM\Table(name="reports")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\ReportsRepository")
 */
class Reports
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
     * @ORM\Column(name="fightId", type="integer")
     */
    private $fightId;

    /**
     * @var int
     *
     * @ORM\Column(name="gladId", type="integer")
     */
    private $gladId;

    /**
     * @var int
     *
     * @ORM\Column(name="round", type="integer")
     */
    private $round;

    /**
     * @var int
     *
     * @ORM\Column(name="attDice", type="integer")
     */
    private $attDice;

    /**
     * @var int
     *
     * @ORM\Column(name="defDice", type="integer")
     */
    private $defDice;

    /**
     * @var int
     *
     * @ORM\Column(name="special", type="integer")
     */
    private $special = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    public function __construct()
    {
        $this->time = new \DateTime();
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
     * Set fightId
     *
     * @param integer $fightId
     * @return Reports
     */
    public function setFightId($fightId)
    {
        $this->fightId = $fightId;

        return $this;
    }

    /**
     * Get fightId
     *
     * @return integer 
     */
    public function getFightId()
    {
        return $this->fightId;
    }

    /**
     * Set gladId
     *
     * @param integer $gladId
     * @return Reports
     */
    public function setGladId($gladId)
    {
        $this->gladId = $gladId;

        return $this;
    }

    /**
     * Get gladId
     *
     * @return integer 
     */
    public function getGladId()
    {
        return $this->gladId;
    }

    /**
     * Set round
     *
     * @param integer $round
     * @return Reports
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return integer 
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set attDice
     *
     * @param integer $attDice
     * @return Reports
     */
    public function setAttDice($attDice)
    {
        $this->attDice = $attDice;

        return $this;
    }

    /**
     * Get attDice
     *
     * @return integer 
     */
    public function getAttDice()
    {
        return $this->attDice;
    }

    /**
     * Set defDice
     *
     * @param integer $defDice
     * @return Reports
     */
    public function setDefDice($defDice)
    {
        $this->defDice = $defDice;

        return $this;
    }

    /**
     * Get defDice
     *
     * @return integer 
     */
    public function getDefDice()
    {
        return $this->defDice;
    }

    /**
     * Set special
     *
     * @param integer $special
     * @return Reports
     */
    public function setSpecial($special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return integer 
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Reports
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }
}
