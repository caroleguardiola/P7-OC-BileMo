<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 24/04/2018
 * Time: 15:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Os;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Exception\ResourceNotFoundException;


class OsController extends FOSRestController
{
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