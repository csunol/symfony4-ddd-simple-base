<?php

namespace App\Application\Query\Book;

/**
 * Class FindBookQuery
 * @package App\Application\Query\Book
 */
class FindBookQuery
{
    /** @var string|null */
    private $title;
    /** @var string|null */
    private $writer;

    public function __construct(?string $title, ?string $writer)
    {
        $this->title = $title;
        $this->writer = $writer;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getWriter(): ?string
    {
        return $this->writer;
    }
}
