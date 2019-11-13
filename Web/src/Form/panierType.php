<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class panierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
        ->add('quantite', ChoiceType::class, array('label'=> 'Quantité', 'required' => true,'choices' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'
       ], 'attr' => array('class'=>'btn btn-primary')))   
        ->add('submit', SubmitType::class, array('label'=>"Ajouter au panier", 'attr' => array('class'=>'btn btn-primary')))
        ;
    }
}