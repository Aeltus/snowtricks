<?php

namespace Snowtricks\UserBundle\Tests\Controller;

use Snowtricks\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    public function testRegister()
    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Création de compte")')->count()
        );
    }

    public function testLogin()
    {

        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Identifiez vous")')->count()
        );
    }

    public function testUpdateAccount()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/account');

        $user = new User();
        $user->setName('David');
        $user->setSurname('Danjard');
        $user->setMail('david.danjard@gmail.com');
        $user->setChecked(true);
        $user->setPassword('123456');
        $user->setRoles(['ROLE_USER']);

        $firewall = "main";
        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_USER', 'ROLE_ADMIN'));

        $security = $client->getContainer()->get('security.token_storage');
        $security->setToken($token);
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Modification de compte")')->count()
        );
    }

}
