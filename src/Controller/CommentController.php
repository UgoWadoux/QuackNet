<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}', name: 'app_comment')]
    public function index(Quack $quack): Response
    {
        $comment = $quack->getComment();
        return $this->render('comment/index.html.twig', [
            'quack' => $quack,
            'comments'=>$comment
        ]);
    }

    #[Route('/comment/addcomment/{id}', name: 'add_comment')]
    public function addComment(Request $request, EntityManagerInterface $entityManager, Quack $quack)
    {

        $comment = new Quack();
        $now = new \DateTime();
        $form = $this->createForm(QuackType::class, $comment);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $author = $user->getDuckname();
            $comment->setParent($quack);
            $comment->setAuthor($author);
            $comment->setCreatedAt($now);
            $comment->setUpdatedAt($now);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('quack_list');
        }
        return $this->render('comment/addcomment.html.twig', [
            'form' => $form,
        ]);
    }
}
