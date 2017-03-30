<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 30.03.17
 * Time: 10:18
 */

namespace AppBundle\Entity;

class GoogleServiceConfig
{

    protected $app_name;
    protected $redirect_url;
    protected $scopes;
    protected $credentials_path;
    protected $client_secret_path;
    protected $client_secret_path_web;
    protected $accessToken;



    public function __construct($googleParams)
    {
        $this->setAppName($googleParams['app_name']);
        $this->setRedirectUrl($googleParams['redirect_url']);
        $this->setScopes($googleParams['scopes']);
        $this->setCredentialsPath($googleParams['credentials_path']);
        $this->setClientSecretPath($googleParams['client_secret_path']);
        $this->setClientSecretPathWeb($googleParams['client_secret_path_web']);
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->app_name;
    }

    /**
     * @param string $app_name
     */
    public function setAppName($app_name)
    {
        $this->app_name = $app_name;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirect_url;
    }

    /**
     * @param string $redirect_url
     */
    public function setRedirectUrl($redirect_url)
    {
        $this->redirect_url = $redirect_url;
    }

    /**
     * @return string
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param string $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * @return string
     */
    public function getCredentialsPath()
    {
        return json_decode(file_get_contents($this->credentials_path), true);
    }

    /**
     * @param string $credentials_path
     */
    public function setCredentialsPath($credentials_path)
    {
        $this->credentials_path = $credentials_path;
    }

    /**
     * @return string
     */
    public function getClientSecretPath()
    {
        return $this->client_secret_path;
    }

    /**
     * @param string $client_secret_path
     */
    public function setClientSecretPath($client_secret_path)
    {
        $this->client_secret_path = $client_secret_path;
    }

    /**
     * @return string
     */
    public function getClientSecretPathWeb()
    {
        return $this->client_secret_path_web;
    }

    /**
     * @param string $client_secret_path_web
     */
    public function setClientSecretPathWeb($client_secret_path_web)
    {
        $this->client_secret_path_web = $client_secret_path_web;
    }
}