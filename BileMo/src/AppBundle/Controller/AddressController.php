<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 18:21
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Representation\Addresses;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Exception\ResourceAccessForbiddenException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


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
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"Default", "list_users", "list_addresses"}
     * )
     * @SWG\Get(
     *   path="/api/addresses",
     *   tags={"Addresses"},
     *   summary="Get the list of all addresses of the users",
     *   description="To access to this resource, you need to enter in the authorization: Bearer 'YourAccessToken'",
     *   operationId="getAddresses",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     type="string",
     *     description="Bearer 'YourAccessToken' ",
     *     required=true,
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @Model(type=Address::class, groups={"list_users", "list_addresses"}),
     *   ),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required"),
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
     * @SWG\Get(
     *   path="/api/addresses/{id}",
     *   tags={"Addresses"},
     *   summary="Get the detail of an user's address by ID",
     *   description="To access to this resource, you need to enter :
            - in the authorization: Bearer 'YourAccessToken'
            - in the path: a valid ID",
     *   operationId="getAddressByID",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     type="string",
     *     description="Bearer 'YourAccessToken' ",
     *     required=true,
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="Successful operation",
     *     @SWG\Schema(ref="#/definitions/GetAddressByID")
     *   ),
     *  @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required"),
     *  @SWG\Response(
     *     response=404,
     *     description="Resource not found"),
     *  @SWG\Response(
     *     response=403,
     *     description="No permission to access at this resource")
     * )
     */
    public function showAction(Address $address=null)
    {
        $customer = $this->getUser()->getId();

        if (is_null($address)){
            throw new ResourceNotFoundException("This resource doesn't exist");
        }

        if($customer !== $address->getUser()->getCustomer()->getId()){
            throw new ResourceAccessForbiddenException("You don't have the permission to access to this resource");
        }

        return $address;
    }
}