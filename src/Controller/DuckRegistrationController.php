<?php

namespace App\Controller;

use App\Entity\Duck;

//use http\Env\Request;
use App\Form\ModifyDuckType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DuckRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DuckRegistrationController extends AbstractController
{
    #[Route('/duck', name: 'frontpage')]
    public function index(): Response
    {
        return $this->render('quack/index.html.twig', [
            'controller_name' => 'DuckRegistrationController',
        ]);
    }

    #[Route('/duck/registration', name: 'registration')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {

        $duck = new Duck();
        $form = $this->createForm(DuckRegistrationFormType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duck = $form->getData();
            $plaintextPassword = $duck->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $duck,
                $plaintextPassword
            );
            $duck->setPassword($hashedPassword);
            $entityManager->persist($duck);
            $entityManager->flush();

            return $this->redirectToRoute('registration');

        }
        return $this->render('duck_registration/index.html.twig', ['form' => $form,
            'duck' => $duck]);
    }

    #[Route("/duck/update/{id}", name: "update_duck")]
    public function updateProfile(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, Duck $duck): Response
    {

        $form = $this->createForm(ModifyDuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $duck = $form->getData();

            $newPassword = $duck->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $duck,
                $newPassword
            );
            $duck->setPassword($hashedPassword);
            $entityManager->flush();
            return $this->redirectToRoute('quack_list');

        }
        return $this->render("duck_registration/update.html.twig", ['form' => $form->createView()]);
    }
}
