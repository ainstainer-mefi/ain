<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 30.03.17
 * Time: 10:18
 */

namespace AppBundle\Entity;

use Symfony\Component\PropertyAccess\PropertyAccess;

class GoogleConfig
{
    protected $accessor;
    protected $config = [];



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
        return json_decode(file_get_contents($this->accessor->getValue($this->config, '[credentials_path]')), true);
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