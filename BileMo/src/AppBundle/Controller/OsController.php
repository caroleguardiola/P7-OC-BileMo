<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 15:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Os;
use AppBundle\Representation\OsR;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Exception\ResourceNotFoundException;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class OsController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return OsR
     *
     * @Rest\Get(
     *     path = "/api/os",
     *     name = "app_os_list",
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
     *     description="Max number of os per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"Default","list_os"}
     * )
     *
     * @SWG\Get(
     *   path="/api/os",
     *   tags={"Os"},
     *   summary="Get the list of all the os of mobilephones",
     *   description="To access to this resource, you need to enter in the authorization: Bearer 'YourAccessToken'",
     *   operationId="getOs",
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
     *     @Model(type=Os::class, groups={"list_os"})),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required")
     *   )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Os')->search(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new OsR($pager);
    }

    /**
     * @param Os $os
     * @return Os
     *
     * @throws ResourceNotFoundException
     *
     * @Rest\Get(
     *     path = "/api/os/{id}",
     *     name = "app_os_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_os"}
     * )
     * @SWG\Get(
     *   path="/api/os/{id}",
     *   tags={"Os"},
     *   summary="Get the detail of an os of mobilephones by ID",
     *   description="To access to this resource, you need to enter :
            - in the authorization: Bearer 'YourAccessToken'
            - in the path: a valid ID",
     *   operationId="getOsByID",
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
     *     @SWG\Schema(ref="#/definitions/GetOsByID")
     *   ),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required"),
     *   @SWG\Response(
     *     response=404,
     *     description="Resource not found")
     * )
     */
    public function showAction(Os $os=null)
    {
        if (is_null($os)){
            throw new ResourceNotFoundException("This resource doesn't exist");
        }

        return $os;
    }
}