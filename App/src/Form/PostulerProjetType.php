<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 25/02/2019
 * Time: 16:09
 */

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulerProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionDevis', TextareaType::class, ['label' => "Décrivez votre offre",
                'attr' => array('placeholder' => 'Présentez-vous et dîtes ce que vous savez faire de mieux ...')])
            ->add('offreDevis', MoneyType::class, ['label' => 'Quel offre souhaitez-vous faire ?']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => Devis::class,
        ]);
    }

}