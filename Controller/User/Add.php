<?php

declare(strict_types=1);

namespace App\Check\Controller\User;

use App\Check\Controller\AbstractController;
use App\Check\Repository\UserRepository;
use Throwable;

class Add extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function execute(): void
    {
        if (!$this->validateRequestType(self::POST)) {
            // TODO handle error message;
            exit('Wrong request type');
        }

        try {
            $this->addNewUser('test@test.com', 'sadf');
        } catch (Throwable $e) {
            throw new \Exception('Failed to add user');
        }
    }

    public function addNewUser($email = 'test@test.com', $password = 'sadf'): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userRepository->add($email, $hashedPassword);
    }
}