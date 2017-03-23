<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;


use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;

/**
 * AuthenticationController
 *
 */
class AuthenticationController extends BaseApiController
{

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

        #todo need refactoring
        if (empty($tokenPayload['hd']) || $tokenPayload['hd'] != 'ainstainer.de'){
            throw $this->createNotFoundException('Email domain is not supported');
        }

        $email = $tokenPayload['email'];

        // Use LexikJWTAuthenticationBundle to create JWT token that hold only information about user name
        $encodeAdditionalData = ['email' => $email];
        $apiToken = $this->get('lexik_jwt_authentication.encoder')->encode($encodeAdditionalData);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->loadUserByEmail($email);


        if(!$user) { // create new user
            $user = new User();
            $user->setEmail($email);
            $user->setRole('ROLE_USER');
        }


        /**Save user data*/
        $user->setToken($apiToken);
        $user->setGoogleAccessToken($tokenData['access_token']);
        $user->setGoogleIdToken($tokenData['id_token']);
        $user->setGoogleAccessTokenExpiresIn($tokenData['created'] + $tokenData['expires_in']);
        $user->setUsername($tokenPayload['name']);
        if( !empty($tokenData['refresh_token']) ) {
            $user->setGoogleRefreshToken($tokenData['refresh_token']);
        }

        $em->persist($user);
        $em->flush();


        $result = [
            'apiToken' => $apiToken,
            'id_token' => $tokenData['id_token'],
        ];


        return $this->handleView($this->view($result, 200));


    }
}