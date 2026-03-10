<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage', methods:['GET'])]
    public function index(BookRepository $bookRepository, Request $request): Response
    {
       $search = $request->query->get('search');    
       $stock = $request->query->get('stock');

    
    if (!$search && ($stock === null || $stock === '')) {
        $books = $bookRepository->findAll();
    } else {
      
        $books = $bookRepository->filter($search, $stock);
    }

    return $this->render('homepage/index.html.twig', [
        'books' => $books,
    ]);
    }
}
