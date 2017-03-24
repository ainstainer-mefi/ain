<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 14.03.17
 * Time: 19:08
 */

namespace RestApi\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('RestApiTestBundle:Default:index.html.twig');
    }

    public function idAction(Request $request)
    {
        $response = new JsonResponse();

        $id = $request->query->get('id');

        $response->setData([
            'id' => $id,
            'status' => Response::HTTP_OK
        ]);

        return $response;
    }

    public function postAction(Request $request)
    {
        $name = $request->get('name');
        $role = $request->get('role');


        $dir = $this->get('kernel')->getRootDir() . '/../web/images/files/';
        $fileName = uniqid() . '.jpeg';

        foreach ($request->files as $uploadedFile) {
            $uploadedFile->move($dir, $fileName);
        }

        $file = $this->get('kernel')->getRootDir() . '/../web/images/files/' . $fileName;

        $fileStatus = '';

        if (file_exists($file)) {
            $fileStatus = 'OK, Image uploaded!';
        }

        $response = new JsonResponse();

        $response->setData([
            'name' => $name,
            'role' => $role,
            'status' => Response::HTTP_OK,
            'file_status' => $fileStatus
        ]);

        return $response;
    }
}