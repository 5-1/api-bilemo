<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait AuthenticatedTrait
{
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
        $client = static::createClient();
        $client->request(
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

        $data = json_decode($client->getResponse()->getContent(), true);

        self::ensureKernelShutdown();

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}