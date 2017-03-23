<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;


use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;


class UserController extends FOSRestController
{
    public function secureResourceAction(Request $request)
    {
        $data = [
            'test' => 'test',
            'test2' => 'test2'
        ];

        return $this->handleView($this->view($data, 200));
    }
}