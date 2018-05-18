<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:12
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;


class MobilePhoneControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

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

    public function testGetMobilePhonesWithoutOAuth()
    {
        $this->client->request('GET', '/api/mobilephones');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testGetMobilePhonesWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        $this->client->request('GET', '/api/mobilephones');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetMobilePhoneByIDWitAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an existing brand in DB
        $this->client->request('GET', '/api/mobilephones/10');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetMobilePhoneByIDNotFoundWithAuthorization()
    {
        $this->createAuthorizedClientOAuth();

        //test with an non existing mobilephone in DB
        $this->client->request('GET', '/api/mobilephones/100');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }
}