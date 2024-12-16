<?php

namespace App\Form;

use App\Entity\Realisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', null, [
                'label' => 'Nom du Réalisateur : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
            ->add('Prenom', null, [
                'label' => 'Prenom du Réalisateur : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
            ->add('Origine', null, [
                'label' => 'Origine du Réalisateur : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Realisateur::class,
        ]);
    }
}
