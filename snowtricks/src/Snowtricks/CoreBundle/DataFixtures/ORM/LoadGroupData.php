<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 09:28
 */
namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $groups = array(
            "Grabs",
            "Rotations",
            "Flips"
        );
        /** Persist DATA
         * =====================================*/
        foreach ($groups as $groupData){
            $group = new Group(NULL, $groupData);
            $manager->persist($group);
            $this->addReference($groupData, $group);
        }
        /** Flushing DATA
         * =====================================*/
        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}
