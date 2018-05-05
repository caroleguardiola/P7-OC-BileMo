<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 14:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Exception\ResourceNotFoundException;


class BrandController extends FOSRestController
{
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
