<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('annonceId')
            ->add('typeAnnonce',ChoiceType::class, array('label' => 'Type d"annonce : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'choices' => array( 'Location'=>'Location','Vente' => 'Vente',), 'attr' => array('class' => 'form-control')))
            ->add('description', TextareaType::class, array('label' => 'Description :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('montant', TextType::class, array('label' => 'Montant :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('commission', TextType::class, array('label' => 'Commition (%):','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            /*->add('etat', ChoiceType::class, array('label' => 'Etat de L"annonce : ','label_attr'=>array('class'=>'control-label col-lg-2'), 'choices' => array('Publier' => 'Publier', 'En Attente de Traitement' => 'En Attente de Traitement',), 'attr' => array('class' => 'form-control')))*/
            //->add('nbreVues', TextType::class, array('label' => 'Nombre de Vu :','label_attr'=>array('class'=>'control-label col-lg-2'), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            ->add('reference', TextType::class, array('label' => 'Reference de L"annonce :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control', 'type' => 'text')))
            /*->add('statutDepot', ChoiceType::class, array('label' => 'Statut de L"annonce : ','label_attr'=>array('class'=>'control-label col-lg-2'), 'choices' => array('Valider' => 'Valider', 'Refuser' => 'Refuser','En Attente' => 'En Attente',), 'attr' => array('class' => 'form-control')))*/
            /*->add('datePublication', DateTimeType::class, array('date_widget' => "single_text", 'time_widget' => "single_text",'label' => 'Date de Naissance ','label_attr'=>array('class'=>'control-label col-lg-2')))*/
           /* ->add('dateDepot', DateTimeType::class, array('date_widget' => "single_text", 'time_widget' => "single_text",'label' => 'Date de Naissance ','label_attr'=>array('class'=>'control-label col-lg-2')))*/
           ->add('depositaire', EntityType::class, array(
                'class' => 'AppBundle:Personne','label'=>'Nom du Depositaire :','label_attr'=>array('class'=>'control-label col-lg-6'),'attr'=>array('class'=>'form-control m-bot15' )
            ))
            ->add('titre',TextType::class, array(
                'attr' => array('autofocus' => true, 'class'=> 'form-control','placeholder' => 'titre')
            ))
          /*  ->add('depositaire',null, array(
                'class' => 'AppBundle:Personne',
                'label'=>'Nom du Proprietaire :','label_attr'=>array('class'=>'control-label col-lg-6'),'attr'=>array('class'=>'form-control m-bot15' )
            ))*/

            ->add('immobilier', ImmobilierType::class)
            ->add('type_delai',ChoiceType::class, array('label' => 'Type delai : ','label_attr'=>array('class'=>'control-label'), 'choices' => array('Court' => '1', 'Long'=>'0',), 'attr' => array('class' => 'form-control')))
            ->add('periode_delai',TextType::class, array('attr' => array('class'=> 'form-control','placeholder' => ' periode delai')))
            ->add('prix_delai',TextType::class, array('attr' => array('class'=> 'form-control','placeholder' => 'prix delai')))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Annonce'
        ));
    }
}
