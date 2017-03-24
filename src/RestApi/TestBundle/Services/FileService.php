<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 16.03.17
 * Time: 14:47
 */

namespace RestApi\TestBundle\Services;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

class FileService
{
    protected $appKey;
    protected $appSecret;
    protected $accessToken;
    protected $box;
    protected $dropbox;

    public function __construct($appKey, $appSecret, $accessToken, $box = 'dropbox')
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->acessToken = $accessToken;
        $this->box = $box;

        $app = new DropboxApp($appKey, $appSecret, $accessToken);

        $this->dropbox = new Dropbox($app);
    }

    public function listAll()
    {
        $listFolderContents = $this->dropbox->listFolder("/");

        $items = $listFolderContents->getItems();

        return $items->all();
    }

    public function upload($file)
    {
        $dropboxFile = new DropboxFile($file);

        $upload = $this->dropbox->upload($dropboxFile, '/TestImage', ['autorename' => true]);

        return $upload->getName();
    }

    public function listByUser($email)
    {
        $userName = strstr($email, '@', true);

        $listFolderContents = $this->dropbox->listFolder('/Application/AinstainerTeam/' . $userName . '/');

        $items = $listFolderContents->getItems();

        return $items->all();
    }

    public function listLinks()
    {
       $listFolderContents = $this->dropbox->listFolder('/Application/AinstainerTeam/Usenko/');

       $items = $listFolderContents->getItems();

//       $result = [];
//
//       foreach ($items as $item)
//       {
//           $link = $this->dropbox->getTemporaryLink($item->getPathLower());
//
//           $result[] = $link->getLink();
//       }
//
//       return $result;

        //Get Temporary Link
        $response = $this->dropbox->postToAPI('/sharing/create_shared_link', ['path' => '/application/ainstainerteam/maks/koh-01.jpg']);

        //Make and Return the Model
        return $this->dropbox->makeModelFromResponse($response);


    }
}