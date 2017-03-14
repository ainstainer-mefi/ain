<?php

namespace Usenko\TestImageBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Usenko\TestImageBundle\Entity\Image;
use Usenko\TestImageBundle\Form\ImageType;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UsenkoTestImageBundle:Default:index.html.twig');
    }
    /**
     * @Route("/image/new", name="app_new")
     */
    public function newAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $image->getImage();
            $fileName = $this->get('app.image_uploader')->upload($file);
            $image->setImage($fileName);
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}