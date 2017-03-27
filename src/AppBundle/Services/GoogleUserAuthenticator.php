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
        $appName = empty($this->googleParams['app_name']) ? 'My Application' : $this->googleParams['app_name'];

        $client = new \Google_Client();
        $client->setApplicationName($appName);
        $client->setAccessType('offline');
        $client->setAuthConfig($this->getClientSecretFilePath());
        $client->setRedirectUri($this->getRedirectUrl());
        $client->addScope($this->getScopes());
        $client->setApprovalPrompt('force');
        $token = $client->fetchAccessTokenWithAuthCode($authCode);

        if (empty($token) || !empty($token['error'])) {
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
        $client->setAuthConfig($this->getClientSecretFilePath());
        return $client->verifyIdToken($id_token);
    }


}