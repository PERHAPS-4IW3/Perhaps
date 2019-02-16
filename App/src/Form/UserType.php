<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 03/02/2019
 * Time: 23:17
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ->add('role', ChoiceType::class, [
                'label'                     => 'Je suis un : ',
                'multiple'                  => false,
                'expanded'                  => false,
                'choices'                   => [
                    'Freelancer'    => 'ROLE_FREELANCER',
                    'Porteur de Projet' => 'ROLE_USER'
                ]
            ])
            ->add('nomUser', TextType::class, ['label' => 'Nom'])
            ->add('prenomUser', TextType::class, ['label' => 'Prénom'])
            ->add('telephoneUser', TextType::class, ['label' => 'Téléphone'])
            ->add('adresseUser', TextType::class, ['label' => 'Adresse'])
            ->add('codePostalUser', TextType::class, ['label' => 'Code Postal'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('pays', TextType::class, ['label' => 'Pays'])
            //->add('statut', TextType::class, ['label' => 'Statut'])
            /*->add('typeUser', ChoiceType::class, [
                'choices' => $this->getUserType()
            ])*/
        ;

        $builder->get('role')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event)
            {
                $form = $event->getForm();
                $data = $event->getData();

                dump($data);

                if($data === "ROLE_FREELANCER") {
                    $form->getParent()->add('statut', TextType::class, ['label' => 'Statut']);
                }
            }

        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    /*private function getUserType()
    {
        $type = User::USERTYPE;
        $output = [];
        foreach ($type as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }*/

}