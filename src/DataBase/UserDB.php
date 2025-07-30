<?php

namespace App\DataBase;

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

    public function getPasswordByEmail(string $email)
    {
        $query = "SELECT password FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':email' => $email]);
        $result = $statement->fetchColumn();
        return $result;
    }

    public function getUserIdByEmail(string $email)
    {
        $query = "SELECT id FROM users WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':email' => $email]);
        $result = $statement->fetchColumn();
        return $result;
    }


    public function changeUserName(string $name, int $userId)
    {
        $query = "Update users SET name = :name WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':name' => $name, ':id' => $userId]);
        return $statement->rowCount() > 0;
    }

    public function changeUserPhone(string $phone, int $userId)
    {
        $query = "Update users SET phone = :phone WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':phone' => $phone, ':id' => $userId]);
        return $statement->rowCount() > 0;
    }

    public function changeUserEmail(string $email, int $userId)
    {
        $query = "Update users SET email = :email WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':email' => $email, ':id' => $userId]);
        return $statement->rowCount() > 0;
    }

    public function changeUserPassword(string $password, int $userId)
    {
        $query = "Update users SET password = :password WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute([':password' => $password, ':id' => $userId]);
        return $statement->rowCount() > 0;
    }
}
