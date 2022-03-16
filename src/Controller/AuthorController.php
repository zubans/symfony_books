<?php

namespace App\Controller;

use App\Entity\Author;
use App\Service\AuthorService;
use App\Service\Exceptions\TokenException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController
{
    /**
     * @throws TokenException
     * @throws \Exception
     */
    public function create(Request $request, ManagerRegistry $manager): JsonResponse
    {
        $authorReq = new AuthorService(json_decode($request->getContent(), true));

        if (!empty($manager->getRepository(Author::class)->findOneBy(['name' => $authorReq->getName()]))) {
            throw new \Exception('This author already exist');
        }

        $author = new Author;
        $author->setName($authorReq->getName());

        $bookRepo = $manager->getRepository(Author::class);
        $bookRepo->add($author);

        return new JsonResponse('ok');
    }
}
