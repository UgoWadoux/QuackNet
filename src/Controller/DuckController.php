<?php

namespace App\Controller;

use App\Entity\Ducks;
use App\Form\Type\DuckType;
use App\Repository\DucksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DuckController extends AbstractController
{
    #[Route('/account/{id}', name: 'app_account')]
    public function modifyAccount(Ducks $ducks, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(DuckType::class, $ducks);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainTextPassword = $ducks->getPassword();
            $quack = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $ducks,
                $plainTextPassword
            );
            $ducks->setPassword($hashedPassword);
            $entityManager->persist($quack);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('duck/account.html.twig', [
            'form' => $form
        ]);

    }

    #[Route ('/profile/{id}', name: 'app_profile')]
    public function getProfile(Ducks $ducks)
    {
        return $this->render('duck/profile.html.twig',[
            'duck'=>$ducks,
        ]);

    }

}