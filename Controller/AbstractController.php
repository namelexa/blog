<?php

declare(strict_types=1);

namespace App\Check\Controller;

abstract class AbstractController
{
    protected const string GET = 'GET';
    protected const string POST = 'POST';

    protected string $title = '';
    protected string $template = '';
    protected string $content = '';
    protected array $messages = [];
    protected array $session = [];

    abstract public function execute(): void;

    protected function renderView($path): void
    {
        try {
            $filename = 'view' . parse_url($path, PHP_URL_PATH) . '.php';

            show($filename);
            if (!file_exists($filename)) {
                $filename = 'view/page_not_found.php';
            }
            $this->setTemplate($filename);

            ob_start();
            require_once $filename;
            $this->setContent(ob_get_clean());
            require_once('view/default_template.php');
        } catch (\Exception $e) {
            throw new \Exception('Template can\'t be rendered');
        }
    }

    protected function validateRequestType($type): bool
    {
        return $type === $_SERVER['REQUEST_METHOD'];
    }

    protected function isLoggedIn(): bool
    {
        return $_SESSION['logged_in'] ?? false;
    }

    protected function getSanitizedParams($param): mixed
    {
        $value = filter_input(INPUT_GET, $param, FILTER_SANITIZE_URL);

        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    protected function isAuthor($authorId): bool
    {
        return isset($_SESSION['user_id']) && $authorId === $_SESSION['user_id'];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    public function getSession(): array
    {
        return $this->session;
    }

    public function setSession(array $session): void
    {
        $this->session = $session;
    }

}