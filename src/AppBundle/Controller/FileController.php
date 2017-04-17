<?php

namespace AppBundle\Controller;


class FileController extends BaseApiController
{
    public function getUserFilesAction()
    {
        $data  = $this->get('app.google_drive.service')->getUserFiles($this->getUser());

        return $this->prepareAnswer($data);
    }
}