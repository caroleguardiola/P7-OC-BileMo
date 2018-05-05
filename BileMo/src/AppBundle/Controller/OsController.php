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
     */
    public function showAction(Os $os=null)
    {
        if (empty($os)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        return $os;
    }
}