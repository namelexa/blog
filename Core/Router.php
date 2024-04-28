<?php

declare(strict_types=1);

namespace App\Check\Core;

use App\Check\Controller\AbstractController;
use Random\RandomException;

class Router
{
    private const string CONTROLLER_NAMESPACE = '\\App\\Check\\Controller\\';

    public string $path = '';
    public array $messages = [];

    public function executeController(): void
    {
        try {
            $this->startSession();
            $controllerPath = $this->getPath();

            $path = str_replace('/', '\\', $controllerPath);
            $controllerNamespace = self::CONTROLLER_NAMESPACE . $path;

            if (!class_exists($controllerNamespace)) {
                $controllerNamespace = self::CONTROLLER_NAMESPACE . 'PageNotFound';
            }

            $resolver = new ReflectionResolver();
            /** @var $controller AbstractController*/
            $controller = $resolver->resolve($controllerNamespace);
            $controller->setMessages($this->messages);
            $controller->setSession($_SESSION);
            $controller->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function getPath(): string
    {
        if (empty($this->path)) {
            $this->path = $_SERVER['REQUEST_URI'] ? ltrim($_SERVER['REQUEST_URI'], '/') : '';
        }

        $parsedUrl = parse_url($this->path);
        $path = $parsedUrl['path'] ?? '';

        return str_replace('_', '', ucwords($path, '_,/')) ?: 'Home';
    }

    private function startSession(): void
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            // TODO adds token expiry time
        } catch (RandomException $e) {
            throw new RandomException('Error while generating CSRF token');
        }
    }
}
