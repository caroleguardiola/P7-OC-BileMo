<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 16/04/2018
 * Time: 11:11
 */

namespace AppBundle\Controller;

use AppBundle\Representation\MobilePhones;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

class MobilePhoneController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/mobilephones",
     *     name = "app_mobilephone_list",
     * )
     * @Rest\QueryParam(
     *     name="brand",
     *     requirements="\d+",
     *     nullable=true,
     *     description="The brand to search for."
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
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:MobilePhone')->search(
            $paramFetcher->get('brand'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new MobilePhones($pager);
    }
}