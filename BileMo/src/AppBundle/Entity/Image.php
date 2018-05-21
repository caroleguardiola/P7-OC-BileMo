<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 26/04/2018
 * Time: 28:26
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

use \DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_image_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"detail_mobilephone", "list_images", "detail_image"})
 * )
 * @Hateoas\Relation(
 *     "mobilephones",
 *     embedded = @Hateoas\Embedded("expr(object.getMobilePhone())"),
 *     exclusion = @Hateoas\Exclusion(groups = {"detail_image"})
 * )
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Groups({"list_images"})
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=45)
     *
     * @Serializer\Groups({"detail_mobilephone", "list_images", "detail_image"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=45)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     *
     * @Serializer\Groups({"detail_mobilephone", "list_images", "detail_image"})
     * @Serializer\Since("1.0")
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     */
    private $alt;

    /**
     * @var UploadedFile
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\Image()
     */
    private $file;

    /**
     * @Serializer\Groups({"none"})
     */
    private $tempFilename;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MobilePhone", cascade={"persist"}, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Groups({"none"})
     *
     * @Assert\NotBlank
     * @Assert\Valid()
     */
    private $mobilePhone;
    
    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="date_creation", type="datetime_immutable")
     *
     * @Serializer\Groups({"none"})
     */
    private $dateCreation;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     *
     * @Serializer\Groups({"none"})
     */
    private $updatedAt;

    /**
     * @var \DateTimeImmutable|null
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
        $this->dateCreation = new DateTimeImmutable();
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
     * Set extension.
     *
     * @param string $extension
     *
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTimeImmutable $dateCreation
     *
     * @return Image
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTimeImmutable
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
        $this->setUpdatedAt(new DateTimeImmutable());
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTimeImmutable|null $updatedAt
     *
     * @return Image
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set dateDeactivation.
     *
     * @param \DateTimeImmutable|null $dateDeactivation
     *
     * @return Image
     */
    public function setDateDeactivation($dateDeactivation = null)
    {
        $this->dateDeactivation = $dateDeactivation;

        return $this;
    }

    /**
     * Get dateDeactivation.
     *
     * @return \DateTimeImmutable|null
     */
    public function getDateDeactivation()
    {
        return $this->dateDeactivation;
    }

    /**
     * Set mobilePhone.
     *
     * @param MobilePhone $mobilePhone
     *
     * @return Image
     */
    public function setMobilePhone(MobilePhone $mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone.
     *
     * @return MobilePhone
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if (null !== $this->extension) {
            $this->tempFilename = $this->extension;
            $this->extension = null;
            $this->alt = null;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->extension = $this->file->guessExtension();

        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->id.'.'.$this->extension
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/mobilephone/images';
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getExtension();
    }
}
