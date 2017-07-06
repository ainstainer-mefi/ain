<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;

class BaseApiController extends FOSRestController
{
    protected function prepareAnswer($data = ['ok'], $statusCode = 200)
    {
        return $this->handleView($this->view($data, $statusCode));
    }

    /**
     * @return User $user
     */
    protected function getUser()
    {
        return parent::getUser();
    }
}
