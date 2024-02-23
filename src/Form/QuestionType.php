<?php

namespace App\Form;
use App\Entity\Genre;
use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options,): void
    {
       
        $builder
        ->add('quiz', EntityType::class, [
            'class' => Quiz::class, // Utilisez le nom complet de la classe Author
            'choice_label' => 'id',
            'disabled' => true, 
            'data' => $options['preselected_quiz'],// Utilisez la propriété 'username' de l'entité Author
           
        
        ])
            ->add('text')
            ->add('choix1')
            ->add('choix2')
            ->add('choix3')
            ->add('choix4')
            ->add('points')
           
           ;;;
           
    }



    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            
        ]);


        $resolver->setDefaults([
            'preselected_quiz' => null, // Default value for the preselected quiz option
        ]);
    }
}
