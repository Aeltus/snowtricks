<?php

namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Entity\TrickSearch;
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
        if($form->isValid()){
            $search = $form->getData();
        }



        $tricks = $repository->getTricks($search);

        return $this->render('SnowtricksCoreBundle:Default:index.html.twig', array(
            'tricks' => $tricks,
            'form' => $form->createView(),
            'search' => $search,
        ));
    }
}
