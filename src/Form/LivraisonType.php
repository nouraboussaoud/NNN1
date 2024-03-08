<?php

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomC')
            ->add('prenomC')
            ->add('email')
            ->add('PhoneN')
            ->add('State',ChoiceType::class ,[
                'choices'=>[
                    'Tunisia' => 'Tunisia' ,
                    'France' =>'France' ,
                    'China' =>'China' ,
                    'Germany' =>'Germany' ,
                ],
            ])
            ->add('adresse')
            ->add('TypePaiement',ChoiceType::class ,[
                'choices'=>[
                    'Cash on delivery' =>'Cash on delivery' ,
                ],
            ])
            ->add('IdCommande')
           ->add('IdClient')
         ->add('IdLivreur')

        ;
        $builder
        ->add('NomC', null, [
            'required' => false, // Le champ "nom" ne sera plus obligatoire
        ])
       
        ->add('prenomC', null, [
            'required' => false, // Le champ "nom" ne sera plus obligatoire
        ])
        // Ajoutez d'autres champs ici
        ->add('adresse', null, [
            'required' => false, // Le champ "nom" ne sera plus obligatoire
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
    
}
