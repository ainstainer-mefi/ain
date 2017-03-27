<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseGoogleUserService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array|mixed
     */
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

    protected function getRedirectUrl()
    {
        if (empty($this->googleParams['redirect_url'])) {
            throw new \Exception('Google redirect_url can\'t be empty');
        }

        return $this->googleParams['redirect_url'];
    }
}