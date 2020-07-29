<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AppAvailabilityFunctionalTest extends WebTestCase
{

use AuthenticatedTrait;


    /**
     * @param $url
     * @param $expectedStatus
     * @dataProvider smokeTestProvider
     */
    public function testSmokeTest($url,$expectedStatus, $method)
    {
        $client = static::createClient();
        $client->request($method, $url);
        $this->assertSame($expectedStatus, $client->getResponse()->getStatusCode());
    }


    public function smokeTestProvider(){
        yield ['/api/phones', 401, 'GET'];
        yield ['/api/customers', 401, 'POST'];
        yield ['/api/phones/1', 401, 'GET'];
        yield ['/api/customers', 401, 'GET'];
        yield ['/api/customers/1', 401, 'GET'];
        yield ['/api/doc', 200, 'GET'];
        yield ['/api/login_check', 400, 'GET'];
        yield ['/api/customers/1', 401, 'DELETE'];


    }


}