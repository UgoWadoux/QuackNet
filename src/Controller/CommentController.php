<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\Type\QuackType;
use App\Repository\CommentRepository;
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
        $comments = $quack->getComments();

        return $this->render('comment/index.html.twig', [
            'quack' => $quack,
            'comments'=>$comments
        ]);
    }
    #[Route('/comment/add/{id}', name: 'app_addComment')]
    public function addComment(Quack $quack, Request $request, EntityManagerInterface $entityManager):Response
    {
        $comment = new Quack();
        $form = $this->createForm(QuackType::class, $comment);

        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $user = $this->getUser();
            $author = $user->getDuckname();
            $duckId = $user->getId();
            $profilePicture = $user->getProfilePicture();
            $comment->setParentId($quack);
            $comment->setDuckProfilePicture($profilePicture);
            $comment->setDuckID($duckId);
            $comment->setAuthor($author);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('allquacks');
        }
        return $this->render('comment/addComment.html.twig', [
            'form' => $form
        ]);
    }
}
