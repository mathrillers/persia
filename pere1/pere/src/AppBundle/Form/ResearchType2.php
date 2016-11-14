<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mot_cle',TextType::class,array(
                'required'=> false
            ))
            ->add('ville',EntityType::class, array(
                'label' => 'Ville : ',
                'class'=>'AppBundle\Entity\Ville',
            ))
            ->add('typeImmobilier',EntityType::class, array(
                'class'=> 'AppBundle\Entity\TypeImmobilier'
            ))
            ->add('actes',ChoiceType::class, array(
                'choices' => array('Vente' => 'Vente','Location'=>'Location',),
            ))
            ->add('min_prix', ChoiceType::class, array(
                'choices' => array('500'=>'500','1000'=>'1000','2000'=>'2000'),
            ))
            ->add('max_prix', ChoiceType::class, array(
                'choices' => array('2000'=>'2000','5000'=>'5000','10000'=>'10000'),
            ))
            ->add('chercher',SubmitType::class)
            ->add('budgetVente',TextType::class)
            ->add('budgetLoc',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_research_type';
    }
}
