<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
    #[Route('/navigation', name: 'app_navigation')]
    public function index(): Response
    {
        return $this->render('navigation/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
    #[Route('/membre', name: 'membre')]
    public function membre(): Response
    {
        return $this->render('navigation/membre.html.twig');
    }

//    #[Route('/admin', name: 'admin')]
//    public function admin(): Response
//    {
//        return $this->render('navigation/admin.html.twig');
//    }


}
