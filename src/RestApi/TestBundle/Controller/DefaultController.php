<?php

namespace RestApi\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_Permission;
use Google_Service_Exception;
use Symfony\Component\Config\Definition\Exception\Exception;

define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CREDENTIALS_PATH', '../.credentials/drive-php-quickstart.json');
define('CLIENT_SECRET_PATH', '../client_secret_951933054664-u2fh085f2769o1qm7ab9ev66rgqufjv8.apps.googleusercontent.com.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/drive-php-quickstart.json
define('SCOPES', implode(' ', array(
        Google_Service_Drive::DRIVE_METADATA_READONLY)
));

class DefaultController extends Controller
{
    public function indexAction()
    {
       return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function googleAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
        $optParams = array(
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name, webViewLink, webContentLink)'
        );
        $results = $service->files->listFiles($optParams);

        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                printf("%s (%s)\n", $file->getName(), $file->getId()) . '<br />';
                var_dump($file->getWebViewLink());
            }
        }

//        $fileId = '0B51zApwnMv3dNVJJdjN5eDFic3c';
//        $service->getClient()->setUseBatch(true);
//
//        try {
//            $batch = $service->createBatch();
//            $userPermission = new Google_Service_Drive_Permission([
//                'type' => 'user',
//                'role' => 'reader',
//                'emailAddress' => 'maxim.efimov@ainstainer.de'
//            ]);
//            $request = $service->permissions->create($fileId, $userPermission, ['fields' => 'id']);
//            $batch->add($request, 'user');
//            $results = $batch->execute();
//
//            foreach ($results as $result)
//            {
//                if ($result instanceof Google_Service_Exception) {
//                    printf($result);
//                } else {
//                    printf("Permission ID: %s\n", $result->id);
//                }
//            }
//        } finally {
//            $service->getClient()->setUseBatch(true);
//        }

        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function uploadAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);


        $fileMetaData = new \Google_Service_Drive_DriveFile([
            'name' => 'nfs.jpg'
        ]);

        $content = file_get_contents('images/files/nfs.jpg');

        $file = $service->files->create($fileMetaData, [
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
        printf("File ID: %s\n", $file->id);

        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function deleteAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);
        $fileId = '0B51zApwnMv3dUWdEMmYwS3pRSUU';
        try {
            $service->files->delete($fileId);
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function getPermissionsAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);

        var_dump($permissions = $service->permissions->listPermissions('0B51zApwnMv3dNVJJdjN5eDFic3c')->getPermissions());
        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function deletePermissionAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);

        $service->permissions->delete('0B51zApwnMv3dNVJJdjN5eDFic3c', 'anyoneWithLink');
        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function anyOnePermissionAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);

        $fileId = '0B51zApwnMv3dNVJJdjN5eDFic3c';
        $service->getClient()->setUseBatch(true);

        try {
            $batch = $service->createBatch();
            $userPermission = new Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);
            $request = $service->permissions->create($fileId, $userPermission, ['fields' => 'id']);
            $batch->add($request, 'user');
            $results = $batch->execute();

            foreach ($results as $result)
            {
                if ($result instanceof Google_Service_Exception) {
                    printf($result);
                } else {
                    printf("Permission ID: %s\n", $result->id);
                }
            }
        } finally {
            $service->getClient()->setUseBatch(true);
        }

        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function domainPermissionAction()
    {
        $client = new Google_Client();
        $client->setApplicationName(APPLICATION_NAME);
        $client->setScopes(SCOPES);
        $client->setAuthConfig(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');
        $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

        $client->setAccessToken($accessToken);
        $service = new Google_Service_Drive($client);

        $fileId = '0B51zApwnMv3dNVJJdjN5eDFic3c';
        $service->getClient()->setUseBatch(true);
        try {
            $batch = $service->createBatch();
            $domainPermission = new Google_Service_Drive_Permission([
                'type' => 'domain',
                'role' => 'reader',
                'domain' => 'ainstainer.de'
            ]);
            $request = $service->permissions->create($fileId, $domainPermission, ['fields' => 'id']);
            $batch->add($request, 'user');
            $results = $batch->execute();

            foreach ($results as $result)
            {
                if ($result instanceof Google_Service_Exception) {
                    printf($result);
                } else {
                    printf("Permission ID: %s\n", $result->id);
                }
            }
        } finally {
            $service->getClient()->setUseBatch(true);
        }

        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }
}
