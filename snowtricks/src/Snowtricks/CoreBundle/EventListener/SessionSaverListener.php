<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 13/04/2017
 * Time: 22:09
 */

namespace Snowtricks\CoreBundle\EventListener;

use Snowtricks\CoreBundle\SessionManager\SessionSaver;

class SessionSaverListener{

    private $sessionSaver;

    public function __construct(SessionSaver $sessionSaver)
    {
        $this->sessionSaver = $sessionSaver;
    }

    public function processSaver(){
        $this->sessionSaver->redisSetUser()->checkUsersDelays();
    }

}
