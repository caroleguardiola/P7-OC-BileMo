<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 16/04/2018
 * Time: 11:11
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

use AppBundle\Entity\MobilePhone;
use AppBundle\Representation\MobilePhones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class MobilePhoneController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return MobilePhones
     *
     * @Rest\Get(
     *     path = "/api/mobilephones",
     *     name = "app_mobilephones_list",
     * )
     *  @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9\s]+",
     *     nullable=true,
     *     description="The keyword to search for."
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
     *     description="Max number of mobile phones per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"Default","list_mobilephones"}
     * )
     *
     * @SWG\Get(
     *   path="/api/mobilephones",
     *   tags={"MobilePhones"},
     *   summary="Get the list of all the mobilephones",
     *   description="To access to this resource, you need to enter in the authorization: Bearer 'YourAccessToken'",
     *   operationId="getMobilePhones",
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
     *     @Model(type=MobilePhone::class, groups={"list_mobilephones"})
     *   ),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required")
     * )
     * @Cache(smaxage="3600", public=true)
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:MobilePhone')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new MobilePhones($pager);
    }

    /**
     * @param MobilePhone $mobilephone
     * @return MobilePhone
     *
     * @throws ResourceNotFoundException
     *
     * @Rest\Get(
     *     path = "/api/mobilephones/{id}",
     *     name = "app_mobilephone_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_mobilephone"}
     * )
     *
     * @SWG\Get(
     *   path="/api/mobilephones/{id}",
     *   tags={"MobilePhones"},
     *   summary="Get the detail of a mobilephone by ID",
     *   description="To access to this resource, you need to enter :
     *      - in the authorization: Bearer 'YourAccessToken'
     *      - in the path: a valid ID",
     *   operationId="getMobilePhoneByID",
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
     *     @SWG\Schema(ref="#/definitions/GetMobilePhoneByID")
     *   ),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required"),
     *   @SWG\Response(
     *     response=404,
     *     description="Resource not found")
     * )
     * @Cache(smaxage="3600", public=true)
     */
    public function showAction(MobilePhone $mobilephone=null)
    {
        if (is_null($mobilephone)) {
            throw new ResourceNotFoundException("This resource doesn't exist");
        }

        return $mobilephone;
    }
}
