<?php

namespace App\Controller;

use App\Form\Type\SearchType;
use App\Model\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request): Response
    {
        $searchData =new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dd($searchData);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
