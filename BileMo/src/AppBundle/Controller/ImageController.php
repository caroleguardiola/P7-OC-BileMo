<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 15:10
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Exception\ResourceNotFoundException;


class ImageController extends FOSRestController
{
    /**
     * @param Image $image
     * @return Image
     *
     * @throws ResourceNotFoundException
     *
     * @Rest\Get(
     *     path = "/api/images/{id}",
     *     name = "app_image_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_image"}
     * )
     */
    public function showAction(Image $image=null)
    {
        if (empty($image)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        return $image;
    }
}