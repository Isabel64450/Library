<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Form\LoanType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoanController extends AbstractController
{
    #[Route('/loan', name: 'app_loan_list')]
    public function listLoan(EntityManagerInterface $entityManager): Response      
       

    {   $loans = $entityManager->getRepository(loan::class)->findAll();
        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
        ]);
    }


     #[Route('/loan/new/{id}', name: 'app_loan_new')]
    public function newLoan(Request $request, EntityManagerInterface $entityManager, Book $book): Response
    {
        
        $loan = new Loan();     
        $loan->setBook($book);  
        $form = $this->createForm(LoanType::class, $loan);        
        $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {

       
                   if ($book->getStock() <= 0) {

            $this->addFlash('error', 'Livre non disponible');

            return $this->redirectToRoute('app_loan_new', [
                'id' => $book->getId()
            ]);
        }
        
        $book->setStock($book->getStock() - 1);

            
            $entityManager->persist($loan);
            $entityManager->flush();

            $this->addFlash('success', 'Loan created successfully!');           
            return $this->redirectToRoute('app_loan_list');
        }        
        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'book' =>$book,
            'form' => $form->createView(),
        ]);
    }
    
     





















  }
