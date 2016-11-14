<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 22/02/2016
 * Time: 12:18
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email')
            ->add('active')
            ->add('dateInscription', DateType::class)
            ->add('subscribe', SubmitType::class);


    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'=>'AppBundle\Entity\Newsletter'
            )
        );
    }

    public function getName()
    {
        return 'app_bundle_newsletter_type';
    }

}