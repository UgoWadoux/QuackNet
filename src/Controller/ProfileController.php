<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profil/show/{id}', name: 'show_profile')]
    public function showProfile(): Response {

        $user = $this->getUser();

        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/show_profile.html.twig', ['user' => $user]);
    }
}
