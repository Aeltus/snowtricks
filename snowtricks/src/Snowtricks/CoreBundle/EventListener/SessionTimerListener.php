<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 09/04/2017
 * Time: 17:04
 */
namespace Snowtricks\CoreBundle\EventListener;

use Snowtricks\CoreBundle\SessionManager\SessionTimer;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;


class SessionTimerListener{

    private $sessionTimer;

    public function __construct(SessionTimer $sessionTimer)
    {
        $this->sessionTimer = $sessionTimer;
    }

    public function processTimer(FilterControllerEvent $event){
        $this->sessionTimer->setEvent($event);
        $this->sessionTimer->process();
    }

}
