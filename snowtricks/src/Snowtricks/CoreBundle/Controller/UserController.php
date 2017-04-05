<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 05/04/2017
 * Time: 22:31
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Form\Type\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function registerAction(Request $request){
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);
        if($form->isValid()){
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Bienvenue à vous '.$user->getSurname()." ".$user->getName().".");

            return $this->redirectToRoute('snowtricks_core_homepage');
        }

        return $this->render('SnowtricksCoreBundle:Default:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
