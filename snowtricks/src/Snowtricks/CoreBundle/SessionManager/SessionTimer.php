<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 09/04/2017
 * Time: 16:08
 */
namespace Snowtricks\CoreBundle\SessionManager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class SessionTimer
 * @package Snowtricks\CoreBundle\SessionManager
 *
 * Test is session wasn't refech since to much time.
 * If yes disconnect session.
 */
class SessionTimer
{
    private $delay;

    private $request;
    private $session;
    private $securityToken;
    private $resolver;
    private $event;

    public function __construct(RequestStack $request_stack, $securityToken, $delay, ControllerResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        $this->delay = $delay;
        $this->request = $request_stack->getCurrentRequest();
        $this->session = $this->connectSession($this->request);
        $this->securityToken = $securityToken;
    }

    public function setEvent(FilterControllerEvent $event){
        $this->event = $event;
    }

    public function process()
    {
        if ($this->session !== NULL){
            $this->getTime();
        }
        return;
    }

    private function connectSession(Request $request){

        if (!$request->getSession()->isStarted()){
            $session = NULL;
        } else {
            $session = $request->getSession();
        }

        return $session;
    }

    private function getTime(){
        $now = time();
        if($this->session->get('timer') !== NULL){

            if(($now-$this->session->get('timer'))>$this->delay){

                if($this->securityToken->getToken()->getRoles() !== []){

                    $this->securityToken->setToken(null);
                    $this->request->getSession()->invalidate();

                    $this->session->getFlashBag()->add('danger', 'Vous êtes resté inactif durant trop longtemps, vous avez été déconnecté.');

                    $fakeRequest = $this->event->getRequest()->duplicate(null, null, array('_controller' => 'SnowtricksUserBundle:Security:login'));
                    $controller = $this->resolver->getController($fakeRequest);
                    $this->event->setController($controller);

                }
            }
        }

        $this->session->set('timer', $now);

        return;
    }

}
