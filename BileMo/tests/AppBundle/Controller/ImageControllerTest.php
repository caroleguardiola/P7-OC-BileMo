<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:10
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


class ImageControllerTest extends WebTestCase
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
    public function testGetImagesWithoutOAuth()
    {
        $this->client->request('GET', '/api/images');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testGetImagesWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        $this->client->request('GET', '/api/images');
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
    public function testGetImageByIDWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing image in DB
        $this->client->request('GET', '/api/images/10');
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
    public function testGetImageByIDNotFoundWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an non existing image in DB
        $this->client->request('GET', '/api/images/100');
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