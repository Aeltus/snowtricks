<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 11/04/2017
 * Time: 20:32
 */
namespace Snowtricks\OAuthBundle\Security;

use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class MyFaceBookAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManager $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/connect/facebook/check') {
            // don't auth
            return;
        }

        return $this->fetchAccessToken($this->getFacebookClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var FacebookUser $facebookUser */
        $facebookUser = $this->getFacebookClient()
            ->fetchUserFromToken($credentials);

        $email = $facebookUser->getEmail();

        // do we have a matching user by email?

        $user = $this->em->getRepository('SnowtricksCoreBundle:User')
            ->findOneBy(['mail' => $email]);

        return $user;
    }

    /**
     * @return FacebookClient
     */
    private function getFacebookClient()
    {
        return $this->clientRegistry
            ->getClient('facebook_main');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {

        $targetPath = $this->router->generate('snowtricks_core_homepage');

        return new RedirectResponse($targetPath);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $targetPath = $this->router->generate('snowtricks_core_homepage');

        $request->getSession()->getFlashBag()->add('danger', 'Authentification échouée. Votre compte facebook n\'est rattaché à aucun compte chez nous. Vous devez d\'abord créer un compte avec votre email FaceBook.' );

        return new RedirectResponse($targetPath);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $targetPath = $this->router->generate('snowtricks_core_homepage');

        $request->getSession()->getFlashBag()->add('danger', 'Authentification requise.' );

        return new RedirectResponse($targetPath);

    }
}
