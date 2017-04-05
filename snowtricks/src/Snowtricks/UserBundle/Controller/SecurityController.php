<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 03/04/2017
 * Time: 20:53
 */
namespace Snowtricks\UserBundle\Controller;

use Snowtricks\UserBundle\Form\Type\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request){
        // If visitor is already authenticated, we redirect to home page
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('snowtricks_core_homepage');
        }

        /* if user has already gave a form */
        $authenticationUtils = $this->get('security.authentication_utils');

        /* Authentication form */
        $form = $this->createForm(LoginForm::class, [
            '_username' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('SnowtricksUserBundle:Security:login.html.twig', array(
            'error'         => $authenticationUtils->getLastAuthenticationError(),
            'form'          => $form->createView(),
        ));
    }
}
