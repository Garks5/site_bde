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
use Symfony\Component\HttpFoundation\JsonResponse;

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
                $dmdp=$data['mdp'];
                $data['mdp'] = crypt($dmdp, "3#5b[PzGu%P8");
                $data['role_id'] = 1;
                $data['inscription'] = "true";

                if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/", $dmdp)) {
                    $dmdp = crypt($dmdp, "3#5b[PzGu%P8");
                    $json_data = json_encode($data);
                    //$json_data = new JsonResponse($data);
                    //return $json_data;
                    //mettre les données dans la bdd

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'localhost:3000/users');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                        'Content-Type: application/json',                                                                                
                        'Content-Length: ' . strlen($json_data))                                                              
                    );
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    $return = curl_exec($ch);
                    curl_close($ch);

                    return $this->redirectToRoute('connect'); 
                    //$manager->flush();
                } else {
                    echo "<script language='Javascript'>

                    document.getElementById('MAJ').style.display='block';

                   window.alert('tm');
                    
                    </script>";
                    return $this->redirectToRoute('inscriptions');   

                    echo "<script language='Javascript'>

                    document.getElementById('MAJ').style.display='block';

                   window.alert('tm');
                    
                    </script>";
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
               $dmdp=hash('sha256',$data['mdp']);
              
               //$manager->flush();
               return $this->redirectToRoute('inscriptions');
            }
       }
    }
}