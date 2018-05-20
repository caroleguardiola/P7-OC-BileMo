<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:14
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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class OsControllerTest extends WebTestCase
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

        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('IS_AUTHENTICATED_FULLY'));
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
    public function testGetOsWithoutOAuth()
    {
        $this->client->request('GET', '/api/os');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testGetOsWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        $this->client->request('GET', '/api/os');
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
    public function testGetOsByIDWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing os in DB
        $this->client->request('GET', '/api/os/8');
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
    public function testGetOsByIDNotFoundWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an non existing os in DB
        $this->client->request('GET', '/api/os/100');
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
