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

//eyJhbGciOiJSUzI1NiJ9.eyJlbWFpbCI6Im1heGltLmVmaW1vdkBhaW5zdGFpbmVyLmRlIiwiZXhwIjoxNDkwMzQ5OTg1LCJpYXQiOjE0OTAzNDYzODV9.s-aIlxSdcIsTmWGkWtjUxokS_nKawoVhGld5VPgnjMyDpWHyOziYcjZPy6gvsvSE8UEJfKBTpxkhI9LDqnXzCv2vHf67Uz1OIPsfVlMB8Oz4k8ZrtVanY1dYN9D-p1gC-eEGwzhfslRcv4BxCerInbDPH-pp121TzG3vh3ozE6wyzRpVNaHka_Wqtj75XiDcmOnZI2hd1ExcjNrIifoL1DObVfA-AT8aYV8u_1q-nGz5oLdf44bHUVuqu2aW4dQykbv1RYQyHBuHXqZ2VI-_zPgJUq6BecmjcR6R70OF_GSg1r-VTe3iyvPJWJGbfwEilLd1paDRMx_pZK4Htkg-_RISRbds0jHDeC7mg1zQ4u5vrd6cNLBrl91sNGPURsfEzgAt5tLvchRCNmNoCdxGaX60Gc-JxEVwmnnZAPsHBxMhe_c-HJDa9vRhU9RasJ7DEBy3rjDK-fTPMALGvY56Rn6abW2PpfZeIfb6ks0mUCMZmgK3gkII1FtzljjxXgGYasxYekkEOJkgjZO7T2JghS_YEXDrxMlk5QO9RgVLM0eQURgmsznePAlQSuNUBJz-lrNYGr4StzW7JlGVBvUUm8LUSBY1W_prQa5N8AnW5tRgRVQMyEa92YnWD89yl84eSbHsjWhvLavYwsSMa6x0XzgmA5eapH2lb16Jlyo9qXk
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
