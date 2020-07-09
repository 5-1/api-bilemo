<?php

namespace App\Tests\Controller;

use App\tests\AppAvailabilityFunctionalTest;
use App\Tests\AuthenticatedTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PhoneControllerTest extends WebTestCase
{

    use AuthenticatedTrait;

    public function testList(): void
    {
        $client = $this->createAuthenticatedUser();
        $client->request('GET', '/api/phones');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $user = $this->createAuthenticatedUser();
        $user->request('GET', '/api/phones/1');
        $this->assertSame(Response::HTTP_OK, $user->getResponse()->getStatusCode());
    }


}