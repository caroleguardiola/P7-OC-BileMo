<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_brand_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone", "list_brands", "detail_brand"})
 * )
 * @Hateoas\Relation(
 *     "mobilephones",
 *     embedded = @Hateoas\Embedded("expr(object.getMobilePhones())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_brand"})
 * )
 */
class Brand
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list_brands"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"detail_mobilephone", "list_brands", "detail_brand"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MobilePhone", mappedBy="brand", cascade={"persist","remove"})
     *
     * @Serializer\Groups({"none"})
     */
    private $mobilePhones;
    
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
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     *
     * @Serializer\Groups({"none"})
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     *
     * @Serializer\Groups({"none"})
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
     * @return Brand
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
     * @param \DateTime $dateCreation
     *
     * @return Brand
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
     * @return Brand
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
     * @return Brand
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
     * Add mobilePhone.
     *
     * @param MobilePhone $mobilePhone
     *
     * @return Brand
     */
    public function addMobilePhone(MobilePhone $mobilePhone)
    {
        $this->mobilePhones[] = $mobilePhone;
        $mobilePhone->setBrand($this);

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
