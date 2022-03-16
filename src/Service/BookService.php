<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use App\Service\Exceptions\TokenException;

class BookService extends AbstractService implements Fields
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $author;

    /**
     * @var string
     */
    private string $locale;

    /**
     * @throws TokenException
     */
    public function __construct(array $request, string $locale)
    {
        parent::__construct();

        $this->validate($request);
        $this->title = $request[self::TITLE];
        $this->author = $request[self::AUTHOR] ?? '';
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->localizeTitle($this->title, $this->locale);
    }

    /**
     * @param string $title
     * @param string $locale
     * @return string
     */
    public function localizeTitle(string $title, string $locale): string
    {
        if (!strpos($title, '|')) {
            $this->logger->alert($title . " doesn't have locale");
            return $title;
        }

        $title = explode('|',$title);

        return $locale === 'en' ? $title[0] : $title[1];
    }

    /**
     * @throws TokenException
     */
    protected function validate(array $request): void
    {
        $validator = Validation::createValidator();
        $validator->validate(
            $request,
            [
                new Assert\NotBlank(),
                new Assert\Collection(
                    [
                        self::TOKEN  => [new Assert\NotBlank(), new Assert\Type('string')],
                        self::TITLE  => [new Assert\NotBlank(), new Assert\Type('string')],
                        self::AUTHOR => [new Assert\NotBlank(), new Assert\Type('string')],
                    ])
            ]
        );

        if (!$this->checkToken($request) && $_ENV['TOKEN_ENABLED']) {
            //todo it should be in exception class
            $this->logger->alert('wrong token in request ' . serialize($request));
            throw new TokenException('Something wrong with request');
        }
    }
}
