<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 14/05/2018
 * Time: 11:16
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
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

    public function testGetUsersWithoutOAuth()
    {
        $this->client->request('GET', '/api/users');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    public function testGetUsersWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/users', array(), array(), $headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetUserByIDWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/users/31', array(), array(), $headers);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetUserByIDNotFoundWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/users/10', array(), array(), $headers);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetUserByIDNoPermissionWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/users/35', array(), array(), $headers);
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testCreateUserWithAccessToken()
    {
        $accessToken = $this->getToken();

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
        /*$user = array(
            'username' => 'Mila',
            'first_name' => 'Mila',
            'last_name' => 'Moon',
            'email' => 'mila.moon@gmail.com',
            'plain_password' => 'mila',
            'adresses' => array(
                'recipient' => 'Mila Moon',
                'street_address' => '70 cours Gambetta',
                'zip_code' => '69003',
                'city' => 'Lyon',
                'country' => 'FRANCE',
            )
        );*/

        $this->client->request('POST', '/api/users', array(), array(), $headers, $data);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testDeleteUserWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('DELETE', '/api/users/52', array(), array(), $headers);
        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
}