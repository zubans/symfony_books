<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $book = new Book();

        $author->setName('Ivanov');
        $book
            ->setTitle('test Title')
            ->setAuthor($author);

        $manager->persist($author);
        $manager->persist($book);

        $manager->flush();
    }
}
