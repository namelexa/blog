<?php

declare(strict_types=1);

namespace App\Check\Controller\Post;

use App\Check\Controller\AbstractController;
use App\Check\Repository\PostRepository;

class Save extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function execute(): void
    {
        if (!$this->validateRequestType(self::POST)) {
            // TODO handle error message;
            exit('Wrong request type');
        }

        $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        $authorId = $this->getSession()['user_id'];

        try {
            $this->postRepository->add((int)$_POST['postId'], $authorId, $title, $content);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}