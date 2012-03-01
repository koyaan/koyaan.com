<?php

namespace Koyaan\BattleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Koyaan\BattleBundle\Entity\Battle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Koyaan\BattleBundle\Entity\BattleRepository")
 */
class Battle
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
     * @var string $video1
     *
     * @ORM\Column(name="video1", type="string", length=255)
     */
    private $video1;

    /**
     * @var string $video2
     *
     * @ORM\Column(name="video2", type="string", length=255)
     */
    private $video2;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer $votes1
     *
     * @ORM\Column(name="votes1", type="integer")
     */
    private $votes1;

    /**
     * @var integer $votes2
     *
     * @ORM\Column(name="votes2", type="integer")
     */
    private $votes2;
    
    /**
     * Constructor
     * initialize votes to 0 
     */
    public function __construct( ) {
        $this->setVotes1(0);
        $this->setVotes2(0);
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
     * Set video1
     *
     * @param string $video1
     */
    public function setVideo1($video1)
    {
        $this->video1 = $video1;
    }

    /**
     * Get video1
     *
     * @return string 
     */
    public function getVideo1()
    {
        return $this->video1;
    }

    /**
     * Set video2
     *
     * @param string $video2
     */
    public function setVideo2($video2)
    {
        $this->video2 = $video2;
    }

    /**
     * Get video2
     *
     * @return string 
     */
    public function getVideo2()
    {
        return $this->video2;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *ŝ
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set votes1
     *
     * @param integer $votes1
     */
    public function setVotes1($votes1)
    {
        $this->votes1 = $votes1;
    }

    /**
     * Get votes1
     *
     * @return integer 
     */
    public function getVotes1()
    {
        return $this->votes1;
    }

    /**
     * Set votes2
     *
     * @param integer $votes2
     */
    public function setVotes2($votes2)
    {
        $this->votes2 = $votes2;
    }

    /**
     * Get votes2
     *
     * @return integer 
     */
    public function getVotes2()
    {
        return $this->votes2;
    }
    
     /**
     * Get video ID 1
     *
     * @return integer 
     */
    public function getVideoID1()   {
        
        $url = parse_url($this->getVideo1());
        parse_str($url['query'], $query);
        
        if(isset($query["v"]))   {
            return $query["v"];
        } else {
            return null;
        }
    }
    
     /**
     * Get video ID 2
     *
     * @return integer 
     */    
    public function getVideoID2()   {
        
        $url = parse_url($this->getVideo2());
        parse_str($url['query'], $query);
        
        if(isset($query["v"]))   {
            return $query["v"];
        } else {
            return null;
        }
    }
    
     /**
     * Get voting results
     *
     * @return array
     */
    
    public function getResults()    {
        $votes1 = $this->getVotes1();
        $votes2 = $this->getVotes2();
        $votecount = $votes1 + $votes2;
        if($votecount == 0) {
            return array(0,0);
        }   
        return array(($votes1 /$votecount)*100,($votes2 /$votecount)*100);
    }
    
}