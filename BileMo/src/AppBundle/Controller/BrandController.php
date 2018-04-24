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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;

class BrandController extends FOSRestController
{
    /**
     * @param Brand $brand
     * @return Brand
     *
     * @Rest\Get(
     *     path = "/brands/{id}",
     *     name = "app_brand_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_brand"}
     * )
     */
    public function showAction(Brand $brand)
    {
        return $brand;
    }
}