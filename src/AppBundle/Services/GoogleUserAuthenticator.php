<?php

namespace AppBundle\Services;

use KofeinStyle\Helper\Dumper;


class GoogleUserAuthenticator extends BaseGoogleUserService
{

    /**
     * @param string $authCode
     * @return array
     * @throws \Exception
     */
    public function getAccessTokenWithAuthCode($authCode = '')
    {

        $client = new \Google_Client();
        $client->setApplicationName($this->googleParams->getAppName());
        $client->setAccessType('offline');
        $client->setAuthConfig($this->googleParams->getClientSecretPathWeb());
        $client->setRedirectUri($this->googleParams->getRedirectUrl());
        $client->addScope($this->googleParams->getScopes());
        $client->setApprovalPrompt('force');
        $token = $client->fetchAccessTokenWithAuthCode($authCode);

        if (empty($token) ) {
            throw new \Exception('Google checkAuthCode. Token is empty');
        }
        if (!empty($token['error'])) {
            throw new \Exception('Google checkAuthCode. '.$token['error']);
        }
        //$info = $client->verifyIdToken($tok['id_token']);
        return $token;

    }

    /**
     * @param string $id_token
     * @return array|false
     */
    public function verifyIdToken($id_token)
    {
        $client = new \Google_Client();
        $client->setAuthConfig($this->googleParams->getClientSecretPathWeb());
        return $client->verifyIdToken($id_token);
    }

}
