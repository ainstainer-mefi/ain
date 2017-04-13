<?php

namespace AppBundle\Services;

use KofeinStyle\Helper\Dumper;
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

    /**
     * @param $client \Google_Client
     * @return bool
     */
    protected function verifyServerToken($client)
    {
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($this->googleParams->getCredentialsPath(), json_encode($client->getAccessToken()));
            return true;
        }

        return false;

    }
}
