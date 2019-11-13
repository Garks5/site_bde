<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;


class BoiteID extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
            ->add('name', TextType::class, array('label'=> 'Nom l\'événement', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez le nom de votre événement')))
            ->add('description', TextType::class, array('label'=> 'Description de votre événement', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez votre adresse mail')))
            ->add('place', TextType::class, array('label'=> 'Lieu de l\'événment', 'required' => true, 'attr' => array('class'=>'form-group','placeholder'=>'Entrez le lieu de l\'événément')))
            ->add('date', DateType::class, array('label'=> 'Date de l\'événement', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez la date de l\'événement')))
            ->add('submit', SubmitType::class, array('label'=>"S'inscrire", 'attr' => array('class'=>'btn')))
        ;
    }
}