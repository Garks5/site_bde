<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TypeType;
use App\Form\panierType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Persistence\ObjectManager;

class BoutiqueController extends AbstractController
{
    /**
    *@Route("/boutique", name="boutique")
    */
    public function boutique(Request $request)
    {
        $form = $this->createForm(TypeType::class);
        if($request->isMethod('GET')){
            //récupere toutes les données produits envoyées par l'API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            

            $return = curl_exec($ch);
        
            curl_close($ch);
            $return = json_decode($return, true);

            //recupere le top 3 des articles les plus vendus envoyé par l'API
            $cht = curl_init();
            curl_setopt($cht, CURLOPT_URL, 'localhost:3000/boutique');
            curl_setopt($cht, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cht, CURLOPT_CUSTOMREQUEST, "GET");
            $topreturn = curl_exec($cht);
            curl_close($cht);
            $topreturn = json_decode($topreturn, true);
            $img1=$topreturn[0]['picture'];
            $img2=$topreturn[1]['picture'];
            $img3=$topreturn[2]['picture'];
        
            return $this->render('main/boutique.html.twig', [
                'articles' =>$return, 
                'form' => $form->createView(),
                'top1'=>$img1,
                'top2'=>$img2,
                'top3'=>$img3
            ]);
        }

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $data = $form->getData();
                $type=$data['type'];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "localhost:3000/boutique/$type");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);

                $cht = curl_init();
                curl_setopt($cht, CURLOPT_URL, 'localhost:3000/boutique');
                curl_setopt($cht, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cht, CURLOPT_CUSTOMREQUEST, "GET");
                $topreturn = curl_exec($cht);
                curl_close($cht);
                $topreturn = json_decode($topreturn, true);
                $img1=$topreturn[0]['picture'];
                $img2=$topreturn[1]['picture'];
                $img3=$topreturn[2]['picture'];
                return $this->render('main/boutique.html.twig', [
                    'articles' =>$return, 
                    'form' => $form->createView(),
                    'top1'=>$img1,
                    'top2'=>$img2,
                    'top3'=>$img3
                ]);
            }
        }
    }

    /**
    *@Route("/boutique{id}", name="boutique{id}")
    */
    public function boutique_id($id, Request $request)
    {   
        $form = $this->createForm(panierType::class);
        if($request->isMethod('GET')){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $return = curl_exec($ch);
            curl_close($ch);
            $return = json_decode($return, true);
            $id=$id-1;
            $article=$return[$id];
            //return var_dump($article);
            return $this->render('main/article.html.twig', [
                'articles' =>$article,
                'form' => $form->createView()
                ]);
        }
    }

}