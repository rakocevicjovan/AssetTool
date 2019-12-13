<?php
namespace AppBundle\EventSubscriber;

use AppBundle\Entity\Level;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class LevCountSub implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [Events::postPersist, Events::preRemove];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $level = $args->getObject();

        // only act on some "Product" entity
        if (!$level instanceof Level)
            return;

        $em = $args->getObjectManager();
        
        $gp = $level->getProject();
        $gp->setLevelCount($gp->getLevelCount() + 1);
        $em->merge($gp);
        $em->flush();
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $level = $args->getObject();

        // only act on some "Product" entity
        if (!$level instanceof Level)
            return;

        $em = $args->getObjectManager();
        
        $gp = $level->getProject();
        $gp->setLevelCount($gp->getLevelCount() - 1);
        $em->merge($gp);
        $em->flush();
    }
}