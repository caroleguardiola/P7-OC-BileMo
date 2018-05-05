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
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Exception\ResourceValidationException;
use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Exception\ResourceAccessForbiddenException;


class UserController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return Users
     *
     * @Rest\Get(
     *     path = "/api/users",
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
     *     statusCode = 200,
     *     serializerGroups = {"Default", "list_users"}
     * )
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $customer = $this->getUser();

        $pager = $this->getDoctrine()->getRepository('AppBundle:User')->search(
            $customer,
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
     * @throws ResourceNotFoundException
     * @throws ResourceAccessForbiddenException
     *
     * @Rest\Get(
     *     path = "/api/users/{id}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode = 200,
     *     serializerGroups = {"detail_user"}
     * )
     */
    public function showAction(User $user=null)
    {
        $customer = $this->getUser();

        if (empty($user)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        if($customer !== $user->getCustomer()){
            throw new ResourceAccessForbiddenException('You don\'t have the permission to access to this resource.');
        }

        return $user;
    }

    /**
     * @param User $user
     * @param ConstraintViolationList $violations
     * @return \FOS\RestBundle\View\View
     *
     * @throws ResourceValidationException
     * @Rest\Post(
     *    path = "/api/users",
     *    name = "app_user_create"
     * )
     * @Rest\View(
     *     StatusCode = 201,
     *     serializerGroups = {"create_user"}
     * )
     * @ParamConverter(
     *     "user",
     *     converter="fos_rest.request_body",
     *     options={
     *         "validator"={ "groups"="Create_User" }
     *     }
     * )
     */
    public function createAction(User $user, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $customer = $this->getUser();

        $user
            ->setDateCreation(new \DateTime())
            ->setIsActive(true)
            ->setCustomer($customer)
        ;
        $passwordEncoder = $this->get('security.password_encoder');

        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();

        //$listAddresses = $user->getAddresses();
        //foreach ($listAddresses as $address)
        //{
        //    $user->addAddress($address);
        //    $address
        //        ->setDateCreation(new \DateTime())
        //        ->setIsActive(true)
        //    ;
        //}

        foreach($user->getAddresses() as $address) {
            $address->setUser($user);
            $address
                ->setDateCreation(new \DateTime())
                ->setIsActive(true)
            ;
        //    $em->persist($address);
        }

        //var_dump($user);die();
        $em->persist($user);
        $em->flush();

        return $this->view(
            $user,
            Response::HTTP_CREATED,
            ['Location' => $this->generateUrl('app_user_show', ['id' => $user->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]
        );
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws ResourceNotFoundException
     * @throws ResourceAccessForbiddenException
     *
     * @Rest\Delete(
     *     path="/api/users/{id}",
     *     name="app_user_delete",
     *     requirements={ "id"="\d+" }
     * )
     * @Rest\View(StatusCode=200)
     */
    public function deleteAction(User $user=null)
    {
        if (empty($user)){
            throw new ResourceNotFoundException('This resource doesn\'t exist.');
        }

        $em = $this->getDoctrine()->getManager();
        $userdelete = $em->getRepository('AppBundle:User')->find($user);

        $customer = $this->getUser();

        if($customer !== $user->getCustomer()){
            throw new ResourceAccessForbiddenException('You don\'t have the permission to access to this resource.');
        }

        $em->remove($userdelete);
        $em->flush();

        return $this->redirectToRoute('app_users_list');
    }
}