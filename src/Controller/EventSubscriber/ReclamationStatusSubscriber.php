<?php
namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ReclamationStatusSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof \App\Entity\Reclamation) {
            // Vérifiez si la réponse a été ajoutée à la réclamation
            if ($entity->getReponseReclamations() !== null) {
                $entity->setStatus('repondue');
            } else {
                $entity->setStatus('non_traite');
            }

            $entityManager = $args->getObjectManager();
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
