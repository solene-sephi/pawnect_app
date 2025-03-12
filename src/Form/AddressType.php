<?php

namespace App\Form;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $disabledFields = $options['disabled_fields'];

        $builder
            ->add('street', TextType::class, [
                'label' => 'Street',
                'disabled' => in_array('street', $disabledFields),
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'disabled' => in_array('city', $disabledFields),
            ])
            ->add('state', TextType::class, [
                'label' => 'State',
                'disabled' => in_array('state', $disabledFields),
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'disabled' => in_array('country', $disabledFields),
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Zip Code',
                'disabled' => in_array('zipCode', $disabledFields),
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'disabled_fields' => [],
        ]);
    }
}