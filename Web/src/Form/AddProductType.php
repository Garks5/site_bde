<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\FormBuilderInterface;


class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
            ->add('name', TextType::class, array('label'=> 'Nom', 'required' => true, 'attr' => array('class'=>'form-group', 'placeholder'=>'Entrez le nom ')))
            ->add('description', TextType::class, array('label'=> 'Description de l\'article', 'required' => true, 'attr' => array('class'=>'form-group ', 'placeholder'=>'Entrez la description de l\'article')))
            ->add('price', TextType::class, array('label'=> 'Prix', 'required' => true, 'attr' => array('class'=>'form-group ','placeholder'=>'Entrez le prix')))
            ->add('types_id', ChoiceType::class, array('label'=> 'Type:', 'required' => true,'choices' => ['Vêtements' => '1', 'Goodies' => '2',
            ], 'attr' => array('class'=>'form-group')))  
            ->add('picture', TextType::class, array('label'=> 'Image', 'required' => true, 'attr' => array('class'=>'form-group ', 'placeholder'=>'Entrez l\'url de l\'image')))
            ->add('submit', SubmitType::class, array('label'=>"Ajouter l'article", 'attr' => array('class'=>'btn ')))
        ;
    }
}