<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 11:59
 */
namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\Picture;
use Snowtricks\CoreBundle\Entity\Trick;
use Snowtricks\CoreBundle\Entity\Video;

class LoadTrickData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $tricks = array(
            ["title" => "Mute", "description" => "Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.", "group" => "Grabs"],
            ["title" => "Sad", "description" => "Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.", "group" => "Grabs"],
            ["title" => "Indy", "description" => "Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.", "group" => "Grabs"],
            ["title" => "Stalefish", "description" => "Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.", "group" => "Grabs"],
            ["title" => "180", "description" => "Désigne un demi-tour, soit 180 degrés d'angle.", "group" => "Rotations"],
            ["title" => "360", "description" => "Trois six pour un tour complet.", "group" => "Rotations"],
            ["title" => "540", "description" => "Cinq quatre pour un tour et demi.", "group" => "Rotations"],
            ["title" => "720", "description" => "Sept deux pour deux tours complets.", "group" => "Rotations"],
            ["title" => "Back flip", "description" => "Rotation arrière.", "group" => "Flips"],
            ["title" => "Front flip", "description" => "Rotation avant.", "group" => "Flips"]
        );

        /** Persist DATA
         * =====================================*/
        $x=0;
        $userNbr = 0;
        $pictureNbr = 0;
        $videoNbr = 0;
        foreach ($tricks as $trickData){

            $trick = new Trick();
            $trick->setTitle($trickData['title']);
            $trick->setDescription($trickData['description']);
            $trick->setGroup($this->getReference($trickData['group']));
            $trick->setCreatedBy($this->getReference('user'.$userNbr));

            if ($x == 0){
                for ($i = 0; $i < 5; $i++){
                    $trick->addPicture($this->getReference('picture'.$pictureNbr));
                    $pictureNbr++;
                }
                for ($i = 0; $i < 5; $i++){
                    $trick->addVideo($this->getReference('video'.$videoNbr));
                    $videoNbr++;
                }
            } elseif ($x == 1){
                for ($i = 0; $i < 4; $i++){
                    $trick->addPicture($this->getReference('picture'.$pictureNbr));
                    $pictureNbr++;
                }
            } elseif ($x == 2){
                for ($i = 0; $i < 4; $i++){
                    $trick->addVideo($this->getReference('video'.$videoNbr));
                    $videoNbr++;
                }
            } elseif ($x == 3){
                $trick->addPicture($this->getReference('picture9'));
                $trick->addVideo($this->getReference('video9'));
            }
            $manager->persist($trick);
            $this->addReference('trick'.$x, $trick);
            $x++;
            if ($userNbr >= 2){
                $userNbr = 0;
            } else {
                $userNbr++;
            }
        }
        /** Flushing DATA
         * =====================================*/
        $manager->flush();
    }
    public function getOrder()
    {
        return 5;
    }
}
