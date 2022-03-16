<?php

namespace App\Service;

use App\Service\Exceptions\TokenException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorService extends AbstractService implements Fields
{

    private string $name;

    /**
     * @throws TokenException
     */
    public function __construct(array $request)
    {
        parent::__construct();

        $this->validate($request);
        $this->name = $request['name'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $request
     * @return void
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
                        self::NAME  => [new Assert\NotBlank(), new Assert\Type('string')],
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
