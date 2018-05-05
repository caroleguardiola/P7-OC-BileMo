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
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Exception\ResourceAccessForbiddenException;


class AddressController extends FOSRestController
{
    /**
     * @param Address $address
     * @return Address
     *
     * @throws ResourceNotFoundException
     * @throws ResourceAccessForbiddenException
     *
     * @Rest\Get(
     *     path = "/api/addresses/{id}",
     *     name = "app_address_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_address"}
     * )
     */
    public function showAction(Address $address=null)
    {
        $customer = $this->getUser();

        if (empty($address)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        if($customer !== $address->getUser()->getCustomer()){
            throw new ResourceAccessForbiddenException('You don\'t have the permission to access to this resource.');
        }

        return $address;
    }
}