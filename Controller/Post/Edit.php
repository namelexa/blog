<?php

declare(strict_types=1);

namespace App\Check\Controller\Post;

use App\Check\Controller\AbstractController;
use App\Check\Model\Post;
use App\Check\Repository\PostRepository;

class Edit extends AbstractController
{
    protected Post $post;

    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function execute(): void
    {
        // TODO check request type
        $requestData = $_POST;

        if (!isset($requestData['postId'], $requestData['authorId'])) {
            exit('You are not authorized to access this page');
        }

        try {
            if (!$this->isAuthor((int)$requestData['authorId'])) {
                exit('You are not authorized to access this page.');
            }

            $this->post = $this->postRepository->getPostById((int)$requestData['postId']);

            $this->renderView($_SERVER['REQUEST_URI']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
