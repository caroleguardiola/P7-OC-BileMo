<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 16/04/2018
 * Time: 11:11
 */

namespace AppBundle\Controller;

use AppBundle\Entity\MobilePhone;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class MobilePhoneController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/mobilephones",
     *     name = "app_mobilephone_list",
     * )
     * @Rest\View
     */
    public function listAction()
    {
        $mobilephones = $this->getDoctrine()->getRepository('AppBundle:MobilePhone')->findAll();

        return $mobilephones;
    }
}