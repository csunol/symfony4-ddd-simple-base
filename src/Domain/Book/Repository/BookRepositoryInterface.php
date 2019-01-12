<?php

namespace App\Domain\Book\Repository;

use App\Domain\Book\Entity\Book;

/**
 * Interface BookRepositoryInterface
 * @package App\Domain\Book\Repository
 */
interface BookRepositoryInterface
{
    public function saveBook(Book $book): void;
    public function findBooks(?string $title, ?string $writer): array;
}
