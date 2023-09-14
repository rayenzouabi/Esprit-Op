<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowpasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('showPassword', CheckboxType::class, [
            'label' => false,
            'required' => false,
            'mapped' => false, // this field doesn't map to an entity property
            'label_attr' => [
                'class' => 'checkbox-inline', // add a class to the label element
                'for' => 'agree_terms', // add a "for" attribute to the label element
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
