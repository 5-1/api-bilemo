<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Exception\ResourceValidationException;
use App\Repository\CustomerRepository;
use App\Representation\Customers;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;


class CustomerController extends AbstractFOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @param CustomerRepository $customerRepository
     * @return Customers
     *

     * @Rest\Get("/api/customers", name="app_customer_list")
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

     *     default="asc",

     *     description="Sort order (asc or desc)."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",

     *     default=10,
     *     description="Max number of results per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     nullable=true,
     *     requirements="\d+",
     *     default=1,

     *     description="The pagination offset"
     * )
     *

     *     statusCode=200,
     *     serializerGroups={"list"}

     * )
     */
    public function list(ParamFetcherInterface $paramFetcher, CustomerRepository $customerRepository)
    {

        $pager = $customerRepository->searchByUser(
            $this->getUser(),

            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),

            $paramFetcher->get('page')
            );

        $representation = new Customers($pager);
        return $representation;

    }

    /**
     * @Rest\Get(

     *     path = "/api/customers/{id}",
     *     name = "app_customer_show",

     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(

     *     statusCode=200,
     *     serializerGroups={"show"}
     * )
     * @param Customer $customer
     * @return Customer
     */
    public function show(Customer$customer)
    {
        return $customer;

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

     *     name = "app_customer_create",
     * )

     * @ParamConverter(
     *     "customer",
     *      converter="fos_rest.request_body",
     *      options={

     *         "validator"={"groups"={"create"}}

     *     }
     * )
     *
     * @Rest\View(
     *     statusCode=Response::HTTP_CREATED,

     *     serializerGroups={"create"}

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

        $entityManager->persist($customer);

        $entityManager->flush();

        return $customer;
    }

    /**
     * @Rest\Delete(
     *     path = "/customers/{id}",
     *     name = "app_customer_delete",

     *     requirements = {"id"="\d+"}
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @param Customer $customer
     * @return Response
     */
    public function delete(Customer $customer)
    {
        $this->denyAccessUnlessGranted('Delete', $customer);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($customer);

        $entityManager->flush();

        return new Response('Customer deleted', Response::HTTP_OK);
    }
}