<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function search(?string $title, ?string $author): array
    {
        $qb = $this->createQueryBuilder('b');

        if ($title) {
            $qb->andWhere('b.title LIKE :title')
               ->setParameter('title', '%'.$title.'%');
        }

        if ($author) {
            $qb->andWhere('b.author LIKE :author')
               ->setParameter('author', '%'.$author.'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function filter(?string $search, ?string $stock): array
{
    $qb = $this->createQueryBuilder('b');

    
    if ($search) {
        $qb->andWhere('b.title LIKE :search OR b.author LIKE :search')
           ->setParameter('search', '%'.$search.'%');
    }

   
    if ($stock !== null && $stock !== '') {
        if ($stock == 1) {
            $qb->andWhere('b.stock > 0');
        } else { 
            $qb->andWhere('b.stock = 0');
        }
    }

    return $qb->getQuery()->getResult();
}



    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
