<?php

namespace App\Form;

use App\Entity\ProjetSearch;
use App\Entity\TypeProjet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProjetSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProjetSearch', TextType::class, [
                'required' => false,
                'label' => 'Nom du projet'
            ])
            ->add('minBudgetSearch', IntegerType::class, [
                'required' => false,
                'label' => 'Budget minimum'
            ])
            ->add('typeProjet', EntityType::class, [
                'required' => false,
                'label' => 'Type de projet',
                'attr'         => [
                    'class'    => 'js-multiple-select',
                    'data-style' => 'btn-primary'
                ],
                'class' => TypeProjet::class,
                'choice_label' => 'nomType',
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' =>ProjetSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}