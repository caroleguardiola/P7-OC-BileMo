<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:16
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @return null
     */
    private function createAuthorizedClientOAuth()
    {
        $this->client->getCookieJar()->set(new Cookie(session_name(), true));
        $session = $this->client->getContainer()->get('session');

        //test with an existing customer in DB
        $user = $this->client->getContainer()->get('doctrine')->getRepository(Customer::class)->find(40);

        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, array('IS_AUTHENTICATED_FULLY'));

        self::$kernel->getContainer()->get('security.token_storage')->setToken($token);

        $session->set('_security_'. 'api', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
        return $this->client;
    }

    /**
     * @return null
     */
    private function createAuthorizedClientOAuthWithoutPermission()
    {
        $this->client->getCookieJar()->set(new Cookie(session_name(), true));
        $session = $this->client->getContainer()->get('session');

        //test with an existing customer in DB
        $user = $this->client->getContainer()->get('doctrine')->getRepository(Customer::class)->find(41);

        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallContext, array('IS_AUTHENTICATED_FULLY'));

        self::$kernel->getContainer()->get('security.token_storage')->setToken($token);

        $session->set('_security_'. 'api', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
        return $this->client;
    }

    /**
     *
     */
    public function testGetUsersWithoutOAuth()
    {
        $this->client->request('GET', '/api/users');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testGetUsersWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        $this->client->request('GET', '/api/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    /**
     *
     */
    public function testGetUserByIDWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing user in DB
        $this->client->request('GET', '/api/users/62');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    /**
     *
     */
    public function testGetUserByIDNoPermissionWithAuthorization()
    {
        $this->createAuthorizedClientOAuthWithoutPermission();

        //test with an existing address in DB
        $this->client->request('GET', '/api/users/62');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    /**
     *
     */
    public function testGetUserByIDNotFoundWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an non existing user in DB
        $this->client->request('GET', '/api/users/100');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    /**
     *
     */
    public function testCreateUserWithAuthorization()
    {
        $oauthHeaders = [
            "client_id" 	=> "35_4plir72x3s84o0w8k84kgwwkcg048k8cs4wk8koksck0ck44ow",
            "client_secret" => "52t86vw573sw0wcw0gsk4osswoc48gscsk44g4csc8w080gs8w",
            "grant_type" 	=> 'password',
            "username" 		=> "Scott",
            "password" 		=> "scott"
        ];
        $this->client->request('GET', '/oauth/v2/token', $oauthHeaders);
        $data = $this->client->getResponse()->getContent();
        $json = json_decode($data);
        $accessToken = $json->{'access_token'};

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $data = '
                {
                "username": "Mila",
                "first_name": "Mila",
                "last_name": "Moon",
                "email": "mila.moon@gmail.com",
                "plain_password": "mila",
                "addresses": [
                    {
                        "recipient": "Mila Moon",
                        "street_address": "70 cours Gambetta",
                        "zip_code": "69003",
                        "city": "LYON",
                        "country": "FRANCE"
                    }
                ]
            }
                ';

        $this->client->request('POST', '/api/users', array(), array(), $headers, $data);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    /**
     *
     */
    public function testDeleteUserWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing user in DB
        $this->client->request('DELETE', '/api/users/74');
        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->client = null;
    }
}
