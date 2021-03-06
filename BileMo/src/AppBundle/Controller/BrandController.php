<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 14:37
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

use AppBundle\Entity\Brand;
use AppBundle\Representation\Brands;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Exception\ResourceNotFoundException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

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
     * @SWG\Get(
     *   path="/api/brands",
     *   tags={"Brands"},
     *   summary="Get the list of all the brands of mobilephones",
     *   description="To access to this resource, you need to enter in the authorization: Bearer 'YourAccessToken'",
     *   operationId="getBrands",
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
     *     @Model(type=Brand::class, groups={"list_brands"})),
     *   @SWG\Response(
     *     response=401,
     *     description="Unauthorized - OAuth2 authentication required")     *
     * )
     * @Cache(smaxage="3600", public=true)
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
     *
     * @SWG\Get(
     *   path="/api/brands/{id}",
     *   tags={"Brands"},
     *   summary="Get the detail of a brand of mobilephones by ID",
     *   description="To access to this resource, you need to enter :
     *      - in the authorization: Bearer 'YourAccessToken'
     *      - in the path: a valid ID",
     *   operationId="getBrandByID",
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
     *     @SWG\Schema(ref="#/definitions/GetBrandByID")
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
    public function showAction(Brand $brand=null)
    {
        if (is_null($brand)) {
            throw new ResourceNotFoundException("This resource doesn't exist");
        }

        return $brand;
    }
}
