<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/05/2017
 * Time: 21:54
 */
namespace Snowtricks\CoreBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Snowtricks\CoreBundle\Entity\Trick;

class TrickListener
{
    private $manager;
    private $entity;


    /**
     * @param LifecycleEventArgs $args
     *
     * Delete all Linked Messages for a trick that we will delete
     */
    public function preRemove(LifecycleEventArgs $args){

        $this->manager = $args->getEntityManager();
        $this->entity = $args->getEntity();

        if (!$this->entity instanceof Trick){
            return;
        }

        $repository = $this->manager->getRepository('SnowtricksCoreBundle:Message');
        $messages = $repository->selectAllMessagesForTrick($this->entity);

        if (!empty($messages)){
            foreach ($messages as $message){
                $this->manager->remove($message);
            }
        }
        $this->manager->flush();
        return;
    }
}
