<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 05/04/2017
 * Time: 22:31
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Form\Type\UserNewPasswordForm;
use Snowtricks\CoreBundle\Form\Type\UserPasswordRecoveryForm;
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
            $user->setRoles(['ROLE_USER']);
            $user->upload();
            $user->setCheckingToken(uniqid(rand(), true));
            $user->setSalt(uniqid(rand(), true));
            $user->setPlainPassword($user->getSalt().$user->getPlainPassword());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Bienvenue à vous '.$user->getSurname()." ".$user->getName().". Pour activer votre compte, cliquez sur le lien envoyé sur votre boite mail.");

            $message = \Swift_Message::newInstance()
                ->setSubject('Validation de votre compte Snowtricks')
                ->setTo($user->getMail())
                ->setBody(
                    $this->renderView(
                        'SnowtricksCoreBundle:Email:register.html.twig',
                        array('user' => $user)
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('snowtricks_core_homepage');

        }

        return $this->render('SnowtricksCoreBundle:Default:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function checkAction($token)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:User');

        if ($user = $repository->findOneBy(array('checking_token' =>$token))){
            $user->setCheckingToken(NULL);
            $user->setChecked(True);
            $em->flush();

            $this->addFlash('success', 'Bienvenue à vous '.$user->getSurname()." ".$user->getName().". Votre compte est maintenant activé, vous pouvez vous connecter.");
        } else {
            $this->addFlash('danger', 'Le lien sur lequel vous avez cliqué semble corrumpu.');
        }

        return $this->redirectToRoute('snowtricks_core_homepage');
    }

    public function resetPasswordAction(Request $request)
    {
        $form = $this->createForm(UserPasswordRecoveryForm::class);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('SnowtricksCoreBundle:User');
            $user = $form->getData();

            $user = $repository->findOneBy(array('mail' => $user->getMail()));
            $user->setCheckingToken(uniqid(rand(), true));
            $em->flush();

            $this->addFlash('warning', 'Un mail de confirmation viens de vous être envoyé, merci de cliquer sur le lien qu\'il contiens.');

            $message = \Swift_Message::newInstance()
                ->setSubject('Réinitialisation de votre mot de passe')
                ->setTo($user->getMail())
                ->setBody(
                    $this->renderView(
                        'SnowtricksCoreBundle:Email:recovery.html.twig',
                        array('user' => $user)
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);
        }

        return $this->render('SnowtricksCoreBundle:Default:recovery.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function newPasswordAction(Request $request, $token)
    {
        $form = $this->createForm(UserNewPasswordForm::class);

        $form->handleRequest($request);
        if ($form->isValid()){
            $formUser = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('SnowtricksCoreBundle:User');

            if($user = $repository->findOneBy(array('checking_token' =>$token))){

                $user->setSalt(uniqid(rand(), true));
                $user->setPlainPassword($user->getSalt().$formUser->getPlainPassword());
                $user->setCheckingToken(NULL);

                $em->flush();
                $this->addFlash('success', 'Votre nouveau mot de passe est opérationnel.');

                return $this->redirectToRoute('snowtricks_core_homepage');

            } else {
                $this->addFlash('danger', 'Il semblerait que le lien que vous avez suivi ne marche plus.');
            }
        }

        return $this->render('SnowtricksCoreBundle:Default:newPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
