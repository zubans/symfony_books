<?php

namespace App\Tests\Functional\Controller;

use App\Controller\BookController;
use App\Service\Exceptions\TokenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookTest extends AbstractBookTest
{
    /**
     * @param $body
     * @param $expectValue
     * @return void
     * @throws TokenException
     * @dataProvider requestBodyCreate
     */
    public function test_createBook($body, $expectValue): void
    {
        $response = (new BookController())->create(
            $this->createMock(TranslatorInterface::class),
            $this->getRepositoryCreateMock(),
            new Request([],[],[],[],[],[], $body)
        );

        $this->assertEquals($expectValue, $response->getContent());

    }

    /**
     * @param $body
     * @param $expectValue
     * @return void
     * @throws TokenException
     * @dataProvider requestBodySearch
     */
    public function test_searchBook($body, $expectValue): void
    {
        $response = (new BookController())->search(
            $this->createMock(TranslatorInterface::class),
            $this->getRepositorySearchMock(),
            new Request([],[],[],[],[],[], $body)
        );

        $this->assertEquals($expectValue, $response->getContent());
    }

    /**
     * @return array
     *
     */
    public function requestBodyCreate(): array
    {
        return [
            'success' => [
                '{"title": "test1|тест", "author": "Ivanov", "token": "BMvBP+F1VrbhGx0zpCIdnSpfLtoeFyN4MdYQdgv30RKAL+jE1gb/5llFJLaRcdANFmew9hiydw58LWXmrmZ0FA=="}',
                '"ok"'
                ],
            ];
    }

    /**
     * @return array
     *
     */
    public function requestBodySearch(): array
    {
        return [
            'success' => [
                '{"title": "test|тест", "token": "BMvBP+F1VrbhGx0zpCIdnSpfLtoeFyN4MdYQdgv30RKAL+jE1gb/5llFJLaRcdANFmew9hiydw58LWXmrmZ0FA=="}',
                '{"id":"123","Name":"test book"}'
            ],
        ];
    }
}
