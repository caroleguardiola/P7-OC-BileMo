# P7-OC-BileMo

REST API with Symfony for a company offering a selection of high-end mobile phones.
This is sales exclusively in B2B (business to business).

This project is the 7th done as part of my training (« Développeur d’applications-spécialité PHP/Symfony » OC).

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/35c192074722498a85219de335fa2701)](https://www.codacy.com/app/caroleguardiola/P7-OC-BileMo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=caroleguardiola/P7-OC-BileMo&amp;utm_campaign=Badge_Grade)

## Instructions for this project :

The REST API must be developed with Symfony.
The goal is to provide access to the catalog of BileMo to all platforms that wish via this REST API.

There 2 types of customers (platforms) which can access to the resources of BileMo :
* 	Anonymous : 
	* 	Can only access to the documentation of the REST API.
* 	Customer authenticated : 
	* 	In addition to anonymous access can also access to the list of the mobilephones.
	*   Can also access to the details of the mobilephones.
	*   Can also access to the list of registered users linked to a customer.
	*   Can also access to the details of a registered user linked to a client.
	*   Can also add a new user linked to a customer.
	*   Can also delete an user added by a customer.

The customers of the REST API must to be authenticated via Oauth or JWT.

The responses of the requests API must to be in JSON.


## Dependencies :

This project was developed with Symfony 3.4 and installed with the dependencies by Composer.
The authentication is setup with FOSOAuthServerBundle.
The customer is setup with FOSUserBundle.

Bundles installed by composer :
*  FOSRestBundle
*  JMSSerializerBundle
*  WhiteOctoberPagerfantaBundle
*  BazingaHateoasBundle
*  FOSOAuthServerBundle
*  FOSUserBundle
*  NelmioApiDocBundle

PHPUnit is installed too.


## Installation :

1.	Clone or Download this repository on your local machine.

2.	Install composer : https://getcomposer.org/

3.	In project folder open a new terminal window and execute command line : 

	```
	composer update
	```

4. 	Create the configuration in /app/config/parameters.yml :

	Copy /app/config/parameters.yml.dist and rename it in /app/config/parameters.yml and update with your parameters.

5. 	Create the database : 

	```
	php bin/console doctrine:database:create
	```

6. 	Create schema with entities : 

	```
	php bin/console doctrine:schema:update --force
	```
	
7. 	Install initial data with 3 mobilephones and 3 users linked to 3 customers (P7-OC-BileMo/BileMo/src/AppBundle/DataFixtures/ORM/LoadMobilePhones.php, P7-OC-BileMo/BileMo/src/AppBundle/DataFixtures/ORM/LoadUsers.php) : 

	```
	php bin/console doctrine:fixtures:load
	```


## Authentication with Access Token to access to the REST API :

You can use the initial data for the customer and client OAuth or you can create each other.

1.	Create a new client OAuth with the command line (the username is that of a new customer) :

	```
	php bin/console bilemo-api:oauth-server:client:create *YourUsername* --redirect-uri=*YourRedirectUri*
	```

	You get client public id and secret id.

2.	Create a new customer with the command line :

	```
	php bin/console fos:user:create
	```

	Enter the username, email and password of a new customer.

3.	To get an Access Token, go to Postman and do the request :

	```
	POST:/*YourURI*/oauth/v2/token
	```

	with the parameters in the body with raw :

	```
		{
		"grant_type": "password",
		"client_id": "YourClientPublicId",
		"client_secret": "YourClientSecret",
		"username": "YourUsername",
		"password": “YourPassword”
		}
	```

	with the parameters in the headers :

	```
	Content-type: application/json
	```


## Access to the REST API :

To access to the resources you must be authenticated with an Access Token (To get an Access Token see " Authentication with Access Token to access to the REST API").

In Postman, do requests with the parameters in the headers :

```
Authorization: Bearer *YourAccessToken*
Content-type: application/json
Accept: application/json
```

If version x.x exists, you can set the parameter :

```	
Accept: application/json;version x.x
```


## Contributing :

1.	Fork it
2.	Create your feature branch (git checkout -b my-new-feature)
3.	Commit your changes (git commit -am 'Add some feature')
4.	Push to the branch (git push origin my-new-feature)
5.	Create new Pull Request

