<?php

namespace AppBundle\Services;

use KofeinStyle\Helper\Dumper;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GoogleUserAuthenticator
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $googleParams = [];



    /**
     * Parser constructor.
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->googleParams =  $this->container->getParameter('google');
    }

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


    public function verifyIdToken($id_token)
    {
        $client = new \Google_Client();
        $client->setAuthConfig($this->getClientSecretFilePath());
        return $client->verifyIdToken($id_token);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function getClientSecretFilePath()
    {
        if (empty($this->googleParams['client_secret_path_web'])) {
            throw new \Exception('Google client secret path web can\'t be empty');
        }

        return $this->googleParams['client_secret_path_web'];
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getScopes()
    {
        if (empty($this->googleParams['scopes'])) {
            throw new \Exception('Google scopes can\'t be empty');
        }

        return implode(' ', $this->googleParams['scopes']);
    }

    private function getRedirectUrl()
    {
        if (empty($this->googleParams['redirect_url'])) {
            throw new \Exception('Google redirect_url can\'t be empty');
        }

        return $this->googleParams['redirect_url'];
    }
}