<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SupprimerCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', ChoiceType::class, [
                'choices' => $options['categories'],
                'choice_label' => function ($categorie) {
                    return $categorie->getLibelle();
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('supprimer', SubmitType::class, ['label' => 'Supprimer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'categories' => [], // Passer les catégories comme option
        ]);
    }
}
