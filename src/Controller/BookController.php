<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Service\BookService;
use App\Service\Exceptions\TokenException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookController extends AbstractController
{
    /**
     * @throws TokenException|\Exception
     */
    #[Route('/book/create', name: 'app_book', methods: ['POST'])]
    public function create(TranslatorInterface $translator, ManagerRegistry $manager, Request $request): JsonResponse
    {
        $bookReq = new BookService(json_decode($request->getContent(), true), $translator->getLocale());

        if (is_null($manager->getRepository(Author::class)->findOneBy(['name' => $bookReq->getAuthor()]))) {
            throw new \Exception('please create or use exist author');
        }

        if (!empty($manager->getRepository(Book::class)->findOneBySubTitle($bookReq->getTitle()))) {
            throw new \Exception('This book already exist');
        }

        $book = new Book();
        $book->setTitle($bookReq->getTitle());

        $bookRepo = $manager->getRepository(Book::class);
        $bookRepo->add($book);

        return new JsonResponse('ok');
    }

    /**
     * @throws TokenException|\Exception
     */
    #[Route('/book/search', name: 'app_book', methods: ['POST'])]
    public function search(TranslatorInterface $translator, ManagerRegistry $manager, Request $request): JsonResponse
    {
        $bookReq = new BookService(json_decode($request->getContent(), true), $translator->getLocale());

        if (empty($book = $manager->getRepository(Book::class)->findOneBySubTitle($bookReq->getTitle()))) {
            throw new \Exception('this book does not exist ');
        }

        return new JsonResponse([
            'id' => $book[0]['id'],
            'Name' => $bookReq->localizeTitle($book[0]['title'], $translator->getLocale())
        ]);
    }
}
