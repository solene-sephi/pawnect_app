<?php

namespace App\Form\Shelter;

use App\Entity\Shelter;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ShelterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'disabled' => true,
                    'label' => 'Shelter name',
                ]
            )
            ->add(
                'phoneNumber1',
                TelType::class,
                [
                    'label' => 'Phone Number 1'
                ]
            )
            ->add(
                'phoneNumber2',
                TelType::class,
                [
                    'label' => 'Phone Number 2'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email'
                ]
            )
            ->add(
                'openingHours',
                TextType::class,
                [
                    'label' => 'Opening Hours'
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Shelter Description'
                ]
            )
            ->add(
                'address',
                AddressType::class,
                [
                    'disabled_fields' => $options['disabled_fields']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shelter::class,
            'disabled_fields' => [],
        ]);
    }
}
