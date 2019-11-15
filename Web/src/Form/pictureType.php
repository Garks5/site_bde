<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class pictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de texte qui correspondra à un fbouton qui permet d'ajouter des fichiers : FileType
        ->add('picture', FileType::class, array('label'=> 'Ajouter une photo', 'required' => true,'attr' => array('class'=>'btn btn-primary')))  
        ->add('submit', SubmitType::class, array('label'=>"Valider", 'attr' => array('class'=>'btn btn-primary')))
        ;
    }
}