<?php

namespace AppBundle\Form;

use Proxies\__CG__\AppBundle\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',EmailType::class)
            ->add('telephone',IntegerType::class)
            ->add('adresse',TextType::class)
            ->add('dateNaissance',DateType::class,array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',)
            )
            ->add('pays',TextType::class)
            ->add('ville',TextType::class)
            ->add('compte',CompteType2::class)


            ->add('valider', SubmitType::class);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
$resolver->setDefaults(array(
        'data_class'=>'AppBundle\Entity\Personne'
    )
);
    }

    public function getName()
    {
        return 'app_bundle_personne_type';
    }
}
