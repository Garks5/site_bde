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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class BoutiqueController extends AbstractController
{
    /**
    *@Route("/boutique", name="boutique")
    */
    public function boutique(Request $request)
    {
        //permet d'afficher la boutique
        $form = $this->createForm(TypeType::class);
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

            //recupere le top 3 des articles les plus vendus envoyé par l'API
            $cht = curl_init();
            curl_setopt($cht, CURLOPT_URL, 'localhost:3000/topboutique');
            curl_setopt($cht, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cht, CURLOPT_CUSTOMREQUEST, "GET");
            $topreturn = curl_exec($cht);
            curl_close($cht);
            $topreturn = json_decode($topreturn, true);
            $img1=$topreturn[0]['picture'];
            $img2=$topreturn[1]['picture'];
            $img3=$topreturn[2]['picture'];
            //envoye les informations dans la vue 
            return $this->render('main/boutique.html.twig', [
                'articles' =>$return, 
                'form' => $form->createView(),
                'top1'=>$img1,
                'top2'=>$img2,
                'top3'=>$img3
            ]);
        }
        //La méthode POST correspond à la validation du formulaire dans la vue 
        //Elle permet de renvoyer le formulaire dans l'API
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                //afficher les produits selon leur catégorie
                $data = $form->getData();
                $type=$data['type'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "localhost:3000/boutique/$type");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);

                //recupere le top 3 des articles les plus vendus envoyé par l'API
                $cht = curl_init();
                curl_setopt($cht, CURLOPT_URL, 'localhost:3000/topboutique');
                curl_setopt($cht, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cht, CURLOPT_CUSTOMREQUEST, "GET");
                $topreturn = curl_exec($cht);
                curl_close($cht);
                $topreturn = json_decode($topreturn, true);
                $img1=$topreturn[0]['picture'];
                $img2=$topreturn[1]['picture'];
                $img3=$topreturn[2]['picture'];
                //envoye les informations dans la vue
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
            //affiche un produit en particulier
            $form = $this->createForm(panierType::class);
            //La méthode GET correspond au chargement de la page 
            //Elle permet de renvoyer le formulaire dans la vue 
            if($request->isMethod('GET')){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/boutique');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);
                $id=$id-1;
                //selection de l'article dont l'ID est demandé
                $article=$return[$id];
                return $this->render('main/article.html.twig', [
                    'articles' =>$article,
                    'form' => $form->createView()
                    ]);
            }
            //La méthode POST correspond à la validation du formulaire dans la vue 
            //Elle permet de renvoyer le formulaire dans l'API
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                $data = $form->getData();
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "localhost:3000/boutique");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);
                $id=$id-1;
                $article=$return[$id];
                $addPanier_id = $return[$id]['id'];
                $addPanier_quantity = $data['quantite'];
                $addPanier_name = $return[$id]['name'];
                $addPanier_price = $return[$id]['price'];
                $addPanier_description = $return[$id]['description'];

                $cookieGuest = array(
                    'id_article' => $addPanier_id,
                    'article_picture' => $return[$id]['picture'],
                    'quantity' => $addPanier_quantity,
                    'nom_article'  => $addPanier_name,
                    'prix' => $addPanier_price,
                    'description' => $addPanier_description
                );
                //gestion des cookies
                $response = new Response();
                $response->headers->setCookie(Cookie::create('Id', $cookieGuest['id_article']));
                $response->headers->setCookie(Cookie::create('Picture', $cookieGuest['article_picture']));
                $response->headers->setCookie(Cookie::create('Quantity', $cookieGuest['quantity']));
                $response->headers->setCookie(Cookie::create('Nom', $cookieGuest['nom_article']));
                $response->headers->setCookie(Cookie::create('Description', $cookieGuest['description']));
                $response->headers->setCookie(Cookie::create('Prix', $cookieGuest['prix']));
                $response->send();

                return $this->redirectToRoute('panier');

                }
        }

   /* public function index()
    {
        return $this->render('search/index', [
            'controller_name' => 'BoutiqueController',
        ]);
    }

    public function searchBar(){
        $form2 = $this->createFormBuilder(null)
        ->add('query', TextType::class)
        ->add('search', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary'
            ]
        ])
        ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'form2' => $form2->createView()
        ]);
    }*/

    /**
    * @Route("/panier", name="panier")
    */
    public function panier(Request $request)
    {
        $sess = $request->getSession();
        if ($sess->get('firstname') != NULL){
            return $this->render('main/panier.html.twig');
        }
        else{
           return $this->redirectToRoute('connect');
        }
    }

    
    /**
    * @Route("/valider_panier", name="valider_panier")
    */
    public function valider_panier(Request $request)
    {
        $sess = $request->getSession();
        $cookies_idArticle = $request->cookies->get('Id');
        $cookies_quantityArticle = $request->cookies->get('Quantity'); 
       
           // $form->handleRequest($request);
                $data['id'] = $cookies_idArticle;
                $data['quantity'] = $cookies_quantityArticle;
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
                curl_setopt($ch, CURLOPT_URL, 'localhost:3000/components');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    $return = curl_exec($ch);
                    curl_close($ch);
                    return $this->redirectToRoute('boutique'); 
    }
}