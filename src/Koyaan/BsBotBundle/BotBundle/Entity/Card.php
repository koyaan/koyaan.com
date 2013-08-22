<?php

namespace Koyaan\BsBotBundle\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koyaan\BsBotBundle\BotBundle\Entity\Card
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Koyaan\BsBotBundle\BotBundle\Entity\CardRepository")
 */
class Card
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * @ORM\OneToMany(targetEntity="Buzzword", mappedBy="card")
     */
    protected $buzzwords;

    public function __construct()
    {
        $this->buzzwords = new ArrayCollection();
    }

    /**
     * Add buzzwords
     *
     * @param Koyaan\BsBotBundle\BotBundle\Entity\Buzzword $buzzwords
     */
    public function addBuzzword(Koyaan\BsBotBundle\BotBundle\Entity\Buzzword $buzzwords)
    {
        $this->buzzwords[] = $buzzwords;
    }

    /**
     * Get buzzwords
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBuzzwords()
    {
        return $this->buzzwords;
    }
}