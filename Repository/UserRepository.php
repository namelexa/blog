<?php

declare(strict_types=1);

namespace App\Check\Repository;

use App\Check\Model\User;

class UserRepository extends Repository
{
    protected string $table = 'user';

    public function add($email, $hashedPassword): int
    {
        $query = 'INSERT INTO user (email, password) VALUES (:email, :password)';
        $params = ['email' => $email, 'password' => $hashedPassword];
        return $this->save($query, $params);
    }

    public function getUser(string $email): bool|User
    {
        $params = ['email' => $email];
        return $this->get(User::class, $params, \PDO::FETCH_OBJ);
    }
}