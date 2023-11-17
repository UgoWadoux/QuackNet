<?php

namespace App\Controller;

use App\Entity\Ducks;
use App\Form\Type\DuckType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'duck_registration')]
    public function registration (UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $duck = new Ducks();
        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $duck = $form->getData();
            $plainTextPassword = $duck->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
                $duck,
                $plainTextPassword
            );
            $duck->setPassword($hashedPassword);
            $entityManager->persist($duck);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('duck/index.html.twig', [
//            'duck'=> $duck,
            'form'=>$form
        ]);

    }
}