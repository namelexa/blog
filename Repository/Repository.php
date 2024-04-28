<?php

declare(strict_types=1);

namespace App\Check\Repository;

use App\Check\Core\Database\Connection;
use App\Check\Repository\Interface\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private \PDO $pdoConnection;

    protected string $table = '';

    public function __construct(
        private readonly Connection $connection
    ) {
        $this->pdoConnection = $this->connection->pdoConnection();
    }

    public function save(string $query, array $params): int
    {
        try {
            $this->pdoConnection->beginTransaction();
            $stmt = $this->pdoConnection->prepare($query);
            $stmt->execute($params);
            $this->pdoConnection->commit();
            return (int)$this->pdoConnection->lastInsertId();
        } catch (\PDOException $e) {
            //TODO Handle messages for duplicates, as customer email or post title

            throw new \PDOException($e->getMessage());
        }
    }

    public function getList(string $class, int $page, $limit = 0, int $offset = 0): array
    {
        try {
            $stmt = $this->pdoConnection->prepare(
                'SELECT * FROM ' . $this->table . ' LIMIT :offset, :limit'
            );
            $stmt->execute(['offset' => ($page - 1) * $limit, 'limit' => $limit]);

            return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        } catch (\PDOException $e) {
            //TODO Handle messages for duplicates, as customer email or post title

            throw new \PDOException($e->getMessage());
        }
    }

    public function getById(string $class, int $id): object
    {
        $stmt = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject($class);
    }

    public function get(string $class, array $params, int $fetchType = \PDO::FETCH_CLASS): bool|object
    {
        $whereParams = [];
        $data = null;

        foreach ($params as $param => $value) {
            $whereParams[] = "$param = :$param";
        }

        $whereClause = implode(' AND ', $whereParams);
        $query = "SELECT * FROM $this->table WHERE $whereClause";

        try {
            $stmt = $this->pdoConnection->prepare($query);
            $stmt->execute($params);

            switch ($fetchType) {
                case \PDO::FETCH_CLASS:
                    $data = $stmt->fetchAll($fetchType, $class);
                    break;
                case \PDO::FETCH_OBJ:
                    $data = $stmt->fetchObject($class);
                    break;
                case \PDO::FETCH_ASSOC:
                    $data = $stmt->fetchAll($fetchType);
                    break;
                default:
            }

            return $data;
        } catch (\PDOException $e) {
            throw new \PDOException('Error while getting data from database', (int)$e->getCode());
        }
    }
}
