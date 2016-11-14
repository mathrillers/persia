<?php

namespace AppBundle\Form;

use AppBundle\Entity\Postuler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', TextType::class, array('label' => 'Montant :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
            ->add('dateReservation',DateType::class,array('label' => 'Date de Reservation :','label_attr'=>array('class'=>'control-label col-lg-6'),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' =>array('class'=>'form-control'),))
            ->add('postuler',PostulerType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reservation'
        ));
    }
}
