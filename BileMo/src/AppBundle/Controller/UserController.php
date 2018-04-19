<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 19/04/2018
 * Time: 17:41
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/users",
     *     name = "app_users_list",
     * )
     *
     *  @Rest\View(
     *     statusCode = 200
     * )
     */
    public function listAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $users;
    }
}