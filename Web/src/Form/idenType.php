<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class idenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //ajout d'une zone de text qui correspondra au nom : TextType
        //elle ne peut pas être vide
            ->add('iden', SubmitType::class, array('label'=>"Masquer", 'attr' => array('class'=>'submit')))
        ;
    }
}