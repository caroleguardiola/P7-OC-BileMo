<?php
/**
 * Created by PhpStorm.
 * User: Carole Guardiola
 * Date: 27/04/2018
 * Time: 10:29
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateOAuthClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bilemo-api:oauth-server:client:create')
            ->setDescription('Creates a new OAuth client BileMo')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'OAuth Client Username?'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setUsername($input->getArgument('username'));
        $client->setRedirectUris(array('http://localhost/P7/P7_OC_BileMo/BileMo/web/app_dev.php/'));
        $client->setAllowedGrantTypes(array('password', 'refresh_token', 'authorization_code'));
        $clientManager->updateClient($client);

        $output->writeln(
            sprintf(
                'Added a new OAuth client BileMo with name <info>%s</info>, public id <info>%s</info>, secret <info>%s</info>',
                $client->getUsername(),
                $client->getPublicId(),
                $client->getSecret()
            )
        );
    }
}