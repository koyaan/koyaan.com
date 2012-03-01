<?php

namespace Koyaan\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @var string
     * 
     */
    protected $twitterID;

    /**
     * @var string
     */
    protected $twitter_username;

    /**
     * Set twitterID
     *
     * @param string $twitterID
     */
    public function setTwitterID($twitterID) {
        $this->twitterID = $twitterID;
        $this->setUsername($twitterID);
        $this->salt = '';
    }

    /**
     * Get twitterID
     *
     * @return string 
     */
    public function getTwitterID() {
        return $this->twitterID;
    }

    /**
     * Set twitter_username
     *
     * @param string $twitterUsername
     */
    public function setTwitterUsername($twitterUsername) {
        $this->twitter_username = $twitterUsername;
    }

    /**
     * Get twitter_username
     *
     * @return string 
     */
    public function getTwitterUsername() {
        return $this->twitter_username;
    }

}