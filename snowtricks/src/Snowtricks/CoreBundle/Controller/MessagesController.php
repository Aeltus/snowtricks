<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 24/04/2017
 * Time: 18:40
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Form\Model\MessageSearch;
use Snowtricks\CoreBundle\Entity\Trick;
use Snowtricks\CoreBundle\Form\Type\MessageForm;
use Snowtricks\CoreBundle\Form\Type\MessageSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

class MessagesController extends Controller
{

    public function indexAction(Trick $trick,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $messageRepo = $em->getRepository('SnowtricksCoreBundle:Message');

        $addForm = $this->addMessage($request, $trick);
        $updateForm = $this->updateMessage($request, $trick);

        $searchForm = $this->createForm(MessageSearchForm::class);
        $searchForm->handleRequest($request);
        if($searchForm->isSubmitted() && $searchForm->isValid()){
            $search = $searchForm->getData();
        } else {
            $search = new MessageSearch();
            $searchForm->setData($search);
        }

        $messages = $messageRepo->findMessagesForTrick($trick, $search);

        return $this->render('SnowtricksCoreBundle:Default:messages.html.twig', array(
            'form' => $addForm,
            'updateForm' => $updateForm,
            'messages' => $messages,
            'searchForm' => $searchForm->createView(),
            'search' => $search
        ));
    }

    private function addMessage(Request $request, Trick $trick)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')
                     ->createNamedBuilder('addMessage', MessageForm::class)
                     ->getForm()
        ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $message = $form->getData();
            $message->setCreatedBy($this->getUser());
            $message->setTrick($trick);

            $em->persist($message);
            $em->flush();

            $form = $this->get('form.factory')
                ->createNamedBuilder('addMessage', MessageForm::class)
                ->getForm()
            ;
        }
        return $form->createView();
    }

    private function updateMessage(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')
                     ->createNamedBuilder('updateMessage', MessageForm::class)
                     ->getForm()
        ;
        $form->add('id', HiddenType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $recevedMessage = $form->getData();
            $repo = $em->getRepository('SnowtricksCoreBundle:Message');
            $message = $repo->find($recevedMessage->getId());
            $message->setMessage('<<Ce message à été modéré, en voici la raison : '.$recevedMessage->getMessage().' >>');

            $em->flush();

            $form = $this->get('form.factory')
                ->createNamedBuilder('updateMessage', MessageForm::class)
                ->getForm()
            ;
            $form->add('id', HiddenType::class);
        }
        return $form->createView();
    }

}
