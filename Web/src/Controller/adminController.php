<?php

namespace App\Controller;
use App\Form\AddProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
//controlleur accueil et mentions légales

class adminController extends AbstractController
{
    /**
     *@Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('main/admin.html.twig'
        );
    }

    /**
     *@Route("/admin-add-event", name="add-event")
     */
    public function add_event()
    {
        return $this->render('admin/add-event.html.twig'
        );
    }

    /**
     *@Route("/admin-show-idea", name="show-idea")
     */
    public function show_idea()
    {
        return $this->render('admin/show-idea.html.twig'
        );
    }

    /**
     *@Route("/admin-dell-event", name="dell-event")
     */
    public function dell_event()
    {
        return $this->render('admin/dell-event.html.twig'
        );
    }

    /**
     *@Route("/admin-add-product", name="add-product")
     */
    public function add_product(Request $request)
    {
        //Création du formulaire présent dans la classe UsersType
        $form = $this->createForm(AddProductType::class);

        //La méthode GET correspond au chargement de la page 
        //Elle permet de renvoyer le formulaire dans la vue 
        if($request->isMethod('GET')){
            return $this->render('admin/add-product.html.twig', [
                'form' => $form->createView()
            ]);
        }
    
        //Appeller lors de l'envoi des données
        //Les données sont récupérées dans des variables
       if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $data['nb_vendu'] = "0";
                $data['role']="BDE";
               // return var_dump($data);
                $json_data = json_encode($data);
                $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoiY2RAY2QuY2RyIiwianRpIjoiM2I2NWVkNTgtODIyNC00NTEzLTk1OTctNDc2NWZiOTU2NGJkIiwiaWF0IjoxNTczNzIyMzY0LCJleHAiOjE1NzM3MjU5NjR9.oTZMZZB7Ta6q9ef6MoKal5jydFrhNBUdQy8I7wpshdU";
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
                
                //Intégrer les données dans la bdd via l'API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    $return = curl_exec($ch);
                    curl_close($ch);
                    return $this->redirectToRoute('admin'); 
                 
                }                               
            }
        } 
    


    /**
     *@Route("/admin-dell-product", name="dell-product")
     */
    public function dell_product()
    {
        return $this->render('admin/dell-product.html.twig'
        );
    }
}
