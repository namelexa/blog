<?php

declare(strict_types=1);

namespace App\Check\Controller\User;

use App\Check\Controller\AbstractController;
use App\Check\Controller\Home;
use App\Check\Core\Router;
use App\Check\Model\User;
use App\Check\Repository\UserRepository;

class LogIn extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Router $router
    ) {
    }

    public function execute(): void
    {
        if (!$this->validateRequestType(self::POST)) {
            // TODO handle error message;
            exit('Wrong request type');
        }

        if (!$_POST && !isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            // TODO handle error message;
            $this->router->messages = ['error' => 'Wrong email or password'];
            $this->router->path = 'Home';
            $this->router->executeController();
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        //TODO move message handling to separate method.
        // Add correct path for home page. Should be empty string or Home
        try {
            if (!$user = $this->userRepository->getUser($email)) {
                $this->router->messages = ['message' => 'Wrong email or password'];
                $this->router->path = 'Home';
                $this->router->executeController();
                exit();
            }

            if (!$this->authenticate($user, $_POST['password'])) {
                $this->router->messages = ['message' => 'Wrong email or password'];
                $this->router->path = 'Home';
                $this->router->executeController();
                exit();
            }

            $_SESSION['email'] = $user->getEmail();
            $_SESSION['user_id'] = (int)$user->getId();
            $_SESSION['logged_in'] = true;

            $this->router->messages = ['message' => 'You have been logged in'];
            $this->router->path = 'Home';
            $this->router->executeController();
        } catch (\Exception $e) {
            throw new \Exception('Cannot log in');
        }
    }

    private function authenticate(User $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}