<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Entity\Ducks;
use App\Form\Type\QuackType;
use App\Form\Type\SearchType;
use App\Model\SearchData;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuackController extends AbstractController
{
    #[Route('/quack', name: 'app_quack')]
    public function index(): Response
    {
        return $this->render('quack/index.html.twig', [
            'controller_name' => 'QuackController',
        ]);
    }

    #[Route('/', name: 'allquacks')]
    public function listAllQuacks(QuackRepository $quackRepository, Request $request): Response
    {
        $searchData =new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $searchData->page = $request->query->getInt('page', 1);
            $quacks = $quackRepository->findBySearch($searchData);
//            dd($quacks);

            return $this->render('quack/listAllQuacks.html.twig', [
                'form'=>$form,
                'quacks'=>$quacks
            ]);
        }

        $allQuacks = $quackRepository->findAll();
        return $this->render('quack/listAllQuacks.html.twig', [
            'form'=> $form,
            'quacks' => $allQuacks
        ]);
    }

    #[Route('/quack/addquack', name: 'add_quackForm')]
    public function addQuackForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quack = new Quack();
//        $Quack->setContent($content);
//        $Quack->setCreatedAt(new \DateTime());
//        $form = $this->createFormBuilder($quack)
//            ->add('Content', TextareaType::class)
//            ->add('CreatedAt', DateType::class)
//            ->add('save', SubmitType::class, ['label'=>'Create Quack'])
//            ->getForm();
//        $entityManager->persist($quack);
//        $entityManager->flush();
//        return new Response('Saved new product with id' . $quack->getId());
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $author = $user->getDuckname();
            $duckId = $user->getId();
            $profilePicture = $user->getProfilePicture();
            $quack->setDuckProfilePicture($profilePicture);
            $quack->setDuckID($duckId);
            $quack->setAuthor($author);
            $quack = $form->getData();
            $entityManager->persist($quack);
            $entityManager->flush();
            return $this->redirectToRoute('allquacks');
        }
        return $this->render('quack/addQuack.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/quack/modifyquack/{id}', name: 'modify_quack')]
    public function modifyQuack(Quack $quack, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quack = $form->getData();
            $entityManager->persist($quack);
            $entityManager->flush();
            return $this->redirectToRoute('allquacks');
        }

        return $this->render('quack/modifyQuack.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/quack/deletequack/{id}', name: 'delete_quack')]
    public function deleteQuack(Quack $quack, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($quack);
        $entityManager->flush();
        return $this->redirectToRoute('allquacks');
    }

    #[Route('/quack/display/{id}', name : 'app_quack_display')]
    public function dontDisplayQuack (Quack $quack, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $quack->setDisplay(false);
        $entityManager->persist($quack);
        $entityManager->flush();
        return $this->redirectToRoute('allquacks');
    }

}
