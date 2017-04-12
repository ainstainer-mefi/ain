<?php
namespace AppBundle\Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

class GoogleConfig
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * GoogleConfig constructor.
     * @param $googleParams
     */
    public function __construct($googleParams)
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->config = $googleParams;
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->accessor->getValue($this->config, '[app_name]');
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->accessor->getValue($this->config, '[redirect_url]');
    }

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->accessor->getValue($this->config, '[scopes]');
    }

    /**
     * @return string
     */
    public function getCredentialsPath()
    {
        return $this->accessor->getValue($this->config, '[credentials_path]');
    }

    /**
     * @return array
     */
    public function getCredentialsData()
    {
        return json_decode(file_get_contents($this->getCredentialsPath()), true);
    }

    /**
     * @return string
     */
    public function getClientSecretPath()
    {
        return $this->accessor->getValue($this->config, '[client_secret_path]');
    }

    /**
     * @return string
     */
    public function getClientSecretPathWeb()
    {
        return $this->accessor->getValue($this->config, '[client_secret_path_web]');
    }
}