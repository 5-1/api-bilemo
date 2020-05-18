<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use App\Representation\Phones;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;



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
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     *
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"list"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of all phone related to an authentified user",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=phone::class))
     * )
     * )
     * @SWG\Parameter(
     *     name="keyword",
     *     in="query",
     *     type="string",
     *     description="Search for a phone with a keyword"
     * )
     *
     * @SWG\Parameter(
     *          name="Authorization",
     *          required=true,
     *          in="header",
     *          type="string",
     *          description="Bearer Token"
     *     )
     *
     * @SWG\Tag(name="Phone")
     */
    public function list(ParamFetcherInterface $paramFetcher, PhoneRepository $phoneRepository)
    {
        $pager = $phoneRepository->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        $representation =  new Phones($pager);
        return $representation;

    }


    /**
     * @Rest\Get(
     *     path="/api/phones/{id}",
     *     name="app_phone_show",
     *     requirements={"id"="\d+"}
     * )
     *
     * @Rest\View(
     *     statusCode=200,
     *     serializerGroups={"show"}
     * )
     * @SWG\Response(
     *     response=403,
     *     description="return when resource is not yours"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="return when resource is not found"

     * )
     * @SWG\Response(
     *     response=401,
     *     description="JWT Token not found"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns Phone details",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=Phone::class))
     * )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="id of the customer"
     * )
     *
     * @SWG\Parameter(
     *          name="Authorization",
     *          required=true,
     *          in="header",
     *          type="string",
     *          description="Bearer Token"
     *     )
     *
     * @SWG\Tag(name="Phone")
     */
    public function show(Phone $phone)
    {
        return $phone;
    }
}
