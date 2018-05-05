<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 18:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Representation\Addresses;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Exception\ResourceAccessForbiddenException;


class AddressController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return Addresses
     *
     * @Rest\Get(
     *     path = "/api/addresses",
     *     name = "app_addresses_list",
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of addresses per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *  @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"Default", "list_users", "list_addresses"}
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $customer = $this->getUser();

        $pager = $this->getDoctrine()->getRepository('AppBundle:Address')->search(
            $customer,
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Addresses($pager);
    }

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