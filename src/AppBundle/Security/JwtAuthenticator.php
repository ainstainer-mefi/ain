<?php

namespace AppBundle\Security;

use AppBundle\Exceptions\ApiException;
use AppBundle\Security\Encoder\DefaultEncoder;
use AppBundle\Services\GoogleUserAuthenticator;
use Doctrine\ORM\EntityManager;
use KofeinStyle\Helper\Dumper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidPayloadException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserProvider;

class JwtAuthenticator extends AbstractGuardAuthenticator
{

    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;

    private $em;

    private $jwtEncoder;

    private $userAuthenticator;

    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(
        EntityManager $em,
        DefaultEncoder $jwtEncoder,
        JWTTokenManagerInterface $jwtManager,
        GoogleUserAuthenticator $userAuthenticator,
        $isDebug = false
    ){
        $this->jwtManager = $jwtManager;
        $this->em = $em;
        $this->jwtEncoder = $jwtEncoder;
        $this->isDebug = $isDebug;
        $this->userAuthenticator = $userAuthenticator;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['message' => 'Auth header required'], 401);
    }

    public function getCredentials(Request $request)
    {

        if(!$request->headers->has('Authorization')) {
            return false;
        }

        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');

        $token = $extractor->extract($request);

        if(!$token) {
            return false;
        }

        return $token;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return mixed|void
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $domains = ['ainstainer.de','gmail.com'];
        $domain = false;

        if(strpos($credentials,'@') !== false) {
            $domain = preg_replace('/.*@/', '', $credentials);
        }

        if($this->isDebug && $domain && in_array($domain,$domains)) {
            $payload = ['email' => trim($credentials)];
        } else {
            try{
                $payload = $this->jwtEncoder->decode($credentials);
            }catch (\Exception $e){
                throw new ApiException(401,$e->getMessage());
            }

        }

        if(!$payload){
            return;
        }

        $identityField = $this->jwtManager->getUserIdentityField();

        if (!isset($payload[$identityField])) {
            throw new InvalidPayloadException($identityField);
        }

        $user = $this->em->getRepository('AppBundle:User')->loadUserByIdentity($identityField, $payload[$identityField]);
        $jsonTokenPayload = json_decode($user->getGoogleAccessToken(),true);

        //$newAccessToken = $this->userAuthenticator->isAccessTokenExpired($jsonTokenPayload);
        //Dumper::dumpx($newAccessToken);


        //$this->em->persist($user);
        //$this->em->flush();


        if(!$user){
            return false;
        }

        return $user;
    }


    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => $exception->getMessage()], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }

    public function supportsRememberMe()
    {
        return false;
    }

}