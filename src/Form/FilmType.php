<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Realisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('realisateur', EntityType::class, [
                'class' => Realisateur::class,
                'label' => 'Realisateur :    ',
                'choice_label' => function (Realisateur $realisateur) {
                    return $realisateur->getNom() . ' ' . $realisateur->getPrenom();
                }, 
                'placeholder' => 'Choisir un réalisateur',
                'required' => true,
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
            ->add('Nom', null, [
                'label' => 'Nom du Film : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
            ->add('annee_sortie', null, [
                'label' => 'Anne du sortie : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 0.8em;' ]
            ])
            ->add('Genre', null, [
                'label' => 'Genre du Film : ',
                'attr' => [ 'style' => 'font-size: 1em; margin-bottom: 1em;' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
