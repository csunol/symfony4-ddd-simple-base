<?php

namespace App\Application\Query\Book;

use App\Domain\Book\Repository\BookRepositoryInterface;

/**
 * Class FindBookQueryHandler
 * @package App\Application\Query\Book
 */
class FindBookQueryHandler
{
    /** @var BookRepositoryInterface */
    private $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle(FindBookQuery $findBookQuery): array
    {
        return $this->bookRepository->findBooks($findBookQuery->getTitle(), $findBookQuery->getWriter());
    }
}
