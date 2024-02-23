<?php

namespace App\Form;

use App\Entity\Certification;
use App\Entity\Quiz;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quiz', EntityType::class, [
            'class' => Quiz::class, // Utilisez le nom complet de la classe Author
            'choice_label' => 'quizName',
            
           // Utilisez la propriété 'username' de l'entité Author
           
        
        ])
        ->add('user', EntityType::class, [
            'class' => User::class, // Utilisez le nom complet de la classe Author
            'choice_label' => function ($user) {
                return sprintf('%s - %s', $user->getId(),$user->getUsername() );
            },
            
           // Utilisez la propriété 'username' de l'entité Author
           
        
        ])

       ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
