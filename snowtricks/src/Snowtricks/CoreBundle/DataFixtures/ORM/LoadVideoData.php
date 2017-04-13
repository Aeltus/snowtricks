<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 11:42
 */

namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\Video;

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $videosData = array(
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/n0F6hSpxaFc" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/bolupch5VEg" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/G9qlTInKbNE" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/VMVzrBlULkE" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/xGG56MWgbOA" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/xGG56MWgbOA" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/m2jMAbjfSII" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/-FTl5BAvwWo" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/y4Yp3-llWDs" frameborder="0" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/crDzvmi91XQ" frameborder="0" allowfullscreen></iframe>'
        );
        /** Persist DATA
         * =====================================*/
        $x=0;
        $videoNbr = 0;
        foreach ($videosData as $videoEmbed){
            $createdAt = new \DateTime('NOW');
            $user = $this->getReference('user'.$x);
            $video = new Video(NULL, $videoEmbed, $createdAt, $user);
            $manager->persist($video);
            $this->addReference('video'.$videoNbr, $video);
            if ($x >= 2){
                $x = 0;
            } else {
                $x++;
            }
            $videoNbr++;
        }
        /** Flushing DATA
         * =====================================*/
        $manager->flush();
    }
    public function getOrder()
    {
        return 4;
    }
}
