<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AbstractBookTest extends TestCase
{
    /**
     * @return ManagerRegistry|MockObject
     */
    protected function getRepositoryCreateMock(): MockObject|ManagerRegistry
    {
        $author = (new Author())->setName('IvanovV');

        $serviceAuthorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $serviceAuthorRepository->method('findOneBy')->willReturn($author);

        $serviceBookRepository = $this->getMockBuilder(BookRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceBookRepository->method('findOneBySubTitle')->willReturn([]);

        $addBookRepository = $this->getMockBuilder(BookRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->onConsecutiveCalls($serviceAuthorRepository, $serviceBookRepository, $addBookRepository));

        return $stub;
    }

    protected function getRepositorySearchMock()
    {
        $serviceBookRepository = $this->getMockBuilder(BookRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $serviceBookRepository->method('findOneBySubTitle')->willReturn([['id' => '123', 'title' => 'test book']]);

        $stub = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub
            ->expects($this->any())
            ->method('getRepository')
            ->willReturn($serviceBookRepository);

        return $stub;
    }
}
