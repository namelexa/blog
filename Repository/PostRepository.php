<?php

declare(strict_types=1);

namespace App\Check\Repository;

use App\Check\Model\Post;

class PostRepository extends Repository
{
    protected string $table = 'post';

    public function add(int $authorId, string $title, string $content): int
    {
        $query = 'INSERT INTO post (authorId, title, content) VALUES (:authorId, :title, :content)';
        $params = ['authorId' => $authorId, 'title' => $title, 'content' => $content];
        return $this->save($query, $params);
    }

    public function getAllPosts($page): array
    {
        return $this->getList(Post::class, $page, 2);
    }

    public function getPostById(int $id): Post
    {
        return $this->getById(Post::class, $id);
    }
}