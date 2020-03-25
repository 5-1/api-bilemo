<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use App\Representation\Phones;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class PhoneController extends AbstractFOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Phones
     *
     * @Rest\Get("/api/phones", name="app_phone_list")
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
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
     *     default="5",
     *     description="Max number of phone per page."
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
     *
     */
    public function list(ParamFetcherInterface $paramFetcher, PhoneRepository $phoneRepository)
    {
        $pager = $phoneRepository->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );

        return new Phones($pager);

    }


    /**
     * @Rest\Get(
     *     path="/api/phone/{id}",
     *     name="app_phone_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200
     * )
     */
    public function show(Phone $phone)
    {
        return $phone;
    }
}
