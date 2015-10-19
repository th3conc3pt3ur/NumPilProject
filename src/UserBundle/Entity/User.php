<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $usernameCanonical;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $emailCanonical;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * The salt to use for hashing
     *
     * @var string
     */
    protected $salt;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @var \DateTime
     */
    protected $lastLogin;

    /**
     * Random string sent to the user email address in order to verify it
     *
     * @var string
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     */
    protected $passwordRequestedAt;

    /**
     * @var Collection
     */
    protected $groups;

    /**
     * @var boolean
     */
    protected $locked;

    /**
     * @var boolean
     */
    protected $expired;

    /**
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var boolean
     */
    protected $credentialsExpired;

    /**
     * @var \DateTime
     */
    protected $credentialsExpireAt;

    /**
     * @var boolean
     * @ORM\Column(name="passager",type="boolean")
     */
    private $passager = false;

    /**
     * @var boolean
     * @ORM\Column(name="pilote",type="boolean")
     */
    private $pilote = false;

    /**
     * @var boolean
     * @ORM\Column(name="gestionnaire",type="boolean")
     */
    private $gestionnaire = false;

    /**
     * @var boolean
     * @ORM\Column(name="responsable",type="boolean")
     */
    private $responsable = false;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set passager
     *
     * @param boolean $passager
     *
     * @return User
     */
    public function setPassager($passager)
    {
        $this->passager = $passager;

        return $this;
    }

    /**
     * Get passager
     *
     * @return boolean
     */
    public function getPassager()
    {
        return $this->passager;
    }

    /**
     * Set pilote
     *
     * @param boolean $pilote
     *
     * @return User
     */
    public function setPilote($pilote)
    {
        $this->pilote = $pilote;

        return $this;
    }

    /**
     * Get pilote
     *
     * @return boolean
     */
    public function getPilote()
    {
        return $this->pilote;
    }

    /**
     * Set gestionnaire
     *
     * @param boolean $gestionnaire
     *
     * @return User
     */
    public function setGestionnaire($gestionnaire)
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * Get gestionnaire
     *
     * @return boolean
     */
    public function getGestionnaire()
    {
        return $this->gestionnaire;
    }

    /**
     * Set responsable
     *
     * @param boolean $responsable
     *
     * @return User
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return boolean
     */
    public function getResponsable()
    {
        return $this->responsable;
    }
}
