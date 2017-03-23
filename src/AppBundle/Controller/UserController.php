<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;


use KofeinStyle\Helper\Dumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;


class UserController extends FOSRestController
{
    public function secureResourceAction(Request $request)
    {
        $data = [$this->getUser()->getUsername(),json_decode($this->getUser()->getGoogleAccessToken(),1)] ;


        return $this->handleView($this->view($data, 200));
    }
}