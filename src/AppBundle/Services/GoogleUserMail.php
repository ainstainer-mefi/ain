<?php


namespace AppBundle\Services;

use KofeinStyle\Helper\Dumper;


class GoogleUserMail extends BaseGoogleUserService
{



    public function send($userFrom)
    {
        $accessToken = $userFrom->getGoogleAccessTokenDecoded();
        //Dumper::dumpx($accessToken);



        $client = new \Google_Client();

        $client->setScopes($this->getScopes());
        $client->setAuthConfig($this->getClientSecretFilePath());
        $client->setAccessType('offline');

        $client->setAccessToken($accessToken);



        $serviceGmail = new \Google_Service_Gmail($client);


        $message1 = \Swift_Message::newInstance('Hello ','Hello MAx'. date('H:i'));
        $message1->addPart('<div dir="ltr">Hello MAx</div>','text/html','UTF-8');
        //,'efimov.m.s@yandex.ua'
        $message1->setFrom($userFrom->getEmail(),$userFrom->getUsername())->setTo(['efimovwot@gmail.com']);
        $message1->setDate(time());





        try{
            $message = new \Google_Service_Gmail_Message();
            $message->setRaw(rtrim(strtr(base64_encode($message1->toString()), '+/', '-_'), '='));

            $result = $serviceGmail->users_messages->send('me', $message);
            Dumper::dumpx($result);
        }catch (\Google_Service_Exception $e){
            Dumper::dumpx($e->getMessage());
        }



    }
}