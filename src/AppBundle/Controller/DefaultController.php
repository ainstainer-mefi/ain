<?php

namespace AppBundle\Controller;

use KofeinStyle\Helper\Dumper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {


        $googleParams = $this->getParameter('google');
        $scopes = $googleParams['scopes'];
        $credentialsPath = $googleParams['credentials_path'];
        $clientSecretPath = $googleParams['client_secret_path'];

        $scopes = implode(' ', $scopes);


        $client = new \Google_Client();
        $client->setApplicationName($googleParams['app_name']);
        $client->setScopes($scopes);
        $client->setAuthConfig($clientSecretPath);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
        $client->setAccessToken($accessToken);


        $service = new \Google_Service_Drive($client);
        $serviceGmail = new \Google_Service_Gmail($client);


        $mailMessage = 'Hello MAx';



        $message1 = \Swift_Message::newInstance('Hello','Hello MAx');
        $message1->setFrom('maxim.efimov@ainstainer.de','Max')->setTo('efimovmaksim@gmail.com');

        try{
            $message = new \Google_Service_Gmail_Message();
            $message->setRaw(rtrim(strtr(base64_encode($message1->toString()), '+/', '-_'), '='));

            $result = $serviceGmail->users_messages->send('me', $message);
            $googleMessageId = $result->getId();
            Dumper::dumpx($result);
        }catch (\Google_Service_Exception $e){
            Dumper::dumpx($e->getMessage());
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


}
