<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 28.03.17
 * Time: 11:30
 */

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Google_Client;
use Google_Service_Drive;

class GoogleDriveService
{
    protected $client;
    protected $driveService;
    protected $container;
    protected $accessToken;
    protected $googleParams = [];

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->googleParams = $this->container->getParameter('google');

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->googleParams['app_name']);
        $this->client->setScopes($this->googleParams['scopes']);
        $this->client->setAuthConfig($this->googleParams['client_secret_path']);
        $this->client->setAccessType('offline');
        $this->accessToken = json_decode(file_get_contents($this->googleParams['credentials_path']), true);
        $this->client->setAccessToken($this->accessToken);

        $this->driveService = new Google_Service_Drive($this->client);
    }

    public function createFolder($email)
    {

    }

    public function listFilesOnDisc()
    {
        $params = [
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name)'
        ];

        $results = $this->driveService->files->listFiles($params);
        if (count($results->getFiles()) == 0) {
            return print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
               return printf("%s (%s)\n", $file->getName(), $file->getId()) . '<br />';
            }

        }
    }

    public function listFiles($userId)
    {

    }

    public function getFile()
    {

    }

    public function uploadFile()
    {

    }

    public function deleteFile($fileId)
    {

    }

    public function getPermissionFolder()
    {

    }

    public function getPermissionUser()
    {

    }

    public function deletePermission()
    {

    }

    public function getSharedLink()
    {

    }
}