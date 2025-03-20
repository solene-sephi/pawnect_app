<?php

namespace App\Form\EventListener;

use App\Entity\Shelter;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Service\ShelterPermissionService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddressFormSubscriber implements EventSubscriberInterface
{
    public function __construct(private ShelterPermissionService $shelterPermissionService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        $address = $event->getData();
        $form = $event->getForm();
        $relatedEntity = $form->getConfig()->getOption('related_entity');

        if ($relatedEntity instanceof Shelter) {
            $this->shelterPermissionService->applyEditableFieldsPermission($form, $relatedEntity);
        }
    }
}