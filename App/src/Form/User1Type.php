<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',VichImageType::class, [
                'required'=> false,
                'label' => "Photo de profil",
                'delete_label' => "Supprimer ma photo",
                'download_label' => "Télécharger ma photo",
                #'allow_delete' => false,
                ])
            ->add('nomUser')
            /*->add('listCompetence', EntityType::class, [
                'label'        => 'Competence',
                'class'        => Competence::class,
                'choice_label' => 'nomCompetence',
                'multiple'     => true,
                'required'     => false,
            ])*/
            ->add('prenomUser')
            ->add('telephoneUser')
            ->add('adresseUser')
            ->add('codePostalUser')
            ->add('ville')
            ->add('pays')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
