<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\GoogleConfig;

class BaseGoogleUserService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var GoogleConfig|null
     */
    protected $googleParams = null;

    /**
     * Parser constructor.
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->googleParams =  new GoogleConfig($this->container->getParameter('google'));
    }


    protected function verifyToken($token)
    {
        return true;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getClientSecretFilePath()
    {
        if (empty($this->googleParams['client_secret_path_web'])) {
            throw new \Exception('Google client secret path web can\'t be empty');
        }

        return $this->googleParams['client_secret_path_web'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getServerSecretFilePath()
    {
        if (empty($this->googleParams['client_secret_path'])) {
            throw new \Exception('Google server secret path web can\'t be empty');
        }

        return $this->googleParams['client_secret_path'];
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getScopes()
    {
        if (empty($this->googleParams['scopes'])) {
            throw new \Exception('Google scopes can\'t be empty');
        }

        return implode(' ', $this->googleParams['scopes']);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getRedirectUrl()
    {
        if (empty($this->googleParams['redirect_url'])) {
            throw new \Exception('Google redirect_url can\'t be empty');
        }

        return $this->googleParams['redirect_url'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getServerAccessToken()
    {
        if (empty($this->googleParams['credentials_path'])) {
            throw new \Exception('Google server credentials path can\'t be empty');
        }

        return json_decode(file_get_contents($this->googleParams['credentials_path']), true);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getServerAppName()
    {
        if (empty($this->googleParams['app_name'])) {
            throw new \Exception('Google server application name can\'t be empty');
        }

        return $this->googleParams['app_name'];
    }
}