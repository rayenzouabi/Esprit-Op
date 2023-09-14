<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType; 
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['rows' => 3], 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5, 'max' => 240]),
                ],
            ])
            ->add('societe')
            ->add('adresse_societe')
            ->add('email', EmailType::class, [ 
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('type_offre')
            ->add('qualification', ChoiceType::class, [
                'label' => 'Qualification',
                'choices' => [
                    'Baccalaureat' => 'Baccalaureat',
                    'Licence en informatique' => 'Licence en informatique',
                    'Master en informatique' => 'Master en informatique',
                    'Cycle ingenieur termine' => 'Cycle ingenieur termine',
                    'Certifications' => 'Certifications',
                    // Add other qualification options
                ],
                'multiple' => false, // Passage de 'true' à 'false' pour en faire une liste déroulante
                'expanded' => false, // Passage de 'true' à 'false'
            ])
            ->add('comptence', ChoiceType::class, [
                'label' => 'Compétence',
                'choices' => [
                    'Web Development' => 'Web Development',
                    'Backend Development' => 'Backend Development',
                    'Frontend Development' => 'Frontend Development',
                    'Mobile App Development' => 'Mobile App Development',
                    'Database Management' => 'Database Management',
                    'Data Analysis' => 'Data Analysis',
                    'AI and Machine Learning' => 'AI and Machine Learning',
                    'Cybersecurity' => 'Cybersecurity',
                    'Cloud Computing' => 'Cloud Computing',
                    'DevOps' => 'DevOps',
                    'Network Administration' => 'Network Administration',
                    'UI/UX Design' => 'UI/UX Design',
                    'Quality Assurance' => 'Quality Assurance',
                    'Software Testing' => 'Software Testing',
                    'Agile Methodologies' => 'Agile Methodologies',
                    'Project Management' => 'Project Management',
                    'Embedded Systems' => 'Embedded Systems',
                    'Robotics' => 'Robotics',
                    
                ],
                'multiple' => false, // Passage de 'true' à 'false'
                'expanded' => false, // Passage de 'true' à 'false'
            ])
            ->add('deadline')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
