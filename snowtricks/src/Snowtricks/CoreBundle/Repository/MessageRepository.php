<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 23/04/2017
 * Time: 22:08
 */
namespace Snowtricks\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Snowtricks\CoreBundle\Entity\Trick;
use Snowtricks\CoreBundle\Form\Entity\MessageSearch;

class MessageRepository extends EntityRepository
{
    public function findMessagesForTrick(Trick $trick, MessageSearch $search){
        $qb = $this->createQueryBuilder('m');

        $qb ->select('m')
            ->where('m.trick = :trick')
            ->setParameter('trick', $trick)
            ->orderBy('m.id', 'DESC')
            ->setFirstResult($search->getFirstResult())
            ->setMaxResults($search->getNumber())
        ;

        return new Paginator($qb, true);
    }

    public function selectAllMessagesForTrick(Trick $trick){
        $qb = $this->createQueryBuilder('m');

        $qb ->select('m')
            ->where('m.trick = :trick')
            ->setParameter('trick', $trick)
        ;

        return $qb
            ->getQuery()
            ->execute()
            ;
    }
}
