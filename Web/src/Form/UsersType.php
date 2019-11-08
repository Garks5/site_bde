<?php
// src/Form/Type/TaskType.php
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
            ->add('name', TextType::class, array('label'=> 'Nom', 'required' => true, 'attr' => array('class'=>'form-group')))
            ->add('firstname', TextType::class, array('label'=> 'Prénom', 'required' => true, 'attr' => array('class'=>'form-group')))
            ->add('mail', EmailType::class, array('label'=> 'Adresse Email', 'required' => true, 'attr' => array('class'=>'form-group')))
            ->add('mdp', TextType::class, array('label'=> 'Mot de passe', 'required' => true, 'attr' => array('class'=>'form-group')))
            ->add('localisation', ChoiceType::class, array('label'=> 'Centre Cesi', 'required' => true,'choices' => ['Lille' => 'Lille', 'Arras' => 'Arras', 'Rouen' => 'Rouen', 'Reims' => 'Reims', 'Caen' => 'Caen'
            , 'Brest' => 'Brest', 'Nanterre' => 'Nanterre', 'Nancy' => 'Nancy', 'Strasbourg' => 'Strasbourg'
            , 'Le Mans' => 'Le Mans', 'Orléans' => 'Orléans', 'St-Nazaire' => 'St-Nazaire', 'Nantes' => 'Nantes', 'Dijon' => 'Dijon'
            , 'Chateauroux' => 'Chateauroux'], 'attr' => array('class'=>'form-group')))
        ;
    }
}