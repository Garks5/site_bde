<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;


class updateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //formulaire pour supprimer un élément
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
        ->add('id', IntegerType::class, array('label'=> 'ID:', 'required' => true, 'attr' => array('class'=>'btn btn-primary')))   
        ->add('submit', SubmitType::class, array('label'=>"Ajouter", 'attr' => array('class'=>'btn btn-primary')))
        ;
    }
}