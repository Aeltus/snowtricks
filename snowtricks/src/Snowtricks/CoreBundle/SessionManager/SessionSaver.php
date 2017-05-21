<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 13/04/2017
 * Time: 20:26
 */

namespace Snowtricks\CoreBundle\SessionManager;

use Snowtricks\CoreBundle\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class SessionSaver
{
    private $redis;
    private $user = NULL;
    private $request;
    private $delay;

    public function __construct(RequestStack $request_stack, $redis,TokenStorage $securityToken, $delay)
    {
        $this->request = $request_stack->getCurrentRequest();
        $this->redis = $redis;
        $this->delay = $delay;
        if ($this->user = $securityToken->getToken() !== NULL){
            $this->user = $securityToken->getToken()->getUser();
        }
    }

    public function checkUsersDelays(){

        $list_Users = $this->redis->lrange('connected_users', '0', '-1');
        $this->redis->del('connected_users');

        foreach ($list_Users as $connectedUser){
            if ((time() - $this->redis->hget('user:'.$connectedUser, 'last_action')) > $this->delay){
                $this->redis->del('user:'.$connectedUser);
            } else {
                $this->redis->lpush('connected_users', $connectedUser);
            }
        }

        $this->redis->del('actives_users');
        $this->redis->set('actives_users', count($this->redis->lrange('connected_users', '0', '-1')));

        return $this;
    }

    public function redisSetUser(){

        /**
         * add current user in list of connected users
         */
        $list_Users = $this->redis->lrange('connected_users', '0', '-1');

        if(!$this->user instanceof User){
            $this->user = new User();
            $this->user->setName('Annonyme');
        }

        if (!in_array(urlencode($this->request->getClientIp()), $list_Users)){
            $this->redis->lpush('connected_users', urlencode($this->request->getClientIp()));
        }

        /**
         * update the current page and user infos for the user in redis table
         */
        $this->redis->del('user:'.urlencode($this->request->getClientIp()));
        $this->redis->hmset('user:'.urlencode($this->request->getClientIp()),'page' ,$this->request->getRequestUri(),
                                                                             'name', $this->user->getName(),
                                                                             'surname', $this->user->getSurname(),
                                                                             'mail', $this->user->getMail(),
                                                                             'last_action', time(),
                                                                             'ip', $this->request->getClientIp()
                                                                             );
        return $this;
    }

    public function redisGetUsers(){
        $users = [];
        $list_Users = $this->redis->lrange('connected_users', '0', '-1');

        foreach ($list_Users as $user){
            $currentUser = array('name' => $this->redis->hget('user:'.$user, 'name'),
                'surname' => $this->redis->hget('user:'.$user, 'surname'),
                'mail' => $this->redis->hget('user:'.$user, 'mail'),
                'page' => $this->redis->hget('user:'.$user, 'page'),
                'last_action' => $this->redis->hget('user:'.$user, 'last_action'),
                'ip' => $this->redis->hget('user:'.$user, 'ip')
            );
            $users[] = $currentUser;
        }
        return $users;
    }


    public function redisGetNumberOfActivesUsers(){
        return $this->redis->get('actives_users');
    }

}
