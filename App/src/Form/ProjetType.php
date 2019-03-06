<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\TypeProjet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProjet', TextType::class, ['label' => 'Nom du projet'])
            ->add('descriptionProjet', TextareaType::class, ['label' => 'Description du projet'])
            ->add('typeProjet', EntityType::class, [
                'label'        => 'Type de Projet',
                'attr'         => [
                    'class'    => 'selectpicker',
                    'data-style' => 'btn-primary'
                ],
                'class'        => TypeProjet::class,
                'choice_label' => 'nomType',
                'multiple'     => true,
                'required'     => false,
            ])
            ->add('budget', MoneyType::class, ['label' => 'Budget'])
            ->add('choixContact', ChoiceType::class, [
                'label' => 'Choix de contact',
                'choices' => $this->getChoices()
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Projet::CONTACT;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
