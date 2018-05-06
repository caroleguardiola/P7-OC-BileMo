<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_user_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *     ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_user", "list_users", "create_user", "detail_address"})
 * )
 *  @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "app_users_list",
 *          absolute = true
 *     ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_user", "list_users", "create_user"})
 * )
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "app_user_create",
 *          absolute = true
 *     ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_user", "list_users", "create_user"})
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "app_user_delete",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_user", "list_users", "create_user"})
 * )
 * @Hateoas\Relation(
 *     "addresses",
 *     embedded = @Hateoas\Embedded("expr(object.getAddresses())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_user", "create_user"})
 * )
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list_users"})
     * @Serializer\Since("1.0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"list_users", "detail_user", "create_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank(groups={"Create_User"})
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "create_user"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank(groups={"Create_User"})
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $firstName;
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "create_user"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank(groups={"Create_User"})
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"detail_user", "create_user"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank(groups={"Create_User"})
     * @Assert\Email
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     *
     * @Serializer\Groups({"detail_user", "create_user"})
     * @Serializer\Since("1.0")
     *
     * @Assert\Type(type="bool")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, unique=true)
     *
     * @Serializer\Groups({"none"})
     */
    private $password;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"none"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank(groups={"Create_User"})
     * @Assert\Type(type="string")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer", cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\Valid()
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Address", mappedBy="user", cascade={"persist","remove"})
     *
     * @Serializer\Groups({"none"})
     */
    private $addresses;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     *
     * @Serializer\Groups({"none"})
     */
    private $dateCreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     *
     * @Serializer\Groups({"none"})
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime", nullable=true)
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\DateTime()
     */
    private $dateDeactivation;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->dateCreation = new \Datetime();
        $this->addresses = new ArrayCollection();
        $this->isActive = true;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return User
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set dateDeactivation.
     *
     * @param \DateTime|null $dateDeactivation
     *
     * @return User
     */
    public function setDateDeactivation($dateDeactivation = null)
    {
        $this->dateDeactivation = $dateDeactivation;

        return $this;
    }

    /**
     * Get dateDeactivation.
     *
     * @return \DateTime|null
     */
    public function getDateDeactivation()
    {
        return $this->dateDeactivation;
    }

    /**
     * Set customer.
     *
     * @param Customer $customer
     *
     * @return User
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add address.
     *
     * @param Address $address
     *
     * @return User
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
        $address->setUser($this);

        return $this;
    }

    /**
     * Remove address.
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAddress(Address $address)
    {
        return $this->addresses->removeElement($address);
    }

    /**
     * Get addresses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
        ));
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            ) = unserialize($serialized);
    }
    public function isAccountNonExpired()
    {
        return true;
    }
    public function isAccountNonLocked()
    {
        return true;
    }
    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->isActive;
    }
    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * Get isActive.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }
}
