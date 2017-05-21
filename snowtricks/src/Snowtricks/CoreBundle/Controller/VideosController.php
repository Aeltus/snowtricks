<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 22/04/2017
 * Time: 19:29
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VideosController extends Controller
{

    public function deleteMainPageAction(Trick $trick){

        return $this->render('SnowtricksCoreBundle:Default:videos.html.twig', array(
            'trick' => $trick,
        ));
    }

    public function deleteOneAction($idVideo, $idTrick){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SnowtricksCoreBundle:Trick');

        $trick = $repo->find($idTrick);
        foreach ($trick->getVideos() as $video){
            if ($video->getId() == $idVideo){
                $trick->removeVideo($video);
                $em->remove($video);
            }
        }
        $em->flush($trick);
        return $this->redirectToRoute('SnowtricksCore_Videos_Delete', array(
            'id' => $trick->getId(),
        ));
    }

}
