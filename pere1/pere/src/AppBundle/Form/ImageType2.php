<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class)
            ->add('file',FileType::class  )
            ->add('url',TextType::class)
            ->add('immobilier',null)
            ->add('bienActive',CheckboxType::class)
            ->add('agence',null)
            ->add('agenceActive',CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class'=>'\AppBundle\Entity\Image'
            )
        );
    }

    public function getName()
    {
        return 'app_bundle_image_type';
    }
}
