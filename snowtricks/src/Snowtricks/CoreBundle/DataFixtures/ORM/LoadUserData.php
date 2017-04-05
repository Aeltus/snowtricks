<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 09:57
 */
namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $users = array(
            ["Pierre", "Durand", ["ROLE_USER", "ROLE_MODERATOR"]],
            ["Sophie", "Belier", ["ROLE_USER", "ROLE_MODERATOR", "ROLE_ADMIN"]],
            ["Paul", "Dupont", ["ROLE_USER"]],
            ["Arthur", "Malin", ["ROLE_USER"]],
            ["Caroline", "Bataille", ["ROLE_USER"]]
        );

        /** Persist DATA
         * =====================================*/
        $x=0;
        foreach ($users as $userData){
            $testMail = strtolower($userData[0]).".".strtolower($userData[1])."@monmail.com";
            $user = new User();
            $user->setName($userData[0]);
            $user->setSurname($userData[1]);
            $user->setMail($testMail);
            $user->setPicture("https://cdn.pixabay.com/photo/2016/09/28/02/14/user-1699635_960_720.png");
            $user->setRoles($userData[2]);
            $user->setPlainPassword("TestPass");
            $manager->persist($user);
            if ($x == 0){
                $this->addReference('moderatorUser', $user);
            } elseif ($x == 1){
                $this->addReference('adminUser', $user);
            } else {
                $userNbr = $x - 2;
                $this->addReference('user'.$userNbr, $user);
            }
            $x++;
        }
        /** Flushing DATA
         * =====================================*/
        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
