<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//controlleur accueil et mentions légales

class MainController extends AbstractController
{
    /**
     *@Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('main/accueil.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
    *@Route("/accueil", name="accueil2")
    */
    public function accueil2()
    {
        return $this->render('main/accueil.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
    * @Route("/mention_legale", name="mention_legale")
    */
    public function mention_legale(Request $request)
    {
        dump($request);
        return $this->render('main/mention_legale.html.twig');
    }

    
}
