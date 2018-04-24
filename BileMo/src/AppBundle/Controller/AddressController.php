<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 18:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;

class AddressController extends FOSRestController
{
    /**
     * @param Address $address
     * @return Address
     *
     * @Rest\Get(
     *     path = "/addresses/{id}",
     *     name = "app_address_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_address"}
     * )
     */
    public function showAction(Address $address)
    {
        return $address;
    }
}