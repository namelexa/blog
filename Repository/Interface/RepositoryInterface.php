<?php

declare(strict_types=1);

namespace App\Check\Repository\Interface;

interface RepositoryInterface
{
    public function save(string $query, array $params): int;

    public function getList(string $class, int $page, int $limit = 0, int $offset = 0): array;

    public function getById(string $class, int $id): object;

    public function get(string $class, array $params, int $fetchType = \PDO::FETCH_CLASS): bool|object;
}