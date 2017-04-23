<?php

namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Entity\TrickSearch;
use Snowtricks\CoreBundle\Form\Type\TrickForm;
use Snowtricks\CoreBundle\Form\Type\TrickSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('SnowtricksCoreBundle:Trick');
        $form = $this->createForm(TrickSearchForm::class);
        $search = new TrickSearch(); // creating an empty TrickSearch (width defaults values)

        // if new search form receved
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $search = $form->getData();
        }

        $tricks = $repository->getTricks($search);

        return $this->render('SnowtricksCoreBundle:Default:index.html.twig', array(
            'tricks' => $tricks,
            'form' => $form->createView(),
            'search' => $search,
        ));
    }

    public function figureAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Trick');

        $trick = $repository->findOneById($id);

        return $this->render('SnowtricksCoreBundle:Default:figure.html.twig', array(
            'trick' => $trick,
        ));
    }

    public function addAction(Request $request){

        $form = $this->createForm(TrickForm::class);

        $form->handleRequest($request);
        if ($id = $this->formHandler($form, false)){
            return $this->redirectToRoute('SnowtricksCore_Figure', array(
                'id' => $id
            ));
        }

        return $this->render('SnowtricksCoreBundle:Default:addTrick.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Création d\'une figure'
        ));

    }

    public function updateAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Trick');
        $trick = $repository->find($id);
        $form = $this->createForm(TrickForm::class, $trick);

        $form->handleRequest($request);
        if ($id = $this->formHandler($form, true)){
            return $this->redirectToRoute('SnowtricksCore_Figure', array(
                'id' => $id
            ));
        }


        return $this->render('SnowtricksCoreBundle:Default:addTrick.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Modification d\'une figure',
            'trick' => $trick
        ));
    }

    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('SnowtricksCoreBundle:Trick');

        $trick = $repository->find($id);
        $em->remove($trick);
        $em->flush();

        $this->addFlash('success', 'La figure à été supprimée.');

        return $this->redirectToRoute('snowtricks_core_homepage');
    }

    private function formHandler($form, $isAnUpdate){
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()){
            $trick = $form->getData();

            $trick->setCreatedBy(
                $this->getUser()
            );
            foreach ($trick->getVideos() as $video){
                $em->persist($video);
                if ($video->getCreatedBy() === NULL){
                    $video->setCreatedBy($this->getUser());
                    $video->setIdTrick($trick);
                }
            }
            foreach ($trick->getPictures() as $picture){
                $em->persist($picture);
                if ($picture->getCreatedBy() === NULL){
                    $picture->setCreatedBy($this->getUser());
                    $picture->setIdTrick($trick);
                }
            }
            if ($isAnUpdate){
                $message = 'La figure à été mise à jour.';
            } else {
                $message = 'La figure à été ajouté, merci :)';
                $em->persist($trick);
            }
            $em->flush();
            $this->addFlash('success', $message);

            return $trick->getId();
        }
    }
}
