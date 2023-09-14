<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Validator\Constraints\RegexValidator;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('CV_c', FileType::class, [
            'label_attr' => [
                'style' => 'padding: 15px; margin: 0 50px;',
            ],
            'row_attr' => [
                'class' => 'form-group row'
            ],
            'label' => 'Image (JPG, JPEG, PNG file)',
            'mapped' => true, // map the uploaded file to the 'image' property in the entity
            'required' => false,
            'data_class' => null, // Set data_class to null for this field
            'attr' => [
              
                    'class' => 'contact-form bg-light mb-4',
                    'style' => 'padding: 15px; margin: 0 50px;',
                
                'accept' => 'image/jpeg, image/png',
            ],  'constraints' => [
                new File([
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid JPG, JPEG, or PNG image',
                ])
            ]
        ])
        ->add('motivation_letter', TextType::class , [
            'label_attr' => [
                'style' => 'padding: 15px; margin: 0 50px;',
            ],
            'row_attr' => [
                'class' => 'form-group row'
            ],
            'attr' => [
                
                'class' => 'contact-form bg-light mb-4',
                'style' => 'padding: 15px; margin: 0 50px;',
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
