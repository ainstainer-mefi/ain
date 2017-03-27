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
/*
        $googleParams = $this->getContainer()->getParameter('google');
        $scopes = $googleParams['scopes'];
        $credentialsPath = $googleParams['credentials_path'];
        $clientSecretPath = $googleParams['client_secret_path'];

        $client = new \Google_Client();

        //$client->setAuthConfig($clientSecretPath);
        $client->setAccessType('offline');
        $t =[
            'access_token' => 'ya29.GlsWBHw7mZLyqh4f5ulXwSbyyx2WALL4O0e_2xr0l2rNaB8vH96L3poHGBm-fPfJWnRDDISxByVhcDOzrmdSuwErZV6nETR6KTofE6WPKWiCMZaw3kOcdivUOldr',
            //'access_token' => 'ya29.GlwXBBZgudYVLLnTRABa9PTZa3_HBjMfVJ6pfzlgkWpceuq_Gu-xfd9UNyGmc7eO46KbdDEP5zowSzU37AvbduBKsBccCL6W_BJHJ4FEhIeRn1GjWLvt-YXAJ4o1lA',

            'id_token' => 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjU5MzNhNmI0ZGFjNTRkZjIxMDBmYTE3OWNiZjVhMDE4ZTY4NTQ2YTcifQ.eyJhenAiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTUwNzc3MzIxNjA1MzcwNjc1NzkiLCJlbWFpbCI6ImVmaW1vdm1ha3NpbUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiYXRfaGFzaCI6IkdLNTZSWWpPNVRfSnprSEFkUFdXeEEiLCJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJpYXQiOjE0OTAyMjM3MjMsImV4cCI6MTQ5MDIyNzMyMywibmFtZSI6ItCV0YTQuNC80L7QsiDQnNCw0LrRgdC40LwiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDQuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1nUy1DTERZVGhGdy9BQUFBQUFBQUFBSS9BQUFBQUFBQUN3QS9pLWpXN3lMMVAzUS9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoi0JXRhNC40LzQvtCyIiwiZmFtaWx5X25hbWUiOiLQnNCw0LrRgdC40LwiLCJsb2NhbGUiOiJydSJ9.YsBmudqSOsv0xyEYaXXLXZPGIYzxmR29XzCVD9LNf5e1D7xR3HkqG6DkrN1Djbn1KtP0MsMbvJDghKLzKwQDGW940Wq_GXMq96dsXdcT3_EdABhBflZDW56ZRrOQaB9ZdU7j1ZxAuFE_LIwTbj2bpyML7_Uv5onZVH46mQABqettajxiUTXQ3L5QI6r8wYYo4fZfATbMhR_2ZPvv01RRVGiUauXNSHeUqjB8AS2F08y4rxf5LXia4H23itQP7qqLaYB__yKcytam8JRJB36DUz5YNCidNVrCW74Lv1gLki8ql79aUGxkQc-zDk_I1LCRkGgJ1cP088rdtsaxJyBb6Q',
            //'id_token' => 'eyJhbGciOiJSUzI1NiIsImtpZCI6Ijg5ODY1ZDBjOTJjYjI0ZDk4NmExMTU5MjU2YzBmZGQzMTBmOWRlNzAifQ.eyJhenAiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTUwNzc3MzIxNjA1MzcwNjc1NzkiLCJlbWFpbCI6ImVmaW1vdm1ha3NpbUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiYXRfaGFzaCI6ImpYRDRxOXItYmFBWnlvYlJhd0o1WVEiLCJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJpYXQiOjE0OTAzMDcyNTksImV4cCI6MTQ5MDMxMDg1OSwibmFtZSI6ItCV0YTQuNC80L7QsiDQnNCw0LrRgdC40LwiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDQuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1nUy1DTERZVGhGdy9BQUFBQUFBQUFBSS9BQUFBQUFBQUN3QS9pLWpXN3lMMVAzUS9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoi0JXRhNC40LzQvtCyIiwiZmFtaWx5X25hbWUiOiLQnNCw0LrRgdC40LwiLCJsb2NhbGUiOiJydSJ9.CO1uptZzmHWqUtq6e7udXVUChszLG9QwSRNZ9r9GySbXZefsyLPtPRUsgimtthuB8P7HeHkeaBn7EyJBeYH4BZUpqevlkkGPzat9bakPgJu08MnzkKJCPB8tbGcm1CErgjcosvT7QYidJB5UKarXyBgro_rJdQeLJGklDRHAnJX2j29wVcuOcf60A2htybRGEFiA9WljYYrZWe6_dQ2EZ2HRjswC0BcX4ETCbj-K2RL03SdFSVgTlqXRrnH8KsomEZJ-SbPIBfCUSO73yc3E3SFN37wJNGGQpfzah4YmCq0P9ETGSSnT3XQrovTgCxYWw0RucoSxfcHLBj-NxyLaRw',

            'expires_in' => 3600

        ];
        $t = json_encode($t);
        $client->setAccessToken($t);
        //$r = $client->verifyIdToken('eyJhbGciOiJSUzI1NiIsImtpZCI6Ijg5ODY1ZDBjOTJjYjI0ZDk4NmExMTU5MjU2YzBmZGQzMTBmOWRlNzAifQ.eyJhenAiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI2MTU5ODg3Nzc2MjQtYWJpaXU1dG1lYmtnMGVhNmQ1ODgyaW1ic211bDJoN3IuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTUwNzc3MzIxNjA1MzcwNjc1NzkiLCJlbWFpbCI6ImVmaW1vdm1ha3NpbUBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiYXRfaGFzaCI6ImpYRDRxOXItYmFBWnlvYlJhd0o1WVEiLCJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJpYXQiOjE0OTAzMDcyNTksImV4cCI6MTQ5MDMxMDg1OSwibmFtZSI6ItCV0YTQuNC80L7QsiDQnNCw0LrRgdC40LwiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDQuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1nUy1DTERZVGhGdy9BQUFBQUFBQUFBSS9BQUFBQUFBQUN3QS9pLWpXN3lMMVAzUS9zOTYtYy9waG90by5qcGciLCJnaXZlbl9uYW1lIjoi0JXRhNC40LzQvtCyIiwiZmFtaWx5X25hbWUiOiLQnNCw0LrRgdC40LwiLCJsb2NhbGUiOiJydSJ9.CO1uptZzmHWqUtq6e7udXVUChszLG9QwSRNZ9r9GySbXZefsyLPtPRUsgimtthuB8P7HeHkeaBn7EyJBeYH4BZUpqevlkkGPzat9bakPgJu08MnzkKJCPB8tbGcm1CErgjcosvT7QYidJB5UKarXyBgro_rJdQeLJGklDRHAnJX2j29wVcuOcf60A2htybRGEFiA9WljYYrZWe6_dQ2EZ2HRjswC0BcX4ETCbj-K2RL03SdFSVgTlqXRrnH8KsomEZJ-SbPIBfCUSO73yc3E3SFN37wJNGGQpfzah4YmCq0P9ETGSSnT3XQrovTgCxYWw0RucoSxfcHLBj-NxyLaRw');



        var_dump($client->isAccessTokenExpired()) ;*/

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