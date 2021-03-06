<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 28.03.17
 * Time: 11:30
 */

namespace AppBundle\Services;

use AppBundle\Entity\User;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoogleDriveService extends BaseGoogleUserService
{
    protected $client;
    protected $driveService;

    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
        $this->client = new Google_Client();
        $this->client->setApplicationName($this->googleParams->getAppName());
        $this->client->setScopes($this->googleParams->getScopes());
        $this->client->setAuthConfig($this->googleParams->getClientSecretPath());
        $this->client->setAccessType('offline');
        $this->client->setAccessToken($this->googleParams->getCredentialsData());

        $this->verifyServerToken($this->client);

        $this->driveService = new Google_Service_Drive($this->client);
    }

    /**
     * Create new folder for user in google drive
     *
     * @param string $folderName
     * @return string
     */
    public function createFolder($folderName)
    {
        $parameters = [
            'q' => "name = '$folderName' and trashed = false and mimeType = 'application/vnd.google-apps.folder'",
        ];
        $files = $this->driveService->files->listFiles($parameters);
        if($files->count() == 1){ // if folder exist
            $folderData = $files->current();
            return $folderData->getId();
        }

        $folderMetaData = new Google_Service_Drive_DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        $folder = $this->driveService->files->create($folderMetaData, [
            'fields' => 'id'
        ]);

        $this->setPermissionFolder(null, $folder->id);

        return $folder->id;
    }

    /**
     * List files in user folder in google drive.
     *
     * @param User $user
     * @return array
     */
    public function getUserFiles(User $user)
    {
        $folderId = $user->getFolderId();

        $params = [
            'fields' => 'nextPageToken, files(id, name, webViewLink, webContentLink, thumbnailLink, mimeType)',
            'q' => "'$folderId' in parents"
        ];

        $list = $this->driveService->files->listFiles($params);
        $files = [];
        foreach ($list->getFiles() as $key => $value) {
            $files[$key]['id'] = $value->getId();
            $files[$key]['name'] = $value->getName();
            $files[$key]['mimeType'] = $value->getMimeType();
            $files[$key]['webViewLink'] = $value->getWebViewLink();
            $files[$key]['webContentLink'] = $value->getWebContentLink();
            $files[$key]['thumbnailLink'] = $value->getThumbnailLink();
        }
        return $files;
    }

    /**
     * Upload any file to google drive in user folder
     *
     * @param User $user
     * @param UploadedFile $file
     * @return bool
     */
    public function uploadFile(User $user,UploadedFile $file)
    {
        $folderId = $user->getFolderId();
        $fileName = $file->getClientOriginalName();
        $fileMetaData = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$folderId]
        ]);

        $content = file_get_contents($file);
        $this->driveService->files->create($fileMetaData, [
            'data' => $content,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
        return true;
    }

    /**
     * Delete file from google drive.
     * Permanently deletes a file owned by the user without moving it to the trash.
     * If the target is a folder, all descendants owned by the user are also
     * deleted.
     *
     * @param $fileId string
     * @return bool
     */
    public function deleteFile($fileId)
    {
        $this->driveService->files->delete($fileId);
        return true;
    }

    /**
     * Set permission on user folder by domain.
     * Permission - only read files.
     * Domain - ainstainer.de
     *
     * @param User $user
     * @param string $folderId
     * @return bool
     */
    public function setPermissionFolder(User $user = null, $folderId = null)
    {
        if (is_null($user) && is_null($folderId)) {
            throw new \Exception('Error setPermissionFolder in Google drive. $user and $folderId is empty');
        }

        if (!is_null($user)) {
            $folderId = $user->getFolderId();
        }

        $this->driveService->getClient()->setUseBatch(true);

        try {
            $batch = $this->driveService->createBatch();

            $domainPermission = new Google_Service_Drive_Permission([
                'type' => 'domain',
                'role' => 'reader',
                'domain' => 'ainstainer.de'
            ]);

            $request = $this->driveService->permissions->create($folderId, $domainPermission, ['fields' => 'id']);
            $batch->add($request, 'domain');
            $batch->execute();
            return true;
        } finally {
            $this->driveService->getClient()->setUseBatch(false);
        }
    }

    /**
     * Get shared link for one file.
     *
     * @param $fileId string
     * @return string
     */
    public function getSharedLink($fileId)
    {
        $params = [
            'fields' => 'webViewLink'
        ];

        $file = $this->driveService->files->get($fileId, $params);

        return $file->getWebViewLink();
    }

    /**
     * Get content link for download file.
     *
     * @param $fileId string
     * @return string
     */
    public function getContentLink($fileId)
    {
        $param = [
            'fields' => 'webContentLink'
        ];

        $file = $this->driveService->files->get($fileId, $param);

        return $file->getWebContentLink();
    }

    /**
     * A short-lived link to the file's thumbnail, if available.
     * Typically lasts on the order of hours.
     * Only populated when the requesting app can access the file's content.
     *
     * @param $fileId string
     * @return string
     */
    public function getThumbnailLink($fileId)
    {
        $params = [
            'fields' => 'thumbnailLink'
        ];
        $file = $this->driveService->files->get($fileId, $params);

        return $file->getThumbnailLink();
    }
}