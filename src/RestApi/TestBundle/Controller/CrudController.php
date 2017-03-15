<?php

namespace RestApi\TestBundle\Controller;

use RestApi\TestBundle\Entity\Crud;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Crud controller.
 *
 */
class CrudController extends FOSRestController
{
    /**
     * @Rest\Get("/crud")
     *
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();
//
//        $cruds = $em->getRepository('RestApiTestBundle:Crud')->findAll();
//
//        return $this->render('crud/index.html.twig', array(
//            'cruds' => $cruds,
//        ));
        $result = $this->getDoctrine()->getRepository('RestApiTestBundle:Crud')->findAll();
        if ($result === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * Creates a new crud entity.
     * @Rest\Post("/crud/")
     */
    public function newAction(Request $request)
    {
//        $crud = new Crud();
//        $form = $this->createForm('RestApi\TestBundle\Form\CrudType', $crud);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($crud);
//            $em->flush($crud);
//
//            return $this->redirectToRoute('crud_show', array('id' => $crud->getId()));
//        }
//
//        return $this->render('crud/new.html.twig', array(
//            'crud' => $crud,
//            'form' => $form->createView(),
//        ));

        $data = new Crud();

        $firstName = $request->get('firstname');
        $lastName = $request->get('lastname');
        $logoFile = $request->files->get('logo');
        $userRole = $request->get('role');

        if (empty($firstName) || empty($lastName) || empty($logoFile) || empty($userRole))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $data->setFirstName($firstName);
        $data->setLastName($lastName);
        $data->setUserRole($userRole);

        $dir = $this->get('kernel')->getRootDir() . '/../web/images/files';
        $logoName = uniqid() . '.jpeg';

        $logoFile->move($dir, $logoName);

        if (file_exists($this->get('kernel')->getRootDir() . '/../web/images/files/' . $logoName)) {
            $data->setLogoFile($logoName);
        } else {
            return new View("Logo not found", Response::HTTP_NOT_FOUND);
        }

        $result = $this->getDoctrine()->getManager();
        $result->persist($data);
        $result->flush();

        return new View("User Added Successfully", Response::HTTP_OK);
    }

    /**
     * Finds and displays a crud entity.
     *
     */
//    public function showAction(Crud $crud)
    /**
     * @Rest\Get("/crud/{id}")
    */
    public function showAction($id)
    {
//        $deleteForm = $this->createDeleteForm($crud);
//
//        return $this->render('crud/show.html.twig', array(
//            'crud' => $crud,
//            'delete_form' => $deleteForm->createView(),
//        ));
        $user = $this->getDoctrine()->getRepository('RestApiTestBundle:Crud')->find($id);
        if ($user === null) {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        return $user;
    }

    /**
     * Displays a form to edit an existing crud entity.
     * @Rest\Post("/crud/{id}")
     */
    public function editAction($id, Request $request)
    {
//        $deleteForm = $this->createDeleteForm($crud);
//        $editForm = $this->createForm('RestApi\TestBundle\Form\CrudType', $crud);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('crud_edit', array('id' => $crud->getId()));
//        }
//
//        return $this->render('crud/edit.html.twig', array(
//            'crud' => $crud,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));

        $data = new Crud();

        $firstName = $request->get('firstname');
        $lastName = $request->get('lastname');
        $logoFile = $request->files->get('logo');
        $userRole = $request->get('role');



        $result = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('RestApiTestBundle:Crud')->find($id);

        if (empty($user))
        {
            return new View("User not found!", Response::HTTP_NOT_FOUND);
        }

        if (empty($firstName) && empty($lastName) && empty($userRole) && empty($logoFile))
        {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }

        $file = $this->get('kernel')->getRootDir() . '/../web/images/files/' . $user->getLogoFile();

        unlink($file);

        $dir = $this->get('kernel')->getRootDir() . '/../web/images/files';
        $logoName = uniqid() . '.jpeg';

        $logoFile->move($dir, $logoName);

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setLogoFile($logoName);
        $user->setUserRole($userRole);

        $result->flush();

        return new View("User Updated Successfully", Response::HTTP_OK);
    }
//    public function deleteAction(Request $request, Crud $crud)
    /**
     * Deletes a crud entity.
     * @Rest\Delete("/crud/{id}")
     */
    public function deleteAction($id)
    {
//        $form = $this->createDeleteForm($crud);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($crud);
//            $em->flush($crud);
//        }
//
//        return $this->redirectToRoute('crud_index');
        $data = new Crud();
        $result = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('RestApiTestBundle:Crud')->find($id);

        if (empty($user))
        {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        } else {
            $file = $this->get('kernel')->getRootDir() . '/../web/images/files/' . $user->getLogoFile();
                unlink($file);
            $result->remove($user);
            $result->flush();
        }
        return new View("Deleted successfully", Response::HTTP_OK);
    }

    /**
     * Creates a form to delete a crud entity.
     *
     * @param Crud $crud The crud entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Crud $crud)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_delete', array('id' => $crud->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
