<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 15/04/2017
 * Time: 10:35
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Entity\Group;
use Snowtricks\CoreBundle\Form\Type\AddGroupForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Group');

        $form = $this->createForm(AddGroupForm::class);

        // if new add group or update group form receved
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $recevedGroup = $form->getData();

            if ($recevedGroup->getUsedForm() == 'addForm'){
                $em->persist($recevedGroup);
                $this->addFlash('success', 'Groupe créé avec success');
            } else {
                $groupToUpdate = $repository->findOneByName($recevedGroup->getUsedForm());
                $groupToUpdate->setName($recevedGroup->getName());
                $this->addFlash('success', 'Groupe mis à jour avec success');
            }
            $em->flush();
        }

        // set update forms views in group entity
        $groups = $repository->findAll();
        foreach ($groups as $group){
            $updateForm = $this->createForm(AddGroupForm::class, $group);
            $group->setUpdateForm($updateForm->createView());
        }

        $addForm = $this->createForm(AddGroupForm::class);

        return $this->render('SnowtricksCoreBundle:Admin:groups.html.twig', array(
            'groups' => $groups,
            'addForm' => $addForm->createView(),
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
}

