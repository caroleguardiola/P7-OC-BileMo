<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:00
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

class AddressControllerTest extends WebTestCase
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
    public function testGetAddressesWithoutOAuth()
    {
        $this->client->request('GET', '/api/addresses');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testGetAddressesWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        $this->client->request('GET', '/api/addresses');
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
    public function testGetAddressByIDWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing address in DB
        $this->client->request('GET', '/api/addresses/46');
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
    public function testGetAddressByIDNoPermissionWithAuthorization()
    {
        $this->createAuthorizedClientOAuthWithoutPermission();

        //test with an existing address in DB
        $this->client->request('GET', '/api/addresses/46');
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
    public function testGetAddressByIDNotFoundWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an non existing address in DB
        $this->client->request('GET', '/api/addresses/100');
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
    public function tearDown()
    {
        $this->client = null;
    }
}
