<?php

namespace AppBundle\Form;

use AppBundle\Entity\Compte;
use Proxies\__CG__\AppBundle\Entity\Personne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder->add('nom',TextType::class,array(
            'attr' => array( 'placeholder' => 'Nom', 'class'=>'form-control')))
            ->add('prenom',TextType::class,array(
                'attr' =>array('placeholder' => 'Prenom','class'=>'form-control')))
            ->add('email',EmailType::class,array(
                'attr' =>array('placeholder' => 'Email','class'=>'form-control')))
            ->add('telephone',IntegerType::class,array(
                'attr' =>array('placeholder' => 'Telephone','class'=>'form-control')))
            ->add('adresse',TextType::class,array(
                'attr' =>array('placeholder' => 'Adresse','class'=>'form-control')))
            ->add('dateNaissance',DateType::class,array(
                    'attr' =>array('class'=>'form-control'),
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',)
            )
            ->add('pays',TextType::class,array(
                'attr' =>array('placeholder' => 'Pays','class'=>'form-control')))
            ->add('ville',TextType::class,array(
                'attr' =>array('placeholder' => 'Ville','class'=>'form-control')))
         //   ->add('compte',CompteForm::class)
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
        return 'personnetype';
    }*/
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label' => 'Nom :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
            ->add('prenom', TextType::class, array('label' => 'Prenom :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
           // ->add('dateNaissance', DateTimeType::class, array('date_widget' => "single_text", 'time_widget' => "single_text",'label' => 'Date de Naissance :','label_attr'=>array('class'=>'control-label col-lg-6')))
            ->add('dateNaissance',DateType::class,array('label' => 'Date de Naissance :','label_attr'=>array('class'=>'control-label col-lg-6'),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',))
            ->add('adresse', TextareaType::class, array('label' => 'Adresse :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
            ->add('email', EmailType::class, array('label' => 'E-Mail :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'email')))
            ->add('telephone', TextType::class, array('label' => 'Telephone :','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'tel')))
            ->add('ville', ChoiceType::class, array('label' => 'Ville :','label_attr'=>array('class'=>'control-label col-lg-6'), 'choices' => array('Casablanca' => 'Casablanca', 'Rabat' => 'Rabat', 'Tanger' => 'Tanger'), 'attr' => array('class' => 'form-control col-lg-4')))
            ->add('pays', ChoiceType::class, array('label' => 'Pays :','label_attr'=>array('class'=>'control-label col-lg-6'), 'choices' => array('Maroc' => 'Maroc', 'France' => 'France', 'Belgique' => 'Belgique'), 'attr' => array('class' => 'form-control col-lg-4')))
            ->add('compte', CompteForm::class)
         /*   ->add('Enregister', SubmitType::class, array('label' => 'Enregister', 'attr' => array('class' => 'btn btn-primary')))
            ->add('Annuler', SubmitType::class, array('label' => 'Annuler', 'attr' => array('class' => 'btn btn-danger')));
   */
   ; }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Personne'
        ));
    }
}
