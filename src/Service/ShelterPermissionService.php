<?php

namespace App\Service;

use App\Entity\Shelter;
use App\Form\AddressType;
use App\Form\Shelter\ShelterType;
use App\Security\Voter\ShelterVoter;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ShelterPermissionService
{

    public function __construct(private Security $security)
    {

    }

    public function applyEditableFieldsPermission(FormInterface $form, Shelter $shelter): void
    {
        $formType = $form->getConfig()->getType()->getInnerType();
        $stringTypeClass = $formType::class;

        $editableFields = match ($stringTypeClass) {
            ShelterType::class => $this->getEditableFieldsForShelter($shelter),
            AddressType::class => $this->getEditableFieldsForAddress($shelter),
            default => throw new \LogicException('This code should not be reached!')
        };

        if (!$editableFields) {
            return;
        }

        $formFields = $form->all();

        foreach ($formFields as $key => $field) {
            $fieldName = $field->getName();
            $fieldOptions = $field->getConfig()->getOptions();
            $fieldTypeString = $field->getConfig()->getType()->getInnerType()::class; // Extract the class name of the field's underlying type

            // Check if the field is listed in the editable fields array and proceed only if it should be modified
            if (!array_key_exists($fieldName, $editableFields)) {
                continue;
            }

            // Symfony does not allow you to directly modify a field after it has been added to the form, so :
            // Merge the existing field options with the new options from the editable fields array
            // This ensures that only the relevant options (e.g., 'disabled', 'label') are updated while retaining the original configuration
            $updatedOptions = array_replace($fieldOptions, $editableFields[$fieldName]);

            // Remove the current field from the form 
            $form->remove($fieldName);

            // Re-add the field to the form with the updated options and type
            $form->add($fieldName, $fieldTypeString, $updatedOptions);

        }
    }

    public function getEditableFieldsForShelter(Shelter $shelter): array
    {
        $editableFields = [];

        if ($this->security->isGranted(ShelterVoter::EDIT_PARTIALLY, $shelter)) {
            $editableFields['name'] = [
                'disabled' => true,
                'label' => 'Shelter Name (Read Only)',  // Par exemple, modifier le label
            ];
        }

        return $editableFields;
    }

    public function getEditableFieldsForAddress(Shelter $shelter): array
    {
        $editableFields = [];

        if ($this->security->isGranted(ShelterVoter::EDIT_PARTIALLY, $shelter)) {
            $editableFields['street'] = [
                'disabled' => true,
                'label' => 'Street Address (Read Only)',
            ];
            $editableFields['zipCode'] = [
                'disabled' => true,
                'label' => 'Postal Code (Read Only)',
            ];
            $editableFields['city'] = [
                'disabled' => true,
                'label' => 'City (Read Only)',
            ];
        }

        return $editableFields;
    }
}