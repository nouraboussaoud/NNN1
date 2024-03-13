<?php

namespace App\Form;
use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\File;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user', EntityType::class, [
            'class' => User::class, // Utilisez le nom complet de la classe Author
            'choice_label' => 'id',
            'disabled' => true, 
            'data' => $options['preselected_user'],// Utilisez la propriété 'username' de l'entité Author
           
        
        ])
            ->add('object', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 200]),
                ],
            ]) 
            ->add('description_Rec', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 200]),
                ],
            ]) 
            ->add('categorie'  ,ChoiceType::class ,[
                'choices'=>[
                    'Produit' => 'Produit' ,
                    'Livraison' =>'Livraison' ,
                    'Evenement' =>'Evenement' ,
                    'Quiz' =>'Quiz' ,
                    'Autres' =>'Autres' ,
                ],
            ])
            //->add('etat')
            
            ->add('imageFile', FileType::class,[
                'label'=> 'Image(JPEG or PNG file)',
                'required'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'preselected_user' => null,
        ]);
    }
    
}
