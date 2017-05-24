<?php

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;

class BaseApiController extends FOSRestController
{
    protected function prepareAnswer($data = ['ok'], $statusCode = 200)
    {
        return $this->handleView($this->view($data, $statusCode));
    }

}
