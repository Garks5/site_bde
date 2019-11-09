<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class ConnectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au mail : EmailType
        //elle ne peut pas être vide
            ->add('mail', EmailType::class, array('label'=> 'Adresse Email', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre adresse mail')))
            ->add('mdp', TextType::class, array('label'=> 'Mot de passe', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre mot de passe')))
            ->add('submit', SubmitType::class, array('label'=>"Se connecter", 'attr' => array('class'=>'btn')))
        ;
    }
}