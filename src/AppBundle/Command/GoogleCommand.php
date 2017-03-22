<?php
namespace AppBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
class GoogleCommand  extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:google-create-credentials')
            // the short description shown while running "php bin/console list"
            ->setDescription('Store the credentials to disk.')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $googleParams = $this->getContainer()->getParameter('google');
        $scopes = $googleParams['scopes'];
        $credentialsPath = $googleParams['credentials_path'];
        $clientSecretPath = $googleParams['client_secret_path'];
        $scopes = implode(' ', $scopes);
        $client = new \Google_Client();
        $client->setApplicationName($googleParams['app_name']);
        $client->setScopes($scopes);
        $client->setAuthConfig($clientSecretPath);
        $client->setAccessType('offline');
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            // Store the credentials to disk.
            if(!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);
        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
        print_r($client) ;
    }
}