<?php

namespace App\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Service\ShelterPermissionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ShelterFormSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ShelterPermissionService $shelterPermissionService
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        $shelter = $event->getData();
        $form = $event->getForm();

        $this->shelterPermissionService->applyEditableFieldsPermission($form, $shelter);

    }
}