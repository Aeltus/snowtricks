<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 16/04/2017
 * Time: 10:23
 */
namespace Snowtricks\CoreBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Snowtricks\CoreBundle\Entity\Group;

class GroupListener
{
    private $manager;
    private $entity;


    /**
     * @param LifecycleEventArgs $args
     *
     * Delete all Linked Tricks for a group that we will delete
     */
    public function preRemove(LifecycleEventArgs $args){

        $this->manager = $args->getEntityManager();
        $this->entity = $args->getEntity();

        if (!$this->entity instanceof Group){
            return;
        }

        $repository = $this->manager->getRepository('SnowtricksCoreBundle:Trick');
        $tricks = $repository->findAllLinkedTricks($this->entity);

        if (!empty($tricks)){
            foreach ($tricks as $trick){
                $this->manager->remove($trick);
            }
        }

        return;
    }
}
