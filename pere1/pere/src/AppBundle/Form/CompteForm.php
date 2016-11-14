<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteForm extends AbstractType
{
    /* public function buildForm(FormBuilderInterface $builder, array $options)
     {


         $builder->add('username',TextType::class,array(
             'attr' =>array('placeholder' => 'Login','class'=>'form-control')))
             ->add('password',PasswordType::class,array(
                 'attr' =>array('placeholder' => 'Password','class'=>'form-control')))
          //   ->add('personne',null)
         //    ->add('role',null)
            /* ->add('personne', EntityType::class, array(
                 'class' => 'AppBundle\Entity\Personne',
                 'choice_label' => 'personneId'
             ))*/
    /*->add('active',CheckboxType::class)
    ->add('personne',PersonneType::class)
    ->add('save', SubmitType::class);


}*/

    /*  public function configureOptions(OptionsResolver $resolver)
      {
  $resolver->setDefaults(array(
          'data_class'=>'AppBundle\Entity\Compte'
      )
  );
      }

      public function getName()
      {
          return 'compte';
      }*/
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('label' => 'Login : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
            //->add('password',PasswordType::class,array('label'=>'PassWord ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'password')))
            /* ->add('password',RepeatedType::class,array('label'=>'PassWord Again','label_attr'=>array('class'=>'control-label col-lg-2'), 'attr' => array('class' => 'form-control', 'type' => 'password')))
            */
            ->add('dateCreation',DateType::class,array('label' => 'Date de Creation :','label_attr'=>array('class'=>'control-label col-lg-6'),'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'PassWord : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'password')),
                'second_options' => array('label' => 'PassWord Encore : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'password')),
            ))
            ->add('active',CheckboxType::class,array('label' => 'Etat : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'checkbox')))
            //  ->add('salt', TextType::class, array('label' => 'Salt : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'text')))
            //->add('personne',PersonneType::class)
            /* ->add('role', EntityType::class, array(
                  'class' => 'AppBundle:Role',
                  'choice_label' => 'roleNom',
              'label'=>'Nom Role','label_attr'=>array('class'=>'control-label col-lg-2'),'attr'=>array('class'=>'form-control m-bot15' )))
             */  ->add('role', null,array('label' => 'Role : ','label_attr'=>array('class'=>'control-label col-lg-6'), 'attr' => array('class' => 'form-control col-lg-4', 'type' => 'checkbox')));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Compte'
        ));
    }
}
