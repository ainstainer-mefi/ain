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

    public function authenticationAction(Request $request)
    {

        $authCode = $request->get('auth_code');
        if(!$authCode) {
            throw $this->createNotFoundException('Auth code is empty');
        }

        $tokenData = $this->get('app.google_user')->getAccessTokenWithAuthCode($authCode);
        $tokenPayload = $this->get('app.google_user')->verifyIdToken($tokenData['id_token']);

        if (empty($tokenPayload['email_verified']) || !$tokenPayload['email_verified']){
            throw $this->createNotFoundException('Google email_verified error.');
        }

        $email = $tokenPayload['email'];

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);

        if(!$user) {
            throw $this->createNotFoundException();
        }

        // Use LexikJWTAuthenticationBundle to create JWT token that hold only information about user name
        $encodeAdditionalData = ['email' => $user->getEmail()];
        $token = $this->get('lexik_jwt_authentication.encoder')->encode($encodeAdditionalData);

        /**Save use data*/
        $user->setToken($token);
        $user->setGoogleAccessToken($tokenData['access_token']);
        $user->setGoogleIdToken($tokenData['id_token']);
        $user->setGoogleAccessTokenExpiresIn($tokenData['created'] + $tokenData['expires_in']);
        $em->persist($user);
        $em->flush();

        // Return generated token
        return new JsonResponse(
            [
                'api_token' => $token,
                //'access_token' => $tokenData['access_token'],
                'id_token' => $tokenData['id_token'],
            ]);

    }
}