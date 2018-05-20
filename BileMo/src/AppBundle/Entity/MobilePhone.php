<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 26/04/2018
 * Time: 18:23
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * MobilePhone
 *
 * @ORM\Table(name="mobile_phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobilePhoneRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_mobilephone_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"list_mobilephones", "detail_mobilephone", "detail_brand", "detail_os", "detail_image"})
 * )
 *  @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "app_mobilephones_list",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"list_mobilephones", "detail_mobilephone"})
 * )
 * @Hateoas\Relation(
 *     "brand",
 *     embedded = @Hateoas\Embedded("expr(object.getBrand())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone"})
 * )
 * @Hateoas\Relation(
 *     "os",
 *     embedded = @Hateoas\Embedded("expr(object.getOs())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone"})
 * )
 * @Hateoas\Relation(
 *     "images",
 *     embedded = @Hateoas\Embedded("expr(object.getImages())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone"})
 * )
 *
 */
class MobilePhone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list_mobilephones"})
     * @Serializer\Since("1.0")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"list_mobilephones", "detail_mobilephone", "detail_brand", "detail_os", "detail_image"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     *
     * @Serializer\Groups({"list_mobilephones", "detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity_gb", type="integer", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $capacityGb;

    /**
     * @var int
     *
     * @ORM\Column(name="display_inch", type="float", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $displayInch;

    /**
     * @var int
     *
     * @ORM\Column(name="camera_mp", type="integer", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $cameraMp;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=45)
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=45)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="height_mm", type="float", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $heightMm;

    /**
     * @var int
     *
     * @ORM\Column(name="width_mm", type="float", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $widthMm;

    /**
     * @var int
     *
     * @ORM\Column(name="depth_mm", type="float", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $depthMm;

    /**
     * @var int
     *
     * @ORM\Column(name="weight_grams", type="integer", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $weightGrams;

    /**
     * @var int
     *
     * @ORM\Column(name="price_euros", type="float", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="float")
     */
    private $priceEuros;

    /**
     * @var int
     *
     * @ORM\Column(name="price_cents", type="integer", options={"unsigned":true})
     *
     * @Serializer\Groups({"detail_mobilephone"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="int")
     */
    private $priceCents;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="mobilePhone", cascade={"persist","remove"})
     *
     * @Serializer\Groups({"none"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Brand", inversedBy="mobilePhones")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\NotBlank
     * @Assert\Valid()
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Os", inversedBy="mobilePhones")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\NotBlank
     * @Assert\Valid()
     */
    private $os;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="date_creation", type="datetime_immutable")
     *
     * @Serializer\Groups({"none"})
     */
    private $dateCreation;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     *
     * @Serializer\Groups({"none"})
     */
    private $updatedAt;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime_immutable", nullable=true)
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
        $this->dateCreation = new \Datetime();
        $this->images = new ArrayCollection();
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
     * Set model.
     *
     * @param string $model
     *
     * @return MobilePhone
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     *
     * @return MobilePhone
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set capacityGb.
     *
     * @param int $capacityGb
     *
     * @return MobilePhone
     */
    public function setCapacityGb($capacityGb)
    {
        $this->capacityGb = $capacityGb;

        return $this;
    }

    /**
     * Get capacityGb.
     *
     * @return int
     */
    public function getCapacityGb()
    {
        return $this->capacityGb;
    }

    /**
     * Set displayInch.
     *
     * @param int $displayInch
     *
     * @return MobilePhone
     */
    public function setDisplayInch($displayInch)
    {
        $this->displayInch = $displayInch;

        return $this;
    }

    /**
     * Get displayInch.
     *
     * @return int
     */
    public function getDisplayInch()
    {
        return $this->displayInch;
    }

    /**
     * Set cameraMp.
     *
     * @param int $cameraMp
     *
     * @return MobilePhone
     */
    public function setCameraMp($cameraMp)
    {
        $this->cameraMp = $cameraMp;

        return $this;
    }

    /**
     * Get cameraMp.
     *
     * @return int
     */
    public function getCameraMp()
    {
        return $this->cameraMp;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return MobilePhone
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return MobilePhone
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set heightMm.
     *
     * @param int $heightMm
     *
     * @return MobilePhone
     */
    public function setHeightMm($heightMm)
    {
        $this->heightMm = $heightMm;

        return $this;
    }

    /**
     * Get heightMm.
     *
     * @return int
     */
    public function getHeightMm()
    {
        return $this->heightMm;
    }

    /**
     * Set widthMm.
     *
     * @param int $widthMm
     *
     * @return MobilePhone
     */
    public function setWidthMm($widthMm)
    {
        $this->widthMm = $widthMm;

        return $this;
    }

    /**
     * Get widthMm.
     *
     * @return int
     */
    public function getWidthMm()
    {
        return $this->widthMm;
    }

    /**
     * Set depthMm.
     *
     * @param int $depthMm
     *
     * @return MobilePhone
     */
    public function setDepthMm($depthMm)
    {
        $this->depthMm = $depthMm;

        return $this;
    }

    /**
     * Get depthMm.
     *
     * @return int
     */
    public function getDepthMm()
    {
        return $this->depthMm;
    }

    /**
     * Set weightGrams.
     *
     * @param int $weightGrams
     *
     * @return MobilePhone
     */
    public function setWeightGrams($weightGrams)
    {
        $this->weightGrams = $weightGrams;

        return $this;
    }

    /**
     * Get weightGrams.
     *
     * @return int
     */
    public function getWeightGrams()
    {
        return $this->weightGrams;
    }

    /**
     * Set priceEuros.
     *
     * @param int $priceEuros
     *
     * @return MobilePhone
     */
    public function setPriceEuros($priceEuros)
    {
        $this->priceEuros = $priceEuros;

        return $this;
    }

    /**
     * Get priceEuros.
     *
     * @return int
     */
    public function getPriceEuros()
    {
        return $this->priceEuros;
    }

    /**
     * Set priceCents.
     *
     * @param int $priceCents
     *
     * @return MobilePhone
     */
    public function setPriceCents($priceCents)
    {
        $this->priceCents = $priceCents;

        return $this;
    }

    /**
     * Get priceCents.
     *
     * @return int
     */
    public function getPriceCents()
    {
        return $this->priceCents;
    }

    /**
     * Set dateCreation.
     *
     * @param datetime_immutable $dateCreation
     *
     * @return MobilePhone
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
     * @return MobilePhone
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
     * @return MobilePhone
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
     * Add image.
     *
     * @param Image $image
     *
     * @return MobilePhone
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
        $image->setMobilePhone($this);

        return $this;
    }

    /**
     * Remove image.
     *
     * @param Image $image
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeImage(Image $image)
    {
        return $this->images->removeElement($image);
    }

    /**
     * Get images.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set brand.
     *
     * @param Brand $brand
     *
     * @return MobilePhone
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set os.
     *
     * @param Os $os
     *
     * @return MobilePhone
     */
    public function setOs(Os $os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Get os.
     *
     * @return Os
     */
    public function getOs()
    {
        return $this->os;
    }
}
