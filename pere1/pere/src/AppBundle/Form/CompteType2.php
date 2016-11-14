<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('username',TextType::class)
            ->add('password',PasswordType::class)
           // ->add('photo',TextType::class)
           ->add('role',null)
            ->add('active',CheckboxType::class)
            ->add('save', SubmitType::class)
        ->add('salt', TextType::class)
     ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
$resolver->setDefaults(array(
        'data_class'=>'AppBundle\Entity\Compte'
    )
);
    }

    public function getName()
    {
        return 'app_bundle_compte_type';
    }
}
