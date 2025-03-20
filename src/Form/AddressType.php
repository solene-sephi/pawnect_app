<?php

namespace App\Form;
use App\Entity\Address;
use App\Service\ShelterPermissionService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\EventListener\AddressFormSubscriber;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{

    public function __construct(
        private ShelterPermissionService $shelterPermissionService
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $relatedEntity = $options['related_entity'] ?? null;

        $builder
            ->add('street', TextType::class, [
                'label' => 'Street',
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'data' => 'France',
                'disabled' => true,
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Zip Code',
            ]);

        $builder->addEventSubscriber(new AddressFormSubscriber($this->shelterPermissionService));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'related_entity' => null,
        ]);
    }
}