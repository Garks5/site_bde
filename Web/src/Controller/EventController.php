<?php

namespace App\Controller;
use App\Form\BoiteID;
use App\Form\eventType;
use App\Form\VoteType;
use App\Form\CommentType;
use App\Form\pictureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    /**
    *@Route("/event", name="event")
    */
    public function event()
    {
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities/1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $return = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($return, true);
        //return var_dump($return);
        return $this->render('main/event.html.twig', [
            'controller_name' => 'EventController',
            'events' =>$return
        ]);
    }

    /**
    *@Route("/boiteid", name="boiteid")
    */
    public function boiteid(Request $request)
    {
        //Création du formulaire présent dans la classe UsersType
        $form = $this->createForm(BoiteID::class);
        if($request->isMethod('GET')){
            return $this->render('main/boiteid.html.twig', [
                'formEvent' => $form->createView()
            ]);
        }
        else if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $data['available'] = 0;
                $data['role'] = "Étudiant";
                $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImlkIjo0LCJqdGkiOiI3Y2IzNGM4My05ZmY1LTQ5ZDgtYjI2NS1lZGY4YWM3MGI2NTIiLCJpYXQiOjE1NzM3MjI1MzAsImV4cCI6MTU3MzcyNjEzMH0.Vdg3STQhP08wKGgVlFjK0-mS0b_IwqUxY9y-6ORFVcs";
                $json_data = json_encode($data);
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
               
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
    /**
    *@Route("/event{id}", name="event{id}")
    */
    public function event_id($id, Request $request)
    {   
        $form = $this->createForm(eventType::class);
        $form2 = $this->createForm(CommentType::class);
        $form_picture = $this->createForm(pictureType::class);
        if($request->isMethod('GET')){
            $id_Activity=$id - 1;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            
            $cht = curl_init();
            curl_setopt($cht, CURLOPT_URL, 'localhost:3000/commentaries');
            curl_setopt($cht, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cht, CURLOPT_CUSTOMREQUEST, "GET");
            $return_comm = curl_exec($cht);
            curl_close($cht);
            $return_comm = json_decode($return_comm, true);
            $event=$return[$id_Activity];
            return $this->render('main/activity.html.twig', [
                'event' =>$event, 
                'commentaire'=>$return_comm,
                'form'=>$form->createView(),
                'form2'=>$form2->createView(),
                'picture'=>$form_picture->createView()
            ]); 
        }

        else if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $data['role'] = "Étudiant";
                $data['users_id'] = "4";
                $data['activities_id'] = $id;
                $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImlkIjo0LCJqdGkiOiI5NDQwYWI5Yy1lZWM5LTRkMTktYmUyZS01MzNhZDU0MDA5NmMiLCJpYXQiOjE1NzM3MzcyNTUsImV4cCI6MTU3Mzc0MDg1NX0.4eh0dnpF6T7FAS-Wu6WUoZTxRYqU8fY5JgSgvNyTHXE";
                $json_data = json_encode($data);
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
               
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/inscriptions');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                $return=curl_exec($ch);
                curl_close($ch);
                return $this->redirectToRoute('event'); 
            }
            $form2->handleRequest($request);
            if($form2->isSubmitted()) {
                $data2 = $form2->getData();
                $data2['role'] = "Étudiant";
                $data2['users_id'] = "4";
                $data2['activities_id'] = $id;
                $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImlkIjo0LCJqdGkiOiJkN2NmY2EzNi03ZTI4LTQ3YTAtOWYyNy02MmU2OGI0NmFlYmIiLCJpYXQiOjE1NzM3NDQzOTMsImV4cCI6MTU3Mzc0Nzk5M30.KEUxDjiPhJcs2drD9lVWqzL69ubrVpVYaWQCfbFafTo";
                $json_data = json_encode($data2);
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
               
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/commentaries');
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


    /**
    *@Route("/show_boiteid", name="show_boiteid")
    */
    public function show_boiteid(Request $request)
    {
        //Création du formulaire présent dans la classe UsersType
        $form = $this->createForm(VoteType::class);
        if($request->isMethod('GET')){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities/0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            //return var_dump($return);
             return $this->render('main/show_boiteid.html.twig', [
                'events' =>$return,
                'form'=>$form->createView()
            ]);
        }

        else if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $data['role'] = "Étudiant";
                $data['users_id'] = 4;
                $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImlkIjo0LCJqdGkiOiJlMWIyYTNmOC1kZDI4LTQ1M2YtOGQ2NC01NjEyMzJmYzA4YWMiLCJpYXQiOjE1NzM3NDAyMTEsImV4cCI6MTU3Mzc0MzgxMX0.NKPwKifXbCLgKoff3YG1N8GKpMPSUt8ENbHM4WEjbus";
                $json_data = json_encode($data);
                $header = array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' .$token ,
                    'Content-Length: ' . strlen($json_data)   
                );
               
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/votes');
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
}