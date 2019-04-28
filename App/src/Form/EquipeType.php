<?php
/**
 * Created by PhpStorm.
 * User: 10601450
 * Date: 27/02/2019
 * Time: 23:25
 */

namespace App\Form;
use App\Entity\Equipe;
use App\Entity\User;
use App\Entity\UserCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chefDeProjet', NoteEtCommenaireType::class, [

                'label' => false,
            ])
            ->add('listParticipants', CollectionType::class, [
                'label'                     => false,
                'entry_type'   => NoteEtCommenaireType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => true,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'table discount-collection',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'ProjetController';
    }
}