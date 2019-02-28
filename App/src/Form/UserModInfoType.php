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
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserModInfoType extends AbstractType
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
            ->add('nomUser', TextType::class, ['label' => 'Votre nom'])
            ->add('prenomUser', TextType::class, ['label' => 'Votre prénom'])
            ->add('telephoneUser',  TextType::class, ['label' => 'Votre téléphone'])
            ->add('adresseUser', TextType::class, ['label' => 'Votre adresse'])
            ->add('codePostalUser', TextType::class,  ['label' => 'Votre code postal'])
            ->add('ville', TextType::class,  ['label' => 'Votre ville'])
            ->add('pays', TextType::class,  ['label' => 'Votre pays'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
