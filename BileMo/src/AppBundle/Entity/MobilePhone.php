<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MobilePhone
 *
 * @ORM\Table(name="mobile_phone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobilePhoneRepository")
 */
class MobilePhone
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
     * @ORM\Column(name="model", type="string", length=255, unique=true)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, unique=true)
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="capacity_gb", type="integer", options={"unsigned":true})
     */
    private $capacityGb;

    /**
     * @var int
     *
     * @ORM\Column(name="display_inch", type="integer", options={"unsigned":true})
     */
    private $displayInch;

    /**
     * @var int
     *
     * @ORM\Column(name="camera_mp", type="integer", options={"unsigned":true})
     */
    private $cameraMp;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=45)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="height_mm", type="integer", options={"unsigned":true})
     */
    private $heightMm;

    /**
     * @var int
     *
     * @ORM\Column(name="width_mm", type="integer", options={"unsigned":true})
     */
    private $widthMm;

    /**
     * @var int
     *
     * @ORM\Column(name="depth_mm", type="integer", options={"unsigned":true})
     */
    private $depthMm;

    /**
     * @var int
     *
     * @ORM\Column(name="weight_grams", type="integer", options={"unsigned":true})
     */
    private $weightGrams;

    /**
     * @var int
     *
     * @ORM\Column(name="price_euros", type="integer", options={"unsigned":true})
     */
    private $priceEuros;

    /**
     * @var int
     *
     * @ORM\Column(name="price_cents", type="integer", options={"unsigned":true})
     */
    private $priceCents;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="date_creation", type="datetime_immutable")
     */
    private $dateCreation;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime_immutable", nullable=true)
     */
    private $dateDeactivation;


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
}
