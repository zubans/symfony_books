<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractService
{
    private const CRYPT_ALGORITHM = 'aes-128-ecb';

    public Logger $logger;

    public ValidatorInterface $validator;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->validator = Validation::createValidator();

    }

    abstract protected function validate(array $request);

    /**
     * @param array $request
     * @return bool
     */
    protected function checkToken(array $request): bool
    {
        //here we need very strong encryption with salt. Only like example
        $token = $request['token'];
        unset($request['token']);
        return openssl_encrypt(json_encode($request),self::CRYPT_ALGORITHM, $_ENV['SALT']) === $token;
    }

}
