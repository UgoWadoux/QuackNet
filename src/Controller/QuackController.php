<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class QuackController extends AbstractController
{
    #[Route('/quack', name: "quack_list")]
    public function listQuacks(EntityManagerInterface $entityManager):Response
    {

        $quacksRepository = $entityManager->getRepository(Quack::class);
        $quacks = $quacksRepository->findAll();

        return $this->render( 'quack/index.html.twig', ['quacks' => $quacks,
        ]);
    }


    #[Route('/quack/add', name: 'add_quack')]
    public function createQuack(Request $request ,EntityManagerInterface $entityManager): Response {

        $quack = new Quack();
        $now = new \DateTime();
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $author = $user->getDuckname();
            $quack->setAuthor($author);
            $quack->setCreatedAt($now);
            $quack->setUpdatedAt($now);
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_list');
        }

//        return new Response('Savew new quack with id'. $quack->getId());
        return $this->render('quack/add.html.twig', ['form' => $form->createView()

        ]);

    }

    #[Route('/quack/edit/{id}', name: "quack-edit")]
    public function modifyQuack (Request $request, EntityManagerInterface $entityManager, Quack $quack) {

        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $quack->setUpdatedAt(new \DateTime());
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('quack_list');

        }

        return $this->render('quack/edit.html.twig', ['form' => $form->createView()

        ]);
    }




    #[Route('/quack/delete/{id}', name: "quack_delete" )]
    public function deleteQuack(EntityManagerInterface $entityManager, Quack $quack) {
        $entityManager->remove($quack);
        $entityManager->flush();

        return $this->redirectToRoute('quack_list');
    }


}
