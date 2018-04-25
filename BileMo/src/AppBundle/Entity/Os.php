<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * Os
 *
 * @ORM\Table(name="os")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OsRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_os_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone", "detail_os"})
 * )
 */
class Os
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"detail_mobilephone", "detail_os"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MobilePhone", mappedBy="os", cascade={"persist","remove"})
     */
    private $mobilePhones;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDeactivation", type="datetime", nullable=true)
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
        $this->mobilePhones = new ArrayCollection();

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
     * Set name.
     *
     * @param string $name
     *
     * @return Os
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateCreation.
     *
     * @param datetime_immutable $dateCreation
     *
     * @return Os
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
     * @return Os
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
     * @return Os
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
     * Add mobilePhone.
     *
     * @param MobilePhone $mobilePhone
     *
     * @return Os
     */
    public function addMobilePhone(MobilePhone $mobilePhone)
    {
        $this->mobilePhones[] = $mobilePhone;
        $mobilePhone->setOs($this);

        return $this;
    }

    /**
     * Remove mobilePhone.
     *
     * @param MobilePhone $mobilePhone
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMobilePhone(MobilePhone $mobilePhone)
    {
        return $this->mobilePhones->removeElement($mobilePhone);
    }

    /**
     * Get mobilePhones.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMobilePhones()
    {
        return $this->mobilePhones;
    }
}
