<?php

namespace App\Controller;
use App\Form\AddProductType;
use App\Form\BoiteID;
use App\Form\DelType;
use App\Form\CesiType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//controlleur pour les fonctions adminitrateurs et personnel CESI
class adminController extends AbstractController
{
    /**
     *@Route("/admin", name="admin")
     */
    public function admin(Request $request)
    {
        //chargement de la page admin
        $sess = $request->getSession();
        if ($sess->get('role') == "BDE"){
            return $this->render('main/admin.html.twig'
            );
        }
        //Si le rôle n'est pas BDE, redirection vers la page accueil
        else{
            return $this->redirectToRoute('accueil');
        }
    }

    /**
     *@Route("/admin-add-event", name="add-event")
     */
    public function add_event(Request $request)
    {
        $sess = $request->getSession();
        if ($sess->get('role') == "BDE"){
            $form = $this->createForm(BoiteID::class);
            //La méthode GET correspond au chargement de la page 
            //Elle permet de renvoyer le formulaire dans la vue 
            if($request->isMethod('GET')){
                return $this->render('admin/add-event.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            //POST correspond à l'envoi du formulaire
            else if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted()) {
                    $data = $form->getData();
                    $data['available'] = 1;
                    $data['role'] = $sess->get('role');
                    $token= $sess->get('token');
                    $json_data = json_encode($data);
                    //préparation du hearder de la requete
                    $header = array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer ' .$token ,
                        'Content-Length: ' . strlen($json_data)   
                    );
                    //envoi de la requête
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    $return=curl_exec($ch);
                    curl_close($ch);
                    return $this->redirectToRoute('event'); 
                }
            }
        }
        //Si le rôle n'est pas BDE, redirection vers la page accueil
        else{
            return $this->redirectToRoute('accueil'); 
        }
    }
    /**
     *@Route("/admin-show-idea", name="show-idea")
     */
    public function show_idea(Request $request)
    {
        $sess = $request->getSession();
        //vérification du rôle
        if ($sess->get('role') == "BDE"){
            $form = $this->createForm(DelType::class);
            //La méthode GET correspond au chargement de la page 
            //Elle permet de renvoyer le formulaire dans la vue 
            if($request->isMethod('GET')){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities/0');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);
                //return var_dump($return);
                return $this->render('admin/show-idea.html.twig', [
                    'controller_name' => 'EventController',
                    'events' =>$return,
                    'form'=> $form->createView()
                ]);
            }
            //La méthode POST correspond à la validation du formulaire dans la vue 
            //Elle permet de renvoyer le formulaire dans l'API
            else if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted()) {
                    $data = $form->getData();
                    $data['role'] = $sess->get('role');
                    $data['available'] = 1;
                    $json_data = json_encode($data);
                    $token= $sess->get('role');
                    //Préparation du header
                    $header = array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer ' .$token ,
                        'Content-Length: ' . strlen($json_data)   
                    );
                    //Intégrer les données dans la bdd via l'API
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                        $return = curl_exec($ch);
                        curl_close($ch);
                        return $this->redirectToRoute('admin'); 
                    }                               
                }
            }
            //Si le rôle n'est pas BDE, redirection vers la page accueil
            else{
                return $this->redirectToRoute('accueil'); 
            }
    }

    /**
     *@Route("/admin-dell-event", name="dell-event")
     */
    public function dell_event(Request $request)
    {
        $sess = $request->getSession();
        //vérification du rôle
        if ($sess->get('role') == "BDE"){
            $form = $this->createForm(DelType::class);
            //La méthode GET correspond au chargement de la page 
            //Elle permet de renvoyer le formulaire dans la vue 
            if($request->isMethod('GET')){
            $ch = curl_init();
            //afichage des activités validé par le BDE
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities/1');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            //envoi des données de la requête et du formulaire
            return $this->render('admin/dell-event.html.twig', [
                'events' =>$return,
                'form'=> $form->createView()
            ]);
            }
            //La méthode POST correspond à la validation du formulaire dans la vue 
            //Elle permet de renvoyer le formulaire dans l'API
            else if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted()) {
                    $data = $form->getData();
                    $data['role']= $sess->get('role');
                    $json_data = json_encode($data);
                    $token= $sess->get('token');
                    //préparation du header
                    $header = array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer ' .$token ,
                        'Content-Length: ' . strlen($json_data)   
                    );
                    //Intégrer les données dans la bdd via l'API
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                        //type de requete
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                        $return = curl_exec($ch);
                        curl_close($ch);
                        return $this->redirectToRoute('admin'); 
                    }                               
                }
            }
            //Si le rôle n'est pas BDE, redirection vers la page accueil
            else{
                return $this->redirectToRoute('accueil'); 
            }
    }

    /**
     *@Route("/admin-add-product", name="add-product")
     */
    public function add_product(Request $request)
    {
        $sess = $request->getSession();
        if ($sess->get('role') == "BDE"){
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
                    $data['role']= $sess->get('role');
                    $json_data = json_encode($data);
                    $token=$sess->get('token');
                    //préparation du header
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
            //Si le rôle n'est pas BDE, redirection vers la page accueil
            else{
                return $this->redirectToRoute('accueil'); 
            }
        }
    /**
     *@Route("/admin-dell-product", name="dell-product")
     */
    public function dell_product(Request $request)
    {
        $sess = $request->getSession();
        //vérification du rôle
        if ($sess->get('role') == "BDE"){
            $form = $this->createForm(DelType::class);
            //La méthode GET correspond au chargement de la page 
            //Elle permet de renvoyer le formulaire dans la vue 
            if($request->isMethod('GET')){
                //récupere toutes les données produits envoyées par l'API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);
                return $this->render('admin/dell-product.html.twig', [
                    'articles' =>$return, 
                    'form' => $form->createView()
                ]);
            }
            //La méthode POST correspond à la validation du formulaire dans la vue 
            //Elle permet de renvoyer le formulaire dans l'API
            else if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted()) {
                    $data = $form->getData();
                    $data['role']= $sess->get('role');
                    $json_data = json_encode($data);
                    $token=$sess->get('token');
                    //préparation du header
                    $header = array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer ' .$token ,
                        'Content-Length: ' . strlen($json_data)   
                    );
                    
                    //Intégrer les données dans la bdd via l'API
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                        $return = curl_exec($ch);
                        curl_close($ch);
                        return $this->redirectToRoute('admin'); 
                    
                    }                               
                }
        }
        //Si le rôle n'est pas BDE, redirection vers la page accueil
        else{
            return $this->redirectToRoute('accueil'); 
        }
    }

    /**
     *@Route("/personnel_cesi", name="personnel_cesi")
     */
    public function cesi(Request $request)
    {
        $sess = $request->getSession();
        //vérifiaction du rôle
        if ($sess->get('role') == "Personnel CESI"){
            $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities/1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $return = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($return, true);
        return $this->render('main/cesi.html.twig', [
            'controller_name' => 'EventController',
            'events' =>$return
        ]);
        }
         //Si le rôle n'est pas CESI, redirection vers la page accueil
        else{
            return $this->redirectToRoute('accueil');
        }
    }

    /**
    *@Route("/activity_cesi{id}", name="activity_cesi{id}")
    */
    public function event_cesi_id($id, Request $request)
    {   
        //récupération des données de la session 
        $sess = $request->getSession();
        $form = $this->createForm(CesiType::class);
        //La méthode GET correspond au chargement de la page 
        //Elle permet de renvoyer le formulaire dans la vue 
        if($request->isMethod('GET')){
            $id_Activity=$id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            $event=$return[$id_Activity];
            return $this->render('main/activity_cesi.html.twig', [
                'event' =>$event,
                'masquer'=>$form->createView()
            ]); 
        }
        //La méthode POST correspond à la validation du formulaire dans la vue 
        //Elle permet de renvoyer le formulaire dans l'API
        else if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $data['id']=$id;
                $data['role'] = $sess->get('role');
                $data['available'] = 0;
                settype($data['id'], "integer");
                $json_data = json_encode($data);
                $token= $sess->get('role');
                //Préparation du header
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
                //Intégrer les données dans la bdd via l'API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                $return = curl_exec($ch);
                curl_close($ch);
                return $this->redirectToRoute('event'); 
            }                               
        }
    }
    /**
     * @Route("/EventPDF", name="EventPDF")
     */
    public function showEventPDF(Request $request)
    {
        if($request->isMethod('GET'))
        {   
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            return $this->render('admin/EventPDF.html.twig', [
                'controller_name' => 'adminController',
                'events' =>$return
            ]);
        }
    }
    /**
     * @Route("/EventPDF{id}", name="EventPDF{id}")
     */
    public function EventPDF_id(Request $request, $id)
    {
        if($request->isMethod('GET'))
        {   
            $sess = $request->getSession();
            $token = $sess->get('token');
            $header = array(
                'Authorization: Bearer ' .$token 
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "localhost:3000/activities?id=$id&download=true");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);

            $path = 'csv/';
            $dl_file = 'activity' . $id . 'attendees.csv';
            $fullpath = $path . $dl_file;
            $key = true;
            $array_values= array();
            try{
                $fd = fopen($fullpath, 'x+');
            }catch(E_Warning $e){
            }
            if($fd){
                for($i = 0; $i < count($return)+1; $i++){
                    if($key){
                        foreach($return[$i] as $keys => $values){
                            $array_keys[] = $keys; 
                        }
                        $key = false;
                        fputcsv($fd, $array_keys, ';');
                    }else{
                        $j = 0;
                        foreach($return[$i - 1] as $keys => $values){
                            $array_values[$j] = $values;
                            $j++;
                        }
                        fputcsv($fd, $array_values, ';');
                    }
                }
                $fsize = filesize($fullpath);
                $path_part = pathinfo($fullpath);
                header("Content-Type: application/force-download; name=\"" . $path_part['basename'] . "\"");
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: $fsize");
                header("Content-Disposition: attachment; filename=\"" . $path_part['basename'] . "\"");
                header("Expires: 0");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                readfile("csv/" . $path_part['basename']);
                fclose($fd);
            }
            return $this->render('main/admin.html.twig', [
                'controller_name' => 'adminController'
            ]);
        }
    }
}