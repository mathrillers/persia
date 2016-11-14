<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('nom', TextType::class, array('label' => 'Nom :', 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('adresse', TextareaType::class, array('label' => 'Adresse :', 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('email', EmailType::class, array('label' => 'E-Mail :', 'attr' => array('class' => 'form-control', 'type' => 'email')))
            ->add('telephone', TextType::class, array('label' => 'Telephone :', 'attr' => array('class' => 'form-control', 'type' => 'tel')))
            ->add('description', TextareaType::class, array('label' => 'Description :', 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('numeroCb', TextType::class, array('label' => 'Numero du Compte Bancaire :', 'attr' => array('class' => 'form-control', 'type' => 'text')))
           // ->add('Enregister', SubmitType::class, array('label' => 'Enregister', 'attr' => array('class' => 'btn btn-primary')))
           // ->add('Annuler', SubmitType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-danger')));

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Agence'
        ));
    }
}
