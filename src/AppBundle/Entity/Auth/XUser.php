<?php

namespace AppBundle\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Account\Profile;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="x_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Auth\XUserRepository")
 */
class XUser  implements UserInterface, EquatableInterface {

    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length = 100)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length = 100)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length = 255)
     *
     */
    protected $password;

    /**
     * Random string sent to the user email address in order to verify it
     *
     * @var string
     * @ORM\Column(name = "confirmation_token", type="string", nullable = true)
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     * @ORM\Column(name = "password_requested_at", type="datetime", nullable = true)
     */
    protected $passwordRequestedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name = "last_login", type="datetime", nullable = true)
     */
    protected $lastLogin;

    /**
     * @var array
     * @ORM\Column(type="array")
     *
     */
    protected $roles;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @var Profile $profile
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Account\Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", nullable=true)
     */
    private $profile=null;

    public function __construct(){
        $this->enabled = true;
        $this->roles = array();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof XUser) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Gets the timestamp that the user requested a password reset.
     *
     * @return null|\DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @param \DateTime|null $date
     */
    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        $this->passwordRequestedAt = $date;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * @param string $role
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
        return;
    }

    /**
     * @param $role
     * @return $this
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }

    /**
     * @return boolean
     */
    public function hasProfile() {
        return $this->profile!==null;
    }

    /**
     * @return string
     */
    public function getFullName() {
        if($this->profile!==null){
            return $this->profile->getFirstName().' '.$this->profile->getLastName();
        } else {
            return $this->username;
        }
    }

    /**
     * @return string
     */
    public function getName() {
        if($this->profile!==null){
            return $this->profile->getFirstName();
        } else {
            return $this->username;
        }
    }

    /**
     * @return Profile
     */
    public function getProfile(){
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile($profile){
        $this->profile = $profile;
    }
}
