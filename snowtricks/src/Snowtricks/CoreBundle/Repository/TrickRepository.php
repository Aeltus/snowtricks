<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/04/2017
 * Time: 09:21
 */
namespace Snowtricks\CoreBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Snowtricks\CoreBundle\Entity\Group;
use Snowtricks\CoreBundle\Form\Model\TrickSearch;

class TrickRepository extends \Doctrine\ORM\EntityRepository
{

    public function getTricks(TrickSearch $search){

        $qb = $this->createQueryBuilder('t');

        $qb ->select('t')
            ->addSelect('g')
            ->leftJoin('t.group', 'g')
            ->addSelect('a')
            ->leftJoin('t.createdBy', 'a')
            ->setFirstResult($search->getFirstResult())
            ->setMaxResults($search->getNumber())
        ;

        if ($search->getOrderedBy() == "group"){
            $qb -> orderBy('g.name', $search->getOrder());
        } elseif ($search->getOrderedBy() == "createdBy"){
            $qb -> orderBy('a.name', $search->getOrder());
            $qb -> addOrderBy('a.surname', $search->getOrder());
        } else {
            $qb -> orderBy('t.'.$search->getOrderedBy(), $search->getOrder());
        }

        if ($search->getSearch() !== NULL){
            $qb ->where('t.description like :search')
                ->setParameter('search', '%'.$search->getSearch().'%')
            ;
        }

        return new Paginator($qb, true);

    }

    public function findAllLinkedTricks(Group $group){
        $qb = $this->createQueryBuilder('t');

        $qb ->select('t')
            ->addSelect('g')
            ->leftJoin('t.group', 'g')
            ->where('t.group = :group')
            ->setParameter('group', $group)
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }

}
