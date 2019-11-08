<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function inscriptions(Request $request)
    {
        dump($request);
        return $this->render('main/inscription.html.twig');
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
