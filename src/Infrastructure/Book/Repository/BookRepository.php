<?php

namespace App\Infrastructure\Book\Repository;

use App\Domain\Book\Entity\Book;
use App\Domain\Book\Repository\BookRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class BookRepository
 * @package App\Infrastructure\Book\Repository
 */
class BookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param Book $book
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveBook(Book $book): void
    {
        $this->_em->persist($book);
        $this->_em->flush($book);
    }

    public function findBooks(?string $title, ?string $writer): array
    {
        if (!$title && !$writer) {
            return [];
        }

        $qb = $this->createQueryBuilder('book');

        if ($title) {
            $qb->andWhere('book.title = :title')
                ->setParameter('title', $title);
        }

        if ($writer) {
            $qb->andWhere('book.writer = :writer')
                ->setParameter('writer', $writer);
        }

        return $qb->getQuery()->getResult();
    }
}
