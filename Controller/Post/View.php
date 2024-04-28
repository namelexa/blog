<?php

declare(strict_types=1);

namespace App\Check\Controller\Post;

use App\Check\Controller\AbstractController;
use App\Check\Model\Post;
use App\Check\Repository\PostRepository;

class View extends AbstractController
{
    protected Post $post;

    public function __construct(
        private readonly PostRepository $postRepository
    ) {
        // TODO check request type
        if (!isset($_GET['id'])) {
            exit('There is no post with this id');
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);

        $id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
        try {
            $this->post = $this->postRepository->getPostById((int)$id);

            $this->renderView($_SERVER['REQUEST_URI']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function execute(): void
    {
        // TODO: Implement execute() method.
    }
}