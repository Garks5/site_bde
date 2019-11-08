<?php

namespace App\Controller;
use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddController extends AbstractController
{

    /**
    * @Route("/inscriptions", name="inscriptions")
    */
    public function new()
    {
        // creates a task object and initializes some data for this example
  

        $form = $this->createForm(UsersType::class);
        return $this->render('main/inscription.html.twig', [
            'form' => $form->createView(),

        ]);

      
    }
}