<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fights
 *
 * @ORM\Table(name="fights")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\FightsRepository")
 */
class Fights
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
     * @ORM\Column(name="glad1", type="integer", nullable=true, unique=true)
     */
    private $glad1;

    /**
     * @var int
     *
     * @ORM\Column(name="glad2", type="integer", nullable=true, unique=true)
     */
    private $glad2;


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
     * Set glad1
     *
     * @param integer $glad1
     * @return Fights
     */
    public function setGlad1($glad1)
    {
        $this->glad1 = $glad1;

        return $this;
    }

    /**
     * Get glad1
     *
     * @return integer 
     */
    public function getGlad1()
    {
        return $this->glad1;
    }

    /**
     * Set glad2
     *
     * @param integer $glad2
     * @return Fights
     */
    public function setGlad2($glad2)
    {
        $this->glad2 = $glad2;

        return $this;
    }

    /**
     * Get glad2
     *
     * @return integer 
     */
    public function getGlad2()
    {
        return $this->glad2;
    }
}
