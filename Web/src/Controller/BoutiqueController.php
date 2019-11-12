<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BoutiqueController extends AbstractController
{
    /**
    *@Route("/boutique", name="boutique")
    */
    public function boutique()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $return = curl_exec($ch);
       
        curl_close($ch);
        $return = json_decode($return, true);
        //return var_dump($return);
        $data=$return[0];
        return $this->render('main/boutique.html.twig', [
            'controller_name' => 'BoutiqueController',
            'articles' =>$data
        ]);
    }

    
}