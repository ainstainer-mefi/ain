<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;


use KofeinStyle\Helper\Dumper;
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

        $tokenData = $this->get('app.google_user.auth')->getAccessTokenWithAuthCode($authCode);
        $tokenPayload = $this->get('app.google_user.auth')->verifyIdToken($tokenData['id_token']);

        if (empty($tokenPayload['email_verified']) || !$tokenPayload['email_verified']){
            throw $this->createNotFoundException('Google email_verified error.');
        }

        $allowDomains = $this->getParameter('allow_domains');

        $domain = preg_replace('/.*@/', '', $tokenPayload['email']);

        if (empty($tokenPayload['email_verified']) || !in_array($domain, $allowDomains)){
            throw $this->createNotFoundException('Email domain is not supported');
        }

        $email = $tokenPayload['email'];


        // Use LexikJWTAuthenticationBundle to create JWT token that hold only information about user name
        $encodeAdditionalData = [
            'email' => $email,
        ];
        $apiToken = $this->get('lexik_jwt_authentication.encoder')->encode($encodeAdditionalData);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->loadUserByIdentity('email',$email);


        if(!$user) { // create new user

            $user = new User();
            $user->setEmail($email);
            $user->setRole('ROLE_USER');
            $user->setGoogleAccessToken(json_encode($tokenData,JSON_UNESCAPED_SLASHES));

        } else {
                    #todo check refresh_token in $tokenData for exist user
            $jsonTokenPayload = json_decode($user->getGoogleAccessToken(),true);
            if (!empty($jsonTokenPayload['refresh_token'])) {
                $tokenData['refresh_token'] = $jsonTokenPayload['refresh_token'];
            }
            $user->setGoogleAccessToken(json_encode($tokenData,JSON_UNESCAPED_SLASHES));

        }

        if (empty($user->getFolderId())) {
            $storageFolderId = $this->get('app.google_drive.service')->createFolder($email);
            $user->setFolderId($storageFolderId);
        }


        /**Save user data*/
        //$user->setToken($apiToken);
        $user->setGoogleIdToken($tokenData['id_token']);
        $user->setUsername($tokenPayload['name']);

        $em->persist($user);
        $em->flush();


        $result = [
            'apiToken' => $apiToken,
            'id_token' => $tokenData['id_token'],
            'email' => $tokenPayload['email'],
            'name' =>  $tokenPayload['name'],
            'picture' =>  $tokenPayload['picture'],
            'given_name' =>  $tokenPayload['given_name'],
            'family_name' =>  $tokenPayload['family_name'],
        ];


        return $this->handleView($this->view($result, 200));


    }
}