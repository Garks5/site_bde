<?php

namespace App\Controller;
use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\Common\Persistence\ObjectManager;
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
    public function new(Request $request, ObjectManager $manager)
    {
        // creates a task object and initializes some data for this example
        $form = $this->createForm(UsersType::class);

        if($request->isMethod('GET')){
            return $this->render('main/inscription.html.twig', [
                'form' => $form->createView(),

            ]);
        }

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $users = new Users;
                $data = $form->getData();
                echo ($data['name']);
                $manager->flush();
                return $this->redirectToRoute('connect');
            }
        }

      
    }
}