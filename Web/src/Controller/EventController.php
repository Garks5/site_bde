<?php

namespace App\Controller;
use App\Form\BoiteID;
use App\Form\eventType;
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
                //token a changé pour lucas
                // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtYWlsIjoibHVjYXMuZHVsZXVAdmlhY2VzaS5mciIsImp0aSI6ImIzNDNlZjBkLWVhZDYtNDM5Mi04Y2U5LWVhMTFkOWY4YzFmOCIsImlhdCI6MTU3MzY1Nzg3NywiZXhwIjoxNTczNjYxNDc3fQ.ppPkR2AHmZc6hU_xx26Tvn2U14MMWBElLj7UTajLAEA";
                //pauline
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
    public function event_id($id)
    {   
        $form = $this->createForm(eventType::class);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'localhost:3000/activities');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $return = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($return, true);
        $id=$id-1;
        $event=$return[$id];
        //return var_dump($article);
        return $this->render('main/activity.html.twig', [
            'event' =>$event, 
            'form'=>$form->createView()
        ]);  
    }
}