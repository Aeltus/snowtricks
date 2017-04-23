<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 09:51
 */
namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\Picture;

class LoadPictureData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $picturesData = array(
            "https://www.wedze.fr/sites/wedze/files/cover_conseil_choisir_snowboard_2016.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-1654692.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-materiel-snowboard.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-materiel-boots.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-materiel-fixations.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-protections-casques.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-protections-masques.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-protections-protections-corporelles.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-ski-accessoires-sac-a-dos.jpg",
            "https://www.wedze.fr/sites/wedze/files/category/image/wedze-920x250-snowboard-accessoires_0.jpg"
        );
        /** Persist DATA
         * =====================================*/
        $x=0;
        $pictureNbr = 0;
        foreach ($picturesData as $pictureAddress){
            $createdAt = new \DateTime('NOW');
            $user = $this->getReference('user'.$x);
            $picture = new Picture();
            $picture->setAddress($pictureAddress);
            $picture->setCreatedAt($createdAt);
            $picture->setCreatedBy($user);

            if ($pictureNbr < 4){
                $trick = $this->getReference('trick0');
            } elseif ($pictureNbr >= 4 && $pictureNbr < 8){
                $trick = $this->getReference('trick2');
            } else {
                $trick = $this->getReference('trick3');
            }
            $picture->setIdTrick($trick);
            $manager->persist($picture);
            $this->addReference('picture'.$pictureNbr, $picture);
            if ($x >= 2){
                $x = 0;
            } else {
                $x++;
            }
            $pictureNbr++;
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
