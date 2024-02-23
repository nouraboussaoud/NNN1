<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Reclamation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('object')
            ->add('description_Rec')
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
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
