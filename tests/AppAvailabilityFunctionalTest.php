<?php


namespace App\tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppAvailabilityFunctionalTest extends WebTestCase
{

    protected static  $user = null;

    protected function setUp(): void
    {
        if (null === self::$user) {
            self::$user = static::createClient();
        }
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $customer
     * @param string $password
     *
     * @return KernelBrowser
     */
    protected function createAuthenticatedUser($customer = 'user1', $password = 'u1')
    {
        $user = static::createClient();
        $user->request(
            'POST',
            '/api/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => $customer,
                'password' => $password,
            ))
        );

        $data = json_decode($user->getResponse()->getContent(), true);

        $user = static::createClient();
        $user->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $user;
    }


}