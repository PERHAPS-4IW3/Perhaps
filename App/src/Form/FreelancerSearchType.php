<?php

namespace App\Form;

use App\Entity\UserSearch;
use App\Entity\Competence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FreelancerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userProfession', TextType::class, [
                'required' => false,
                'label' => 'Profession',
                'attr' => [
                    'placeholder' => 'Ex: Freelance Prestashop'
                ]
            ])
            ->add('listCompetence', EntityType::class, [
                'required' => false,
                'label' => 'Compétences',
                'attr' => [
                    'class' => 'js-multiple-select',
                    'data-style' => 'btn-primary'
                ],
                'class' => Competence::class,
                'choice_label' => 'nomCompetence',
                'multiple' => true
            ])
            ->add('userNameAndCompany', TextType::class, [
                'required' => false,
                'label' => 'Recherche un freelancer',
                'attr' => [
                    'placeholder' => 'Rechercher un nom ou une société'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' =>UserSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}