<?php

/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 28/04/2018
 * Time: 17:51
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
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Customer extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="customer", cascade={"persist","remove"})
     */
    private $users;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="date_creation", type="datetime_immutable")
     */
    private $dateCreation;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="date_deactivation", type="datetime_immutable", nullable=true)
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
        $this->dateCreation = new DateTimeImmutable();
        $this->users = new ArrayCollection();
        $this->enabled = true;
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
     * Set dateCreation.
     *
     * @param \DateTimeImmutable $dateCreation
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Add user.
     *
     * @param User $user
     *
     * @return Customer
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        $user->setCustomer($this);

        return $this;
    }

    /**
     * Remove user.
     *
     * @param User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(User $user)
    {
        return $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
