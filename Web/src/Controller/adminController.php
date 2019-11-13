<?php

namespace App\Controller;
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
    public function add_product()
    {
        return $this->render('admin/add-product.html.twig'
        );
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
