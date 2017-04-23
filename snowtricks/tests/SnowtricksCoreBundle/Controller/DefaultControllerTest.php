<?php

namespace test\SnowtricksCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp(){
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertContains('Bienvenue', $this->client->getResponse()->getContent());
    }

    public function testAdd(){

        $this->logIn();

        $crawler = $this->client->request('GET', '/trick/add');

        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );

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

}
