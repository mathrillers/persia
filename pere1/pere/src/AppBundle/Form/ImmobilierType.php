<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmobilierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, array('label' => 'Reference : ','label_attr'=>array('class'=>'control-label')))
            ->add('adresse', TextType::class, array('label' => 'Adresse : ','label_attr'=>array('class'=>'control-label ')))
              ->add('prix', TextType::class, array('label' => 'Prix : ','label_attr'=>array('class'=>'control-label ')/*, 'attr' => array('class' => 'form-control ', 'type' => 'text')*/))
            ->add('nbrChambre', ChoiceType::class, array('label' => 'Nombre De Chambre : ','label_attr'=>array('class'=>'control-label'), 'choices' => array('1' => '1', '2' => '2', '3' => '3','4' => '4', '5' => '5', '6' => '6','7' => '7', '8' => '8', '9' => '9','10' => '10', '11' => '11', '12' => '12',)/*, 'attr' => array('class' => 'form-control ')*/))
            ->add('nbreSalon', ChoiceType::class, array('label' => 'Nombre De Salon : ','label_attr'=>array('class'=>'control-label'), 'choices' => array('1' => '1', '2' => '2', '3' => '3','4' => '4', '5' => '5', '6' => '6','7' => '7', '8' => '8', '9' => '9','10' => '10', '11' => '11', '12' => '12',)/*, 'attr' => array('class' => 'form-control ')*/))
            ->add('superficie', TextType::class, array('label' => 'Superficie : ','label_attr'=>array('class'=>'control-label ')))
            ->add('jardin', CheckboxType::class, array('label' => 'Jardin : ','label_attr'=>array('class'=>'control-label ')))
            ->add('garage', CheckboxType::class, array('label' => 'Garage : ','label_attr'=>array('class'=>'control-label ')))
            ->add('etat', CheckboxType::class, array('label' => 'Etat Du Bien : ','label_attr'=>array('class'=>'control-label')))
            ->add('proprietaire', EntityType::class, array(
        'class' => 'AppBundle:Personne',
        'choice_label' => 'nom','label'=>'Nom Utilisateur :','label_attr'=>array('class'=>'control-label ')/*,'attr'=>array('class'=>'form-control  m-bot15' )*/
    ))
            ->add('idType', EntityType::class, array(
                'class' => 'AppBundle:TypeImmobilier',
                'choice_label' => 'nom','label'=>'Type du Bien :','label_attr'=>array('class'=>'control-label ')/*,'attr'=>array('class'=>'form-control   m-bot15' )*/
            ))
/*            ->add('quartier',ChoiceType::class, array(
                'label' => 'Quartier : ','label_attr'=>array('class'=>'control-label'),
                //'placeholder' => 'Select the quartier',
                'choices_as_values' => true,
                //'choices' => array(),
                'attr' => array('class' => 'form-control')))*/

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Immobilier'
        ));
    }
}
