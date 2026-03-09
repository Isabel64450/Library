<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
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
        if ($book->getStock() <= 0) {

            $this->addFlash('danger', 'Livre non disponible');

            return $this->redirectToRoute('app_book_index');
        }
        $loan = new Loan();     
        $loan->setBook($book);  
        $form = $this->createForm(LoanType::class, $loan);        
        $form->handleRequest($request);
        
         if ($form->isSubmitted() && $form->isValid()) {    
                           
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
    
    #[Route('/loan/{id}/edit', name: 'app_loan_edit', methods:['POST','GET'])]
public function editLoan(Loan $loan, EntityManagerInterface $entityManager): Response
{
    
    $loan->setStatus('completed');

    $entityManager->persist($loan);
    $entityManager->flush();

    $this->addFlash('success', 'Emprunt marqué comme terminé !');

    return $this->redirectToRoute('app_loan_list');
}
     
#[Route('/loan/{id}', name: 'app_loan_show')]
public function showLoan(Loan $loan): Response
{
    
    return $this->render('loan/show.html.twig', [
        'loan' => $loan,
    ]);
}


#[Route('/loan/stats/authors', name: 'app_loan_author_stats')]
public function authorStats(EntityManagerInterface $entityManager): Response
{
    $loans = $entityManager->getRepository(Loan::class)->findAll();

  
    $compteurs = [];
    foreach ($loans as $loan) {
        $author = $loan->getBook()->getAuthor(); 
        if (isset($compteurs[$author])) {
            $compteurs[$author]++;
        } else {
            $compteurs[$author] = 1;
        }
    }    
    arsort($compteurs);

    return $this->render('loan/author_stats.html.twig', [
        'compteurs' => $compteurs
    ]);
}


#[Route('/loan/user/{id}', name: 'app_loan_user_history')]
public function userHistory(User $user, EntityManagerInterface $entityManager): Response
{
    
    $loans = $entityManager->getRepository(Loan::class)->findBy(
        ['user' => $user],
        ['loanDate' => 'DESC'] 
    );

    return $this->render('loan/user_history.html.twig', [
        'user' => $user,
        'loans' => $loans,
    ]);
}














  }
