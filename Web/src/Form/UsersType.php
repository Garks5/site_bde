<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
            ->add('name', TextType::class, array('label'=> 'Nom', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre nom')))
            ->add('firstname', TextType::class, array('label'=> 'Prénom', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre prénom')))
            ->add('mail', EmailType::class, array('label'=> 'Adresse Email', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre adresse mail')))
            ->add('mdp', TextType::class, array('label'=> 'Mot de passe', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre mot de passe')))
            ->add('localisation', ChoiceType::class, array('label'=> 'Centre Cesi', 'required' => true,'choices' => ['Lille' => 'Lille', 'Arras' => 'Arras', 'Rouen' => 'Rouen', 'Reims' => 'Reims', 'Caen' => 'Caen'
            , 'Brest' => 'Brest', 'Nanterre' => 'Nanterre', 'Nancy' => 'Nancy', 'Strasbourg' => 'Strasbourg'
            , 'Le Mans' => 'Le Mans', 'Orléans' => 'Orléans', 'St-Nazaire' => 'St-Nazaire', 'Nantes' => 'Nantes', 'Dijon' => 'Dijon'
            , 'Chateauroux' => 'Chateauroux', 'La Rochelle' => 'La Rochelle', 'Angouleme' => 'Angouleme', 'Bordeaux' => 'Bordeaux'
            , 'Lyon' => 'Lyon', 'Grenoble' => 'Grenoble', 'Pau' => 'Pau', 'Toulouse' => 'Toulouse', 'Montpellier' => 'Monpellier'
            , 'Nice' => 'Nice', 'Aix-en-provence' => 'Aix-en-provence'], 'attr' => array('class'=>'form-group')))
            ->add('submit', SubmitType::class, array('label'=>"S'inscrire", 'attr' => array('class'=>'btn')))
        ;
    }
}