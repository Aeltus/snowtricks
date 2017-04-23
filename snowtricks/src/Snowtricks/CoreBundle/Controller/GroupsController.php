<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 15/04/2017
 * Time: 10:35
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Form\Type\GroupForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupsController extends Controller
{

    public function indexAction(Request $request)
    {

        $addForm = $this->addGroupAction($request);
        $groups = $this->updateGroupAction($request);

        return $this->render('SnowtricksCoreBundle:Admin:groups.html.twig', array(
            'addForm' => $addForm,
            'groups' => $groups,
        ));
    }

    public function deleteAction($name){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Group');
        $group = $repository->findOneByName($name);

        $em->remove($group);
        $em->flush();

        $this->addFlash('success', 'Groupe supprimé.');

        return $this->redirectToRoute('SnowtricksCore_Admin_Groups');
    }

    public function addGroupAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')
                     ->createNamedBuilder('addGroup', GroupForm::class)
                     ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $recevedGroup = $form->getData();

            $em->persist($recevedGroup);
            $this->addFlash('success', 'Groupe créé avec success');

            $em->flush();

        }

        return $form->createView();
    }

    public function updateGroupAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Group');

        // set update forms views in group entity
        $groups = $repository->findAll();
        foreach ($groups as $group){
            $form = $this->get('form.factory')
                ->createNamedBuilder($group->getName(), GroupForm::class)
                ->getForm()
            ;

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $recevedGroup = $form->getData();

                $this->addFlash('success', 'Groupe modifié avec success');
                $em->flush();

            }

            $group->setUpdateForm($form->createView());
        }


        return $groups;
    }
}

