<?php

namespace App\Application\Command\Book;

use App\Domain\Book\Entity\Book;
use App\Domain\Book\Repository\BookRepositoryInterface;

/**
 * Class CreateBookCommandHandler
 * @package App\Application\UseCase\Book
 */
class CreateBookCommandHandler
{
    /** @var BookRepositoryInterface */
    private $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(CreateBookCommand $createBookCommand): void
    {
        $book = new Book(
            $createBookCommand->getTitle(),
            $createBookCommand->getWriter()
        );

        $this->bookRepository->saveBook($book);
    }
}
