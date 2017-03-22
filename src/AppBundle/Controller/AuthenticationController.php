<?php

namespace AppBundle\Controller;

use KofeinStyle\Helper\Dumper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * AuthenticationController
 *
 */
class AuthenticationController extends Controller
{
    /**
     * Just to demonstrate authentication result
     *
     * @return JsonResponse
     */
    public function pingAction()
    {
        return new JsonResponse();
    }

    public function tokenAuthenticationAction(Request $request)
    {

        $email = 'efimovmaksim@gmail.com';
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);

        if(!$user) {
            throw $this->createNotFoundException();
        }

        // password check
        /*if(!$this->get('security.password_encoder')->isPasswordValid($user, $password)) {
            throw $this->createAccessDeniedException();
        }*/


        // Use LexikJWTAuthenticationBundle to create JWT token that hold only information about user name
        $token = $this->get('lexik_jwt_authentication.encoder')
            ->encode(['email' => $user->getEmail()]);

        $user->setToken($token);

        $em->persist($user);
        $em->flush();

        // Return generated token
        return new JsonResponse(['token' => $token]);

    }
}