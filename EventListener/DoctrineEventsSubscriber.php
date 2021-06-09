<?php

namespace MauticPlugin\EcommerceBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class DoctrineEventsSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'loadClassMetadata',
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        if ($classMetadata->name == 'Mautic\PageBundle\Entity\Hit'){
            $classMetadata->isMappedSuperclass = true;
        }
        
    }
}
