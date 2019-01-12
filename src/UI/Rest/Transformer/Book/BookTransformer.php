<?php

namespace App\UI\Rest\Transformer\Book;

use App\Domain\Book\Entity\Book;

/**
 * Class BookTransformer
 * @package App\UI\Rest\Transformer\Book
 */
class BookTransformer
{
    /**
     * @param Book[] $books
     * @return array
     */
    public static function arrayTransform(array $books)
    {
        $transformedBooks = [];
        foreach ($books as $book) {
            $transformedBooks[]= self::transform($book);
        }

        return $transformedBooks;
    }

    public static function transform(Book $book)
    {
        return [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'writer' => $book->getWriter()
        ];
    }
}