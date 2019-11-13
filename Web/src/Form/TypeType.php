<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au mail : EmailType
        ->add('Type', ChoiceType::class, array('label'=> 'Type:', 'required' => true,'choices' => ['1' => 'Vetements', '2' => 'Goodies',
        ], 'attr' => array('class'=>'form-group')))  
        ->add('submit', SubmitType::class, array('label'=>"Trier", 'attr' => array('class'=>'btn')))
        ;
    }
}