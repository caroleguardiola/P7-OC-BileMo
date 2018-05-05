<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 16/04/2018
 * Time: 11:11
 */

namespace AppBundle\Controller;

use AppBundle\Entity\MobilePhone;
use AppBundle\Representation\MobilePhones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;


class MobilePhoneController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return MobilePhones
     *
     * @Rest\Get(
     *     path = "/api/mobilephones",
     *     name = "app_mobilephone_list",
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
     */
    public function showAction(MobilePhone $mobilephone=null)
    {
        if (empty($mobilephone)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        return $mobilephone;
    }
}
