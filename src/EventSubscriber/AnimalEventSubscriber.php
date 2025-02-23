<?php

namespace App\EventSubscriber;

use App\Entity\Interface\AnimalEventInterface;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Entity\AnimalEventHistory;

class AnimalEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // Checks if the persistence entity is an AnimalEvent, we don't want to be able to create/update an entry manually
        // if (!$entity instanceof AnimalEventInterface) {
        //     return;
        // }

        // Ajout d'une entrée dans l'historique
        $this->addEventHistoryEntry($args, $entity);

        // Mise à jour du statut de l'animal
        $this->updateAnimalStatus($entity, $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof AnimalEvent) {
            return;
        }

        // Suppression de l'entrée dans l'historique
        $this->removeEventHistoryEntry($args, $entity);
    }

    private function addEventHistoryEntry(LifecycleEventArgs $args, AnimalEventInterface $entity): void
    {
        $history = new AnimalEventHistory(
            animal: $entity->getAnimal(),
            eventType: $entity->getEventType(),
            eventId: $entity->getId(),
            createdAt: $entity->getCreatedAt()
        );

        $em = $args->getObjectManager();
        $em->persist($history);
        // Pas de flush pour éviter les boucles infinies
    }

    private function removeEventHistoryEntry(LifecycleEventArgs $args, AnimalEventInterface $entity): void
    {
        $em = $args->getObjectManager();
        $historyRepo = $em->getRepository(AnimalEventHistory::class);

        $historyEntry = $historyRepo->findOneBy([
            'animal' => $entity->getAnimal(),
            'eventType' => $entity->getEventType(),
            'eventId' => $entity->getId(),
        ]);

        if ($historyEntry) {
            $em->remove($historyEntry);
            $em->flush();
        }
    }

    private function updateAnimalStatus(AnimalEventInterface $entity, LifecycleEventArgs $args): void
    {
        $animal = $entity->getAnimal();
        if ($animal) {
            $animal->setStatus($entity->getStatus());

        }

        $args->getObjectManager()->persist($animal);
        // Pas de flush ici non plus pour éviter les effets de bord
    }
}
