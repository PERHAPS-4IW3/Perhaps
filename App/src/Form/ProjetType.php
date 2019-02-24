<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProjet')
            ->add('descriptionProjet')
            ->add('budget')
            ->add('choixContact', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('listCompetence', EntityType::class, [
                'label'        => 'Competence',
                'class'        => Competence::class,
                'choice_label' => 'nomCompetence',
                'multiple'     => true,
                'required'     => false,
            ])
            ->add('dateDebut')
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
