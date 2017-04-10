<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 09/04/2017
 * Time: 22:27
 */
namespace Snowtricks\UserBundle\Tests\BDD;



use Snowtricks\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BddTest extends WebTestCase
{
    public function testUserDataBase()
    {

        $client = static::createClient();

        $em = $client->getContainer()->get('doctrine')->getManager();
        $repo = $em->getRepository('SnowtricksCoreBundle:User');

        $user = new User();
        $user->setName('John');
        $user->setSurname('Doe');
        $user->setMail('test1@gmail.com');
        $user->setChecked(true);
        $user->setPassword('123456');
        $user->setRoles(['ROLE_USER']);

        //test persisting in data base
        $em->persist($user);
        $this->assertNull($em->flush());

        // test update data base
        $user->setName('Jane');
        $this->assertNull($em->flush());

        // test get from data base
        $user2 = $repo->findOneBy(array('username' => $user->getUsername()));
        $this->assertContains('test1@gmail.com', $user2->getUsername());

        //test delete in data base
        $this->assertEquals(1, $repo->delOneUser($user->getUsername()));

    }
}

