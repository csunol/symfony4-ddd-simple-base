<?php

namespace App\Domain\Book\Entity;

/**
 * Class Book
 * @package App\Domain\Book
 */
class Book
{
    /** @var integer */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $writer;

    public function __construct(string $title, string $writer)
    {
        $this->title = $title;
        $this->writer = $writer;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getWriter(): string
    {
        return $this->writer;
    }

    public function setWriter(string $writer): void
    {
        $this->writer = $writer;
    }
}
