<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 19/04/2018
 * Time: 17:41
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Representation\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
class UserController extends FOSRestController
{

    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return Users
     *
     * @Rest\Get(
     *     path = "/users",
     *     name = "app_users_list",
     * )
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9\s]+",
     *     nullable=true,
     *     description="The keyword to search for."
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
     *     default="0",
     *     description="The pagination offset"
     * )
     *  @Rest\View(
     *     statusCode = 200
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:User')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Users($pager);
    }

    /**
     * @param User $user
     * @return User
     *
     * @Rest\Get(
     *     path = "/users/{id}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200
     * )
     */
    public function showAction(User $user)
    {
        return $user;
    }

    /**
     * @param User $user
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Post(
     *    path = "/users",
     *    name = "app_user_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function createAction(User $user)
    {
        $passwordEncoder = $this->get('security.password_encoder');

        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return $this->view($user, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_user_show', ['id' => $user->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Rest\Delete(
     *     path="/users/{id}",
     *     name="app_user_delete",
     *     requirements={ "id"="\d+" }
     * )
     * @Rest\View(StatusCode=200)
     */
    public function deleteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $userdelete = $em->getRepository('AppBundle:User')->find($user);

        $em->remove($userdelete);
        $em->flush();

        return $this->redirectToRoute('app_users_list');
    }
}