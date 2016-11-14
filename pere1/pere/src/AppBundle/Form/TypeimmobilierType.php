<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeimmobilierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', ChoiceType::class, array('label' => 'Type Du Bien : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'choices' => array('Grande Villa' => 'Grande Villa','Petite Villa' => 'Petite Villa', 'Appartement Simple' => 'Appartement Simple', 'Appartement Duplex' => 'Appartement Duplex','Appartement Studio' => 'Appartement Studio',), 'attr' => array('class' => 'form-control col-lg-4')))
            ->add('description',TextareaType::class, array('label' => 'Description : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Typeimmobilier'
        ));
    }
}
