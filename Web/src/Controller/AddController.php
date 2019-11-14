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

use Symfony\Component\HttpFoundation\Session\Session;

class AddController extends AbstractController
{
    /**
    * @Route("/inscriptions", name="inscriptions")
    */
    public function new_inscription(Request $request, ObjectManager $manager)
    {
        //Création du formulaire présent dans la classe UsersType
        $form = $this->createForm(UsersType::class);

        //La méthode GET correspond au chargement de la page 
        //Elle permet de renvoyer le formulaire dans la vue 
        if($request->isMethod('GET')){
            return $this->render('main/inscription.html.twig', [
                'form' => $form->createView()
            ]);
        }
        //Appeller lors de l'envoi des données
        //Les données sont récupérées dans des variables
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $users = new Users;
                $data = $form->getData();
                $dmdp=$data['mdp'];
                $data['mdp'] = crypt($dmdp, "3#5b[PzGu%P8");
                $data['roles_id'] = 1;
                $data['inscription'] = "true";

                if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/", $dmdp)) {
                    $json_data = json_encode($data);
                    //Intégrer les données dans la bdd via l'API

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
                } else {
                    return $this->render('main/inscription.html.twig', [
                        'form' => $form->createView(),
                        'erreur'=>'Votre mot de passe ne respecte pas les conditions'
                    ]);
                }                               
            }
        } 
    }

    /**
    * @Route("/connect", name="connect")
    */
    public function new_connexion(Request $request, ObjectManager $manager)
    {
        //Création du formulaire présent dans la classe ConnectType
        $form_connect = $this->createForm(ConnectType::class);
        
        if($request->isMethod('GET')){
            return $this->render('main/connect.html.twig', [
                'form2' => $form_connect->createView(),
            ]);
        }

       if($request->isMethod('POST')){
         $form_connect->handleRequest($request);
          if($form_connect->isSubmitted() && $form_connect->isValid()) {
               $users = new Users;
               $data_connect = $form_connect->getData();

               $dmdp=$data_connect['mdp'];
               $data_connect['mdp'] = crypt($dmdp, "3#5b[PzGu%P8");

               $json_data = json_encode($data_connect);
               //Intégrer les données dans la bdd via l'API

               $ch = curl_init();

               curl_setopt($ch, CURLOPT_URL, 'localhost:3000/users?connect=true');
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
               curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                   'Content-Type: application/json',                                                                                
                   'Content-Length: ' . strlen($json_data))                                                              
               );
               curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

               $return = curl_exec($ch);
               curl_close($ch);
               $return = json_decode($return, true);

               if (isset($return['connect'])){
                return $this->redirectToRoute('event'); 
               }
               else {
                $token = $return['token'];
                $name=$return['name'];
                $role=$return['role'];
                $sess = $request->getSession();
                $sess->set( 'name', $name);
                $sess->set( 'token', $token);
                $sess->set( 'role', $role);

                //return var_dump($return);
                return $this->redirectToRoute('accueil'); 
               }
               //return $this->redirectToRoute('inscriptions');
            }
        }
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout(Request $request)
    {
        $sess = $request->getSession();
        $sess->clear();
        return $this->redirectToRoute('accueil');
    }
}