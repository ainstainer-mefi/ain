<?php

namespace AppBundle\Services;

use KofeinStyle\Helper\Dumper;
use AppBundle\Entity\User;

/**
 * Class GoogleUserMail
 * @package AppBundle\Services
 */
class GoogleUserMail extends BaseGoogleUserService
{


    public function send(User $userFrom, \Swift_Message $message)
    {
        $accessToken = $userFrom->getGoogleAccessTokenDecoded();
        $message->setFrom($userFrom->getEmail(),$userFrom->getUsername());

        $client = new \Google_Client();
        $client->setScopes($this->googleParams->getScopes());
        $client->setAuthConfig($this->googleParams->getClientSecretPathWeb());
        $client->setAccessType('offline');
        $client->setAccessToken($accessToken);

        #TODO add refresh token if Token Expired
        if ($client->isAccessTokenExpired()) {
            //$accessToken = $client->refreshToken($client->getRefreshToken());
        }


        $service = new \Google_Service_Gmail($client);

        try{
            $gmailMessage = new \Google_Service_Gmail_Message();
            $gmailMessage->setRaw(rtrim(strtr(base64_encode($message->toString()), '+/', '-_'), '='));

            return  $service->users_messages->send('me', $gmailMessage);

        }catch (\Google_Service_Exception $e){
            //Dumper::dumpx($e->getErrors());
            throw new \Exception('Error sending google email');
        }

    }
}
