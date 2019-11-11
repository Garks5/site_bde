<?php

namespace App\Controller;
use App\Entity\Users;
use App\Form\UsersType;
use App\Form\ConnectType;
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
    public function new_inscription(Request $request, ObjectManager $manager)
    {
        // création du formulaire présent dans la classe UsersType
        $form = $this->createForm(UsersType::class);
        //La méthode get correspond au chargement de la page 
        // elle permet de renvoyer le formulaire dans la vue 
        if($request->isMethod('GET')){
            return $this->render('main/inscription.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        //appeller lors de l'envoi des données
        //les données sont récupérées dans des variables
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $users = new Users;
                $data = $form->getData();
                $dname=$data['name'];
                $dfirstname=$data['firstname'];
                $dmail=$data['mail'];
                $dmdp=$data['mdp'];
                $dlocalisation=$data['localisation'];
                if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/", $dmdp)) {
                    return $this->redirectToRoute('connect'); 
                    //mettre les données dans la bdd
                    $dmdp=hash('sha526',$data['mdp']);
                    $manager->flush();
                } else {
                    echo "<script language='Javascript'>

                    document.getElementById('MAJ').style.display='block';

                   window.alert('tm');
                    
                    </script>";
                    return $this->redirectToRoute('inscriptions');   
                }                               
            }
        } 
    }

    /**
    * @Route("/connect", name="connect")
    */
    public function new_connexion(Request $request, ObjectManager $manager)
    {
        // création du formulaire présent dans la classe CoonectType
        $form2 = $this->createForm(ConnectType::class);
        
        if($request->isMethod('GET')){
            return $this->render('main/connect.html.twig', [
                'form2' => $form2->createView(),
            ]);
        }

       if($request->isMethod('POST')){
         $form2->handleRequest($request);
          if($form2->isSubmitted() && $form2->isValid()) {
               $users = new Users;
               $data = $form2->getData();
               $dmail=$data['mail'];
               $dmdp=hash('sha526',$data['mdp']);
              
               $manager->flush();
               return $this->redirectToRoute('inscriptions');
            }
       }
    }
}