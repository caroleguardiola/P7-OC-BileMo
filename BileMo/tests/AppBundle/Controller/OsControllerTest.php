<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:14
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class OsControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    protected function getToken()
    {
        $oauthHeaders = [
            "client_id" 	=> "32_3dfwxjxx0kysgssckcso0cscck0wo8ks88sgkg8k4cs88kksc4",
            "client_secret" => "3mk92fc9oyww4ks0g00gw8scwoogc0ksg4wkk4cog4k44ksk8k",
            "grant_type" 	=> 'password',
            "username" 		=> "Anna",
            "password" 		=> "anna"
        ];
        $this->client->request('GET', '/oauth/v2/token', $oauthHeaders);
        $data = $this->client->getResponse()->getContent();
        $json = json_decode($data);
        $accessToken = $json->{'access_token'};
        return $accessToken;
    }

    public function testGetOsWithoutOAuth()
    {
        $this->client->request('GET', '/api/os');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testGetOsWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/os', array(), array(), $headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetOsByIDWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/os/1', array(), array(), $headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetOsByIDNotFoundWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/os/10', array(), array(), $headers);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }
}