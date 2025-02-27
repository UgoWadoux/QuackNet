<?php

namespace App\Controller;

use App\Entity\Ducks;
use App\Entity\Quack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admine/{id}', name: 'app_admin')]
    public function index(Ducks $ducks, EntityManagerInterface $entityManager): Response
    {
        $ducks->setRoles(['ROLE_ADMIN']);
        $entityManager->persist($ducks);
        $entityManager->flush();
        return $this->render('adminetest/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
