<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerStats
 *
 * @ORM\Table(name="player_stats")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\PlayerStatsRepository")
 */
class PlayerStats
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
     * @ORM\Column(name="points", type="integer")
     */
    private $points=0;

    /**
     * @var int
     *
     * @ORM\Column(name="gold", type="integer")
     */
    private $gold=30;

    /**
     * @var int
     *
     * @ORM\Column(name="wins", type="integer")
     */
    private $wins=0;

    /**
     * @var int
     *
     * @ORM\Column(name="losses", type="integer")
     */
    private $losses=0;


    /**
     * @var User
     * @ORM\OneToOne(targetEntity="GameBundle\Entity\User", inversedBy="stats")
     * @ORM\JoinColumn(name="user_id")
     */
    private $users;

    /**
     * @var notification
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\notification", mappedBy="toUser")
     */
    private $notification;

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
     * Set points
     *
     * @param integer $points
     * @return PlayerStats
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set gold
     *
     * @param integer $gold
     * @return PlayerStats
     */
    public function setGold($gold)
    {
        $this->gold = $gold;

        return $this;
    }

    /**
     * Get gold
     *
     * @return integer 
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * Set wins
     *
     * @param integer $wins
     * @return PlayerStats
     */
    public function setWins($wins)
    {
        $this->wins = $wins;

        return $this;
    }

    /**
     * Get wins
     *
     * @return integer 
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set losses
     *
     * @param integer $losses
     * @return PlayerStats
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;

        return $this;
    }

    /**
     * Get losses
     *
     * @return integer 
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }
}
