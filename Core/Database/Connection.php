<?php

declare(strict_types=1);

namespace App\Check\Core\Database;
use PDO;
use App\Check\Core\Config;

class Connection
{
    public function pdoConnection(): PDO
    {
        try {
            $dsn = "mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME.";charset=".Config::DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS, $options);
        } catch (\PDOException $e) {
            die($e);
        }

        return $pdo;
    }
}