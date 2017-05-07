<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 04/05/2017
 * Time: 19:28
 */
namespace Snowtricks\CoreBundle\Controller;

use Snowtricks\CoreBundle\Form\Model\UserSearch;
use Snowtricks\CoreBundle\Form\Type\UserSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{

    public function indexAction(Request $request){

        $search = new UserSearch();
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('SnowtricksCoreBundle:User');

        $redis = $this->get('snc_redis.default');
        $listUsers = $redis->lrange('connected_users', '0', '-1');
        $activesUsers = [];
        foreach ($listUsers as $user){

            $redisUser =  $redis->hmget('user:'.$user,
                'page',
                'mail',
                'last_action',
                'ip'
            );
            $user = $userRepository->findOneBy(['mail' => $redisUser[1]]);
            $user->setLastAction($redisUser[2])->setIp($redisUser[3])->setCurrentPage($redisUser[0]);
            $activesUsers[] = $user;
        }

        $admins = $userRepository->findAdmins();
        $moderators = $userRepository->findModerators();

        $form = $this->createForm(UserSearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $search = $form->getData();
        }
        $members = $userRepository->findMembers($search);

        return $this->render('SnowtricksCoreBundle:Admin:index.html.twig', array(
            'activesUsers' => $activesUsers,
            'admins' => $admins,
            'moderators' => $moderators,
            'members' => $members,
            'form' => $form->createView(),
            'search' => $search,
        ));

    }

}
