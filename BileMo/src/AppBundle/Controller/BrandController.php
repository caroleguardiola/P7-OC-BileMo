<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 14:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use AppBundle\Representation\Brands;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;


class BrandController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return Brands
     *
     * @Rest\Get(
     *     path = "/api/brands",
     *     name = "app_brands_list",
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
     *     description="Max number of brands per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"Default","list_brands"}
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Brand')->search(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Brands($pager);
    }

    /**
     * @param Brand $brand
     * @return Brand
     *
     * @throws ResourceNotFoundException
     *
     * @Rest\Get(
     *     path = "/api/brands/{id}",
     *     name = "app_brand_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_brand"}
     * )
     */
    public function showAction(Brand $brand=null)
    {
        if (empty($brand)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        return $brand;
    }
}
