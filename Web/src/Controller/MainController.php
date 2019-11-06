<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
    * @Route("/connect", name="connect")
    */
    public function connect()
    {
        return $this->render('main/connect.html.twig');
    }

    /**
    * @Route("/inscription", name="inscription")
    */
    public function inscription()
    {
        return $this->render('main/inscription.html.twig');
    }
}
