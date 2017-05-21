<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 22/04/2017
 * Time: 19:32
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PicturesController extends Controller
{

    public function deleteMainPageAction(Trick $trick){

        return $this->render('SnowtricksCoreBundle:Default:pictures.html.twig', array(
            'trick' => $trick,
        ));
    }

    public function deleteOneAction($idPicture, $idTrick){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SnowtricksCoreBundle:Trick');

        $trick = $repo->find($idTrick);
        foreach ($trick->getPictures() as $picture){
            if ($picture->getId() == $idPicture){
                $trick->removePicture($picture);
                $em->remove($picture);
            }
        }
        $em->flush($trick);
        return $this->redirectToRoute('SnowtricksCore_Pictures_Delete', array(
            'id' => $trick->getId(),
        ));
    }

}
