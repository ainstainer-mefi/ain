<?php

namespace AppBundle\Controller;


use KofeinStyle\Helper\Dumper;
use Symfony\Component\HttpFoundation\Request;

class FileController extends BaseApiController
{
    public function getUserFilesAction()
    {
        $data  = $this->get('app.google_drive.service')->getUserFiles($this->getUser());

        return $this->prepareAnswer($data);
    }

    public function proxyAction(Request $request)
    {
        $url = $request->get('url','');
        if (empty($url)) {
            return '';
        }
        $imginfo = getimagesize( $url );

        header('Content-type:' . $imginfo['mime']);
        readfile( $url );
        die();

    }
}