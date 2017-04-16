<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 15/04/2017
 * Time: 11:15
 */
namespace Snowtricks\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function delOneGroup($name){
        $qb = $this->createQueryBuilder('g');

        $qb ->delete()
            ->where('g.name = :name')
            ->setParameter('name', $name)
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }
}

