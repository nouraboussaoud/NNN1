<?php

namespace App\Form;

use App\Entity\SuiviLivraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateComm')
            ->add('localisatione')
            ->add('IdLivraison')
             ->add('IDComm')
             ->add('IDUser')
        ;

        $builder
        ->add('localisatione', null, [
            'required' => false, // Le champ "loc" ne sera plus obligatoire
        ])
       
      
      
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SuiviLivraison::class,
        ]);
    }
}
