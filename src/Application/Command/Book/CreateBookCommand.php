<?php

namespace App\Application\Command\Book;

/**
 * Class CreateBookCommand
 * @package App\Application\UseCase\Book
 */
class CreateBookCommand
{
    /** @var string */
    private $title;
    /** @var string */
    private $writer;

    public function __construct(string $title, string $writer)
    {
        $this->title = $title;
        $this->writer = $writer;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getWriter(): string
    {
        return $this->writer;
    }
}
