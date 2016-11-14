<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostulerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('datePost',DateType::class,array('label' => 'Date de Postulation :','label_attr'=>array('class'=>'control-label col-lg-6'),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',))*/
            // ->add('statut',TextType::class, array('attr' => array('class'=> 'form-control','placeholder' => ' periode delai')))
            ->add('annonce',
                EntityType::class, array(
                    'class' => 'AppBundle:Annonce',
                    /*'placeholder' => 'Selectionne une Annonce !',*/
                    'label'=>'Annonce :',
                    'label_attr'=>array('class'=>'control-label '),
                    'attr' => array('class' => 'form-control')))
            ->add('personne',
                EntityType::class, array(
                    'class' => 'AppBundle:Personne',
                    /*'placeholder' => 'Selectionne une Personne !',*/
                    'label'=>'Propriétaire :',
                    'label_attr'=>array('class'=>'control-label '),
                    'attr' => array('class' => 'form-control')))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Postuler'
        ));
    }
}
