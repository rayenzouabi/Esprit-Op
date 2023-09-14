<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => true,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Partager votre expérience avec SWIFT RIDE' // Add the placeholder text

                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le commentaire ne doit pas être vide',
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le commentaire ne peut pas dépasser {{ limit }} caractères',
                    ]),        
                    new Assert\Callback([$this, 'validateComment']),
                ],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
    public function validateComment($value, $context)
    {
        $forbiddenWords = ['stupid', 'dumb', 'fat', 'ugly'];
    
        foreach ($forbiddenWords as $word) {
            if (stripos($value, $word) !== false) {
                $context->buildViolation('Le commentaire contient des mots interdits')
                    ->addViolation();
                return;
            }
        }
    }
    

    
}