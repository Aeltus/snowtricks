<?php

namespace Snowtricks\UserBundle\Tests\Controller;


use Snowtricks\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{

    private $client;

    public function setUp(){
        $this->client = static::createClient();
    }

    private function logIn(){
        $session = $this->client->getContainer()->get('session');

        $em = $this->client->getContainer()->get('doctrine')->getManager();
        $repo = $em->getRepository('SnowtricksCoreBundle:User');

        $user = $repo->findOneBy(array('username' => 'doe.john@monmail.com'));


        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    public function testRegister()
    {
        $crawler = $this->client->request('GET', '/register');

        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
    }

    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
    }

    public function testUpdateAccount()
    {

        $this->logIn();

        $crawler = $this->client->request('GET', '/account');

        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
    }

}
