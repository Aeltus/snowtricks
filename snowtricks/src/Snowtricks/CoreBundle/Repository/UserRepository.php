<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 03/04/2017
 * Time: 21:53
 */
namespace Snowtricks\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function delOneUser($username){
        $qb = $this->createQueryBuilder('u');

        $qb ->delete()
            ->where('u.username = :username')
            ->setParameter('username', $username)
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }
}
