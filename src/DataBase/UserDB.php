<?php

namespace App\DataBase;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use App\DataBase\DataBase;
use App\Entities\User;
use PDO;

class UserDB extends DataBase
{
    public function createUserFromObject(User $User)
    {
        $query = "INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $User->getName());
        $stmt->bindValue(':phone', $User->getPhone());
        $stmt->bindValue(':email', $User->getEmail());
        $hashedPassword = password_hash($User->getPassword(), PASSWORD_DEFAULT);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->execute();
    }

    public function createUser(string $name, string $phone, string $email, string $password)
    {
        $query = "INSERT INTO users (name, phone, email, password) VALUES (:name, :phone, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':email', $email);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->execute();
    }

    public function getUsers()
    {
        $query = "SELECT * FROM users";
        $statement = $this->pdo->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserById(int $id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':id' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserByName(string $name)
    {
        $query = "SELECT * FROM users WHERE name = :name";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':name' => $name]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserByPhone(string $phone)
    {
        $query = "SELECT * FROM users WHERE phone = :phone";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':phone' => $phone]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUserByEmail(string $email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':email' => $email]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


}
