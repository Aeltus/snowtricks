<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 23/04/2017
 * Time: 17:42
 */
namespace test\SnowtricksCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class VideosControllerTest extends WebTestCase
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

}
