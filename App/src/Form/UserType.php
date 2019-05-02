<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 23:17
 */

namespace App\Form;

use App\Entity\User;
use App\Entity\Competence;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email'])

            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
            ))
            ->add('roles', CollectionType::class, [
                'label'        => 'Je suis un : ',
                'required'     => false,
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => false,
                    'choices'             => [
                        'Freelancer'        => 'ROLE_FREELANCER',
                        'Porteur de Projet' => 'ROLE_USER',
                    ]
                ]
            ])
            ->add('nomUser', TextType::class, ['label' => 'Nom'])
            ->add('prenomUser', TextType::class, ['label' => 'Prénom'])
            ->add('telephoneUser', TextType::class, ['label' => 'Téléphone'])
            ->add('adresseUser', TextType::class, ['label' => 'Adresse'])
            ->add('codePostalUser', TextType::class, ['label' => 'Code Postal'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('pays', TextType::class, ['label' => 'Pays'])
            ->add('nomSociete', TextType::class, ['label' => 'Nom de la société'])
            ->add('tarifHoraireFreelancer', MoneyType::class, ['label' => 'Tarif Horaire'])
            ->add('presentationFreelancer', TextareaType::class, ['label' => 'Présentation'])
            ->add('listCompetence', EntityType::class, [
                'label'        => 'Vos compétences',
                'attr'         => [
                    'class'    => 'js-multiple-select',
                    'data-style' => 'btn-primary'
                ],
                'class'        => Competence::class,
                'choice_label' => 'nomCompetence',
                'multiple'     => true,
            ])
            ->add('titreFreelancer', TextType::class, ['label' => 'Titre profesionnelle'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}