<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;


class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
        ->add('activities_id', IntegerType::class, array('label'=> 'ID:', 'required' => true, 'attr' => array('class'=>'btn btn-primary')))   
        ->add('submit', SubmitType::class, array('label'=>"Voter", 'attr' => array('class'=>'btn btn-primary')))
        ;
    }
}