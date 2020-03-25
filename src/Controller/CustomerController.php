<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Exception\ResourceValidationException;
use App\Repository\CustomerRepository;
use App\Representation\Customers;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends AbstractFOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @param CustomerRepository $customerRepository
     * @return Customers
     *
     * @Rest\Get("/api/customer", name="app_customer_list")
     *
     *
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]+",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="10",
     *     description="Sort order (asc or desc)."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="10",
     *     description="Max number of results per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     */
    public function list(ParamFetcherInterface $paramFetcher, CustomerRepository $customerRepository)
    {

        $pager = $customerRepository->searchByUser(
            $this->getUser(),

            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
            );

        return new Customers($pager);
    }

    /**
     * @Rest\Get(
     *     path = "/api/users/{id}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )w
     * @param User $user
     * @return Customers
     */
    public function show(User $user)
    {
        return $user;
    }


    /**
     * @param Security $security
     * @param Customer $customer
     * @param ConstraintViolationListInterface $violations
     *
     * @return Customer
     *
     * @throws ResourceValidationException
     * @Rest\Post(
     *     path = "/api/customers",
     *     name = "customers_create",
     * )
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "customer",
     *      converter="fos_rest.request_body",
     *      options={
     *         "validator"={"groups"="create"}
     *     }
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_CREATED,
     *     serializerGroups={"details", "customer"}
     * )
     */
    public function create(Customer $customer, ConstraintViolationListInterface $violations)
    {
        if (count($violations) > 0) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf('Field %s: %s ', $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $customer->setUser($user);
        $entityManager->persist($user);
        $entityManager->flush();

        return $customer;
    }

    /**
     * @Rest\Delete(
     *     path = "/users/{id}",
     *     name = "user_delete",
     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @param User $user
     * @return Response
     */
    public function delete(User $user)
    {
        $this->denyAccessUnlessGranted('Delete', $user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return new Response('Customer deleted', Response::HTTP_OK);
    }
}