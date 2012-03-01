<?php

namespace Koyaan\GlobeBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Koyaan\GlobeBundle\Entity\Globe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Koyaan\GlobeBundle\Entity\GlobeRepository")
 */
class Globe
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
     * @var datetime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    
    private $name;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var text $data
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    /**
     * @var text $picture
     *
     * @ORM\Column(name="picture", type="text")
     */
    private $picture;

    /**
     * @var string $accessToken
     *
     * @ORM\Column(name="accessToken", type="string", length=255)
     */
    private $accessToken;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;


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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set data
     *
     * @param text $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get data
     *
     * @return text 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set picture
     *
     * @param text $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get picture
     *
     * @return text 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Get accessToken
     *
     * @return string 
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }
    
    /**
     * Get created_at
     * @return datetime 
     */
    public function getCreated_At()
    {
        return $this->created_at;
    }
}