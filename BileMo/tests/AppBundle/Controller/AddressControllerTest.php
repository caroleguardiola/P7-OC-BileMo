<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Customer;
use AppBundle\Entity\AccesToken;
use AppBundle\Entity\Address;
use AppBundle\Entity\User;
use AppBundle\Repository\CustomerRepository;
use AppBundle\Repository\ClientRepository;
use AppBundle\Repository\AccessTokenRepository;
use AppBundle\Repository\AddressRepository;
use FOS\OAuthServerBundle\Model\AccessToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use OAuth2\OAuth2;


class AddressControllerTest extends WebTestCase
{
    private $client = null;

    private $accessToken;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /*private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('IS_AUTHENTICATED_FULLY'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }*/

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

    /**
     *
     */
    public function testGetAddressesWithoutOAuth()
    {
        $this->client->request('GET', '/api/addresses');

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param $repositories
     * @throws \ReflectionException
     */
    /*private function mockRepositories($repositories)
    {
        $EntityManager = $this->createMock(EntityManager::class);

        $EntityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositories));

        $this->client->getcontainer()->set('doctrine.orm.default_entity_manager', $EntityManager);
    }*/

    /*private function getToken()
    {
        $clientOAuth = new Client;
        //$clientOAuth -> setRandomId('30_820kqr7bt18gockgo84kggowck4sccg04wg8so04gskoc4ks0');
        $clientOAuth -> setSecret('602inetftnggg8skw40ok8k088kks8oc8okc04oo4kggoc84g0');

        $customer = new Customer;
        $customer ->setUsername('Mel');
        $customer ->setPlainPassword('mel');

        $oauthHeaders = [
            "grant_type" => "password",
            "client_id" => "30_820kqr7bt18gockgo84kggowck4sccg04wg8so04gskoc4ks0",
            "client_secret" => $clientOAuth->getSecret(),
            "username" => $customer->getUsername(),
            "password" => $customer->getPlainPassword()
        ];
        $this->client->request('GET', '/oauth/v2/token', $oauthHeaders);
        $data = $this->client->getResponse()->getContent();
        $json = json_decode($data);
        $accessToken= $json->{'access_token'};
        return $accessToken;
    }*/

    /*private function getToken()
    {
        $reflectionClass = new \ReflectionClass(Customer::class);

        $customer = new Customer;
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($customer, 5555);
        $reflectionProperty = $reflectionClass->getProperty('username');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($customer, 'Jake');
        $reflectionProperty = $reflectionClass->getProperty('plainPassword');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($customer, 'jake');

        $customerRepository = $this->createMock(CustomerRepository:: class);

        $customerRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(5555))
            ->willReturn($customer);

        $reflectionClass = new \ReflectionClass(Client::class);

        $clientOAuth = new Client;
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($clientOAuth, 7777);

        $clientRepository = $this->createMock(ClientRepository:: class);

        $clientRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($clientOAuth);

        $this->mockRepositories([
            ['AppBundle:Client', $clientRepository],
            ['AppBundle:Customer', $customerRepository],
        ]);

        $oauthHeaders = [
            "grant_type" => "password",
            "client_id" => $clientOAuth->getPublicId(),
            "client_secret" => $clientOAuth->getSecret(),
            "username" => $customer->getUsername(),
            "password" => 'jake'
        ];
        $this->client->request('GET', '/oauth/v2/token', $oauthHeaders);
        $data = $this->client->getResponse()->getContent();
        $json = json_decode($data);
        $accessToken= $json->{'access_token'};
        return $accessToken;
    }*/

    public function testGetAddressesWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/addresses', array(), array(), $headers);
        $datas = $this->client->getResponse();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        //$data = json_decode($datas->getContent(), true);
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetAddressByIDWithAccessToken()
    {
        /*$request = new Request;
        $client = new Client;
        $data = [
            "username" => "Mel",
            "password" => "mel"
        ];

        $mock = $this->createMock('OAuth2\IOAuth2Storage');
        $oauth2 = new OAuth2($mock);
        $oauth2 ->createAccessToken($client, $data);
        $accessToken = $oauth2->getBearerToken($request);*/

        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        /*$reflectionClass = new \ReflectionClass(Address::class);

        $address = new Address;
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($address, 20);

        $addressRepository = $this->createMock(AddressRepository:: class);

        $addressRepository
            ->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo(20))
            ->willReturn($address);

        $this->mockRepositories([
            ['AppBundle:Address', $addressRepository],
        ]);*/



        $this->client->request('GET', '/api/addresses/20', array(), array(), $headers);
        $datas = $this->client->getResponse();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        //$data = json_decode($datas->getContent(), true);
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetAddressByIDNotFoundWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/addresses/1', array(), array(), $headers);
        $datas = $this->client->getResponse();
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        //$data = json_decode($datas->getContent(), true);
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGetAddressByIDNoPermissionWithAccessToken()
    {
        $accessToken = $this->getToken();

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer ".$accessToken,
            'CONTENT_TYPE' => 'application/json',
        );

        $this->client->request('GET', '/api/addresses/24', array(), array(), $headers);
        $datas = $this->client->getResponse();
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
        //$data = json_decode($datas->getContent(), true);
        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }
}
