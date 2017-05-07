<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 03/04/2017
 * Time: 21:53
 */
namespace Snowtricks\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Snowtricks\CoreBundle\Form\Model\UserSearch;

class UserRepository extends EntityRepository
{

    public function findAdmins(){
        $qb = $this->createQueryBuilder('u');

        $qb ->select('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"ROLE_ADMIN"%')
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }

    public function findModerators(){
        $qb = $this->createQueryBuilder('u');

        $qb ->select('u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"ROLE_MODERATOR"%')
            ->andWhere('u.roles NOT LIKE :unlinkedRole')
            ->setParameter('unlinkedRole', '%"ROLE_ADMIN"%')
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }

    public function findMembers(UserSearch $search){
        $qb = $this->createQueryBuilder('u');

        $qb ->select('u')
            ->setFirstResult($search->getFirstResult())
            ->setMaxResults(10)
            ->orderBy('u.name', 'DESC')
            ->addOrderBy('u.surname', 'DESC')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"ROLE_USER"%')
            ->andWhere('u.roles NOT LIKE :unlinkedRole')
            ->setParameter('unlinkedRole', '%"ROLE_ADMIN"%')
            ->andWhere('u.roles NOT LIKE :unlinkedRole2')
            ->setParameter('unlinkedRole2', '%"ROLE_MODERATOR"%')
            ;

        if ($search->getSearchName() !== NULL || $search->getSearchName() != ''){
            $qb ->andwhere('u.name like :searchName')
                ->setParameter('searchName', '%'.$search->getSearchName().'%')
            ;
        }
        if ($search->getSearchSurname() !== NULL || $search->getSearchSurname() != ''){
            $qb ->andWhere('u.surname like :searchSurname')
                ->setParameter('searchSurname', '%'.$search->getSearchSurname().'%')
            ;
        }


        return new Paginator($qb, true);
    }
}
