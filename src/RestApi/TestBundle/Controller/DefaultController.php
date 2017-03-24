<?php

namespace RestApi\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
       return $this->render('RestApiTestBundle:Default:index.html.twig');
    }
}
