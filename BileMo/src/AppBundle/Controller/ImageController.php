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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;


class ImageController extends FOSRestController
{
    /**
     * @return array
     *
     * @Rest\Get(
     *     path = "/images",
     *     name = "app_images_list",
     * )
     *
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"list_images"}
     * )
     */
    public function listAction()
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->findAll();

        return $images;
    }

    /**
     * @param Image $image
     * @return Image
     *
     *  @Rest\Get(
     *     path = "/images/{id}",
     *     name = "app_image_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_image"}
     * )
     */
    public function showAction(Image $image)
    {
        return $image;
    }
}