<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 14:33
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\MobilePhone;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Image;
use AppBundle\Entity\Os;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;



class LoadMobilePhones implements FixtureInterface, ContainerAwareInterface
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
        //Brands
        $brand1 = new Brand;
        $brand1->setName('Samsung');
        $manager->persist($brand1);

        $brand2 = new Brand;
        $brand2->setName('Apple');
        $manager->persist($brand2);

        $brand3 = new Brand;
        $brand3->setName('Huawei');
        $manager->persist($brand3);

        //Os
        $os1 = new Os;
        $os1->setName('Android');
        $manager->persist($os1);

        $os2 = new Os;
        $os2->setName('iOs');
        $manager->persist($os2);

        //MobilePhones
        $mobilephone1 = new MobilePhone();
        $mobilephone1->setModel('Galaxy S9+');
        $mobilephone1->setReference('GALS9');
        $mobilephone1->setCapacityGb(64);
        $mobilephone1->setDisplayInch(5.6);
        $mobilephone1->setCameraMp(12);
        $mobilephone1->setHeightMm(147.7);
        $mobilephone1->setWidthMm(68.7);
        $mobilephone1->setDepthMm(8.5);
        $mobilephone1->setWeightGrams(163);
        $mobilephone1->setColor('Coral Blue');
        $mobilephone1->setDescription('Samsung Galaxy S9+ - Coral Blue');
        $mobilephone1->setPriceEuros(959.00);
        $mobilephone1->setPriceCents(95900);
        $mobilephone1->setBrand($brand1);
        $mobilephone1->setOs($os1);
        $manager->persist($mobilephone1);

        $mobilephone2 = new MobilePhone();
        $mobilephone2->setModel('IPhone X');
        $mobilephone2->setReference('IPHONX');
        $mobilephone2->setCapacityGb(256);
        $mobilephone2->setDisplayInch(5.8);
        $mobilephone2->setCameraMp(12);
        $mobilephone2->setHeightMm(143.6);
        $mobilephone2->setWidthMm(70.9);
        $mobilephone2->setDepthMm(7.7);
        $mobilephone2->setWeightGrams(174);
        $mobilephone2->setColor('Space Gray');
        $mobilephone2->setDescription('IPhone X - Space Gray');
        $mobilephone2->setPriceEuros(1329.00);
        $mobilephone2->setPriceCents(132900);
        $mobilephone2->setBrand($brand2);
        $mobilephone2->setOs($os2);
        $manager->persist($mobilephone2);

        $mobilephone3 = new MobilePhone();
        $mobilephone3->setModel('Huawei P20 Pro');
        $mobilephone3->setReference('HUAWP20PRO');
        $mobilephone3->setCapacityGb(128);
        $mobilephone3->setDisplayInch(6.1);
        $mobilephone3->setCameraMp(24);
        $mobilephone3->setHeightMm(155);
        $mobilephone3->setWidthMm(73.9);
        $mobilephone3->setDepthMm(7.8);
        $mobilephone3->setWeightGrams(180);
        $mobilephone3->setColor('Black');
        $mobilephone3->setDescription('Huawei P20 Pro - Black');
        $mobilephone3->setPriceEuros(899.00);
        $mobilephone3->setPriceCents(89900);
        $mobilephone3->setBrand($brand3);
        $mobilephone3->setOs($os1);
        $manager->persist($mobilephone3);

        //Images
        $image1 = new Image;
        $image1->setExtension('jpeg');
        $image1->setAlt('samsung-s9+.jpg');
        $image1->setMobilePhone($mobilephone1);
        $manager->persist($image1);

        $image2 = new Image;
        $image2->setExtension('jpeg');
        $image2->setAlt('iphone x.jpg');
        $image2->setMobilePhone($mobilephone2);
        $manager->persist($image2);

        $image3 = new Image;
        $image3->setExtension('jpeg');
        $image3->setAlt('huawei p20 pro.jpg');
        $image3->setMobilePhone($mobilephone3);
        $manager->persist($image3);

        // On déclenche l'enregistrement
        $manager->flush();
    }
}
