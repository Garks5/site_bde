<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
        ->add('commentary', TextType::class, array('label'=> 'Ajouter un commentaire:', 'required' => false, 'attr' => array('class'=>'btn btn-primary zone_text')))   
        ->add('submit', SubmitType::class, array('label'=>"Ajouter le commentaire", 'attr' => array('class'=>'btn btn-primary')))
        ;
    }
}