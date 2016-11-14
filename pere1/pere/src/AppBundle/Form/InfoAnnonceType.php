<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoAnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aime', CheckboxType::class, array('label' => 'J"aime : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4')))
            ->add('favori', CheckboxType::class, array('label' => 'Favorie : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4')))
            ->add('annonces',AnnonceType::class)
            ->add('personnes',null)

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\InfoAnnonce'
        ));
    }
}
