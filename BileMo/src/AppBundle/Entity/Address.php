<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_address_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_address", "detail_user"})
 * )
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="recipient", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $recipient;

    /**
     * @var string
     *
     * @ORM\Column(name="street_address", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $streetAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=5)
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=5)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", cascade={"persist"}, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid()
     */
    private $user;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     *
     * @Serializer\Groups({"detail_user", "detail_address"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="bool")
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     */
    private $dateDeactivation;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \Datetime();
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
     * Set recipient.
     *
     * @param string $recipient
     *
     * @return Address
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient.
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set streetAddress.
     *
     * @param string $streetAddress
     *
     * @return Address
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress.
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set zipCode.
     *
     * @param string $zipCode
     *
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set dateCreation.
     *
     * @param datetime_immutable $dateCreation
     *
     * @return Address
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return datetime_immutable
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
     * @param datetime_immutable|null $updatedAt
     *
     * @return Address
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return datetime_immutable|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set dateDeactivation.
     *
     * @param datetime_immutable|null $dateDeactivation
     *
     * @return Address
     */
    public function setDateDeactivation($dateDeactivation = null)
    {
        $this->dateDeactivation = $dateDeactivation;

        return $this;
    }

    /**
     * Get dateDeactivation.
     *
     * @return datetime_immutable|null
     */
    public function getDateDeactivation()
    {
        return $this->dateDeactivation;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Address
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Address
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
