<?php

declare(strict_types=1);

namespace App\Check\Controller;

use App\Check\Repository\PostRepository;

class Home extends AbstractController
{
    protected string $title = 'Home Page';
    protected array $posts = [];

    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function execute(): void
    {
        try {
            //TODO check request for security

            $page = $this->getSanitizedParams('page') ?: 1;
            show($page);
            $this->posts = $this->getAllPosts((int)$page);

            $this->renderView('/home');
        } catch (\RuntimeException $e) {
            // TODO change error message to user friendly
            throw new \RuntimeException($e->getMessage());
        }
    }

    private function getAllPosts(int $page): array
    {
        return $this->postRepository->getAllPosts($page);
    }
}