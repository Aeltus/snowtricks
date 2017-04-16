<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 16/04/2017
 * Time: 11:24
 */
namespace test\SnowtricksCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
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

    public function testIndex()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/groups');

        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );

        $form = $crawler->selectButton('submit')->form();
        $form['add_group_form[name]'] = 'TestWebCase';
        $crawler->$this->client->submit($form);

        $this->assertContains('créé', $this->client->getResponse()->getContent());

    }
}
