<?php

namespace App\UI\Rest\Controller\Book;

use App\Application\Command\Book\CreateBookCommand;
use App\Application\Command\Book\CreateBookCommandHandler;
use App\Application\Query\Book\FindBookQuery;
use App\Application\Query\Book\FindBookQueryHandler;
use App\UI\Rest\Transformer\Book\BookTransformer;
use Assert\Assertion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * Class CreateBookController
 * @package App\UI\Controller\Book
 */
class BookController extends AbstractController
{
    /** @var CreateBookCommandHandler */
    private $createBookCommandHandler;

    /** @var FindBookQueryHandler */
    private $findBookQueryHandler;


    public function __construct(
        CreateBookCommandHandler $createBookCommandHandler,
        FindBookQueryHandler $findBookQueryHandler
    ){
        $this->createBookCommandHandler = $createBookCommandHandler;
        $this->findBookQueryHandler = $findBookQueryHandler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route(
     *     "/book/",
     *     name="get_book",
     *     methods={"GET"}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the books"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     type="string",
     *     description="book title"
     * )
     * @SWG\Parameter(
     *     name="writer",
     *     in="query",
     *     type="string",
     *     description="book writer"
     * )
     * @SWG\Tag(name="book")
     */
    public function book(Request $request)
    {
        $title = $request->get('title');
        $writer = $request->get('writer');

        $findBookQuery = new FindBookQuery($title, $writer);

        $book = $this->findBookQueryHandler->handle($findBookQuery);

        return JsonResponse::create(BookTransformer::arrayTransform($book), JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route(
     *     "/book",
     *     name="post_book",
     *     methods={"POST"}
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Book created"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Invalid parameters"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="body",
     *     required=true,
     *     description="book title",
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Parameter(
     *     name="writer",
     *     in="body",
     *     required=true,
     *     description="book title",
     *     @SWG\Schema(type="string")
     * )
     * @SWG\Tag(name="book")
     */
    public function createBook(Request $request)
    {
        $title = $request->get('title');
        $writer = $request->get('writer');

        Assertion::string($title, 'Title must be a string');
        Assertion::string($writer, 'Writer must be a string');

        $createBookCommand = new CreateBookCommand($title, $writer);

        $this->createBookCommandHandler->handle($createBookCommand);

        return JsonResponse::create(null, JsonResponse::HTTP_CREATED);
    }
}
