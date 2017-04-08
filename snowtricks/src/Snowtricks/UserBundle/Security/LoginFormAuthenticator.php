<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 05/04/2017
 * Time: 19:33
 */
namespace Snowtricks\UserBundle\Security;

use Doctrine\ORM\EntityManager;
use Snowtricks\UserBundle\Form\Type\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator{

    use TargetPathTrait;

    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
        if (!$isLoginSubmit) {
            // skip authentication
            return;
        }

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository('Snowtricks\CoreBundle\Entity\User')
            ->findOneBy(['username' => $username]);
    }
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];
        $password = $user->getSalt().$password;

        if ($this->passwordEncoder->isPasswordValid($user, $password) && $user->isChecked() === TRUE)
        {
            $user->setCheckingToken(NULL);
            $em = $this->em;
            $em->persist($user);
            $em->flush();
            return true;
        }
        return false;
    }
    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if(!$targetPath){
            $targetPath = $this->router->generate($request->get('_route'));
        }

        return new RedirectResponse($targetPath);
    }

}
