<?php
namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Resource;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ResCountSub implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [Events::postPersist, Events::preRemove];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $resource = $args->getObject();

        if (!$resource instanceof Resource)
            return;

        $em = $args->getObjectManager();
        
        $level = $resource->getLevel();
        $level->setResourceCount($level->getResourceCount() + 1);
        $em->merge($level);
        $em->flush();
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $resource = $args->getObject();

        if (!$resource instanceof Resource)
            return;

        $em = $args->getObjectManager();
        
        $level = $resource->getLevel();
        $level->setResourceCount($level->getResourceCount() - 1);
        $em->merge($level);
        $em->flush();
    }
}