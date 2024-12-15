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
                'label' => 'Realisateur : ',
                'choice_label' => function (Realisateur $realisateur) {
                    return $realisateur->getNom() . ' ' . $realisateur->getPrenom();
                }, 
                'placeholder' => 'Choisir un réalisateur',
                'required' => true
            ])
            ->add('Nom', null, [
                'label' => 'Nom du Film : '
            ])
            ->add('annee_sortie', null, [
                'label' => 'Anne du sortie : '
            ])
            ->add('Genre', null, [
                'label' => 'Genre du Film : '
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
