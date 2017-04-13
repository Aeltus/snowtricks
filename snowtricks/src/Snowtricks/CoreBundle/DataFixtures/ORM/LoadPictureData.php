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
            "https://cdn.pixabay.com/photo/2016/01/27/00/52/up-chrobry-1163459_960_720.jpg",
            "https://cdn.pixabay.com/photo/2013/05/26/20/09/snowboard-113847_960_720.jpg",
            "https://cdn.pixabay.com/photo/2017/01/17/02/16/snowboarding-1985751_960_720.jpg",
            "https://cdn.pixabay.com/photo/2012/08/27/19/39/snowboarder-55099_960_720.jpg",
            "https://cdn.pixabay.com/photo/2016/06/23/15/11/snowboard-1475536_960_720.jpg",
            "https://cdn.pixabay.com/photo/2016/12/29/23/53/snowboard-1939636_960_720.jpg",
            "https://cdn.pixabay.com/photo/2016/08/24/18/58/winter-1617746_960_720.jpg",
            "https://cdn.pixabay.com/photo/2015/03/13/18/21/snowboard-672080_960_720.jpg",
            "https://cdn.pixabay.com/photo/2014/11/18/23/25/snowboarding-536809_960_720.jpg",
            "https://cdn.pixabay.com/photo/2015/01/14/17/19/snowboard-599323_960_720.jpg"
        );
        /** Persist DATA
         * =====================================*/
        $x=0;
        $pictureNbr = 0;
        foreach ($picturesData as $pictureAddress){
            $createdAt = new \DateTime('NOW');
            $user = $this->getReference('user'.$x);
            $picture = new Picture(NULL, $pictureAddress, $createdAt, $user);
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
        return 3;
    }
}
