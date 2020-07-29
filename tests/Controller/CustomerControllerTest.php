<?php

namespace App\Tests\Controller;

use App\Tests\AuthenticatedTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CustomerControllerTest extends WebTestCase
{


    use AuthenticatedTrait;

    public function testList(): void
    {
        $client = $this->createAuthenticatedUser();
        $client->request('GET', '/api/customers');
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $user = $this->createAuthenticatedUser('user1');
        $user->request('GET', '/api/customers/1');
        $this->assertSame(Response::HTTP_OK, $user->getResponse()->getStatusCode());
    }

    public function testForbiddenShow(): void
    {
        $user = $this->createAuthenticatedUser('user1');
        $user->request('GET', '/api/customers/2');
        $this->assertSame(Response::HTTP_FORBIDDEN, $user->getResponse()->getStatusCode());
    }



    public function testNew(): void
    {
        $user = $this->createAuthenticatedUser();
        $user->request(
            'POST',
            '/api/customers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                "email" => "test@Post.com",
                "first_name" => "testunit",
                "second_name" => "testunit",
            ], JSON_PARTIAL_OUTPUT_ON_ERROR, 512)
        );
        $this->assertSame(Response::HTTP_CREATED, $user->getResponse()->getStatusCode());

    }

    public function testDelete(): void
   {
      $user = $this->createAuthenticatedUser('user1');
      $user->request('DELETE', '/api/customers/4');
      $this->assertSame(Response::HTTP_NO_CONTENT, $user->getResponse()->getStatusCode());
   }

    public function testDeleteReturn403ForUnauthorizedAccess(): void
    {
        $user = $this->createAuthenticatedUser('user1');
        $user->request('DELETE', '/api/customers/3');
        $this->assertSame(Response::HTTP_FORBIDDEN, $user->getResponse()->getStatusCode());
    }

}