<?php

namespace Koyaan\BsBotBundle\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koyaan\BsBotBundle\BotBundle\Entity\Buzzword
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Koyaan\BsBotBundle\BotBundle\Entity\BuzzwordRepository")
 */
class Buzzword
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
     * @var string $word
     *
     * @ORM\Column(name="word", type="string", length=255)
     */
    private $word;


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
     * Set word
     *
     * @param string $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }
    
    /**
     * Get word
     *
     * @return string 
     */
    public function getWord()
    {
        return $this->word;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="buzzwords")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     */
    protected $card;


    /**
     * Set card
     *
     * @param Koyaan\BsBotBundle\BotBundle\Entity\Card $card
     */
    public function setCard(\Koyaan\BsBotBundle\BotBundle\Entity\Card $card)
    {
        $this->card = $card;
    }

    /**
     * Get card
     *
     * @return Koyaan\BsBotBundle\BotBundle\Entity\Card 
     */
    public function getCard()
    {
        return $this->card;
    }
}