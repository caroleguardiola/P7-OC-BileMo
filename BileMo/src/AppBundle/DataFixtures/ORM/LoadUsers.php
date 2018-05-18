<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 16:24
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Address;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //Customers
        $customer1 = new Customer;
        $customer1->setUsername('Scott');
        $customer1->setEmail('scott.g@gmail.com');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($customer1, 'scott');
        $customer1->setPassword($password);

        $manager->persist($customer1);

        $customer2 = new Customer;
        $customer2->setUsername('Chris');
        $customer2->setEmail('chris.g@gmail.com');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($customer2, 'chris');
        $customer2->setPassword($password);

        $manager->persist($customer2);

        $customer3 = new Customer;
        $customer3->setUsername('Kate');
        $customer3->setEmail('kate.g@gmail.com');

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($customer3, 'kate');
        $customer3->setPassword($password);

        $manager->persist($customer3);

        //Users
        $user1 = new User;
        $user1->setFirstName('Lisy');
        $user1->setLastName('Moon');
        $user1->setUsername('Lisy');
        $user1->setEmail('lisy.moon@gmail.com');
        $user1->setCustomer($customer1);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user1, 'lisy');
        $user1->setPassword($password);

        $manager->persist($user1);

        $user2 = new User;
        $user2->setFirstName('Tyler');
        $user2->setLastName('Dillo');
        $user2->setUsername('Tyler');
        $user2->setEmail('tyler.dillo@gmail.com');
        $user2->setCustomer($customer2);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user2, 'tyler');
        $user2->setPassword($password);

        $manager->persist($user2);

        $user3 = new User;
        $user3->setFirstName('Tess');
        $user3->setLastName('Lake');
        $user3->setUsername('Nolan');
        $user3->setEmail('tess.nolan@gmail.com');
        $user3->setCustomer($customer3);

        $passwordEncoder = $this->container->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword($user3, 'tess');
        $user3->setPassword($password);

        $manager->persist($user3);

        //Addresses
        $address1 = new Address;
        $address1->setRecipient('Lisy Moon');
        $address1->setStreetAddress('70 cours Lafayette');
        $address1->setZipCode(69003);
        $address1->setCity('Lyon');
        $address1->setCountry('France');
        $address1->setUser($user1);
        $manager->persist($address1);

        $address2 = new Address;
        $address2->setRecipient('Tyler Dillo');
        $address2->setStreetAddress('100 cours Lafayette');
        $address2->setZipCode(69003);
        $address2->setCity('Lyon');
        $address2->setCountry('France');
        $address2->setUser($user2);
        $manager->persist($address2);

        $address3 = new Address;
        $address3->setRecipient('Tess Lake');
        $address3->setStreetAddress('30 cours Lafayette');
        $address3->setZipCode(69003);
        $address3->setCity('Lyon');
        $address3->setCountry('France');
        $address3->setUser($user3);
        $manager->persist($address3);

        // On déclenche l'enregistrement
        $manager->flush();
    }
}
