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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('typeUser', ChoiceType::class, [
                'choices' => $this->getUserType()
            ])
        ;

        if (in_array('registration', $options['validation_groups'])) {
            $builder
                ->add('nomUser')
                ->add('prenomUser')
                ->add('telephoneUser')
                ->add('adresseUser')
                ->add('codePostalUser')
                ->add('ville')
                ->add('pays')
                /*->add('typeUser', ChoiceType::class, [
                    'typeUser' => $this->getUserType()
                ])*/
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    private function getUserType()
    {
        $type = User::USERTYPE;
        $output = [];
        foreach ($type as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

}