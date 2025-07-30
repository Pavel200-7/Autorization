<?php

namespace App\Services;

require_once dirname(__DIR__) . '/bootstrap.php';

use App\DataBase\UserDB;
use App\Entities\User;

class UserValidator
{
    private UserDB $userDB;

    private array $errors;
    private array $bannedNames;

    public function __construct()
    {
        $this->userDB = new UserDB();
        $this->errors = [];
        $this->bannedNames = [
            "admin",
            "moderator",
        ];
    }

    public function validate(User $user): void
    {
        $this->validateName($user->getName());
        $this->validatePhone($user->getPhone());
        $this->validateEmail($user->getEmail());
        $this->validatePassword($user->getPassword(), $user->getConfirmPassword());
    }

    private function validateName(string $name): void
    {
        $length = mb_strlen($name);
        if ($length < 3 || $length > 64) {
            $this->errors['name'] = 'Имя может иметь длину от 3 до 64 символов.';
            return;
        }

        $pattern =  '/^[a-zA-Z][a-zA-Z0-9-]*$/i';
        if (!preg_match($pattern, $name)) {
            $this->errors['name'] = 'Имя содержит недопустимые символы или не соответствует правилам (только латинские буквы и цифры).';
            return;
        }

        if(array_search(strtolower($name), $this->bannedNames) !== false) {
            $this->errors['name'] = 'данное имя не может быть использовано.';
            return;
        }

        if ($this->userDB->getUserByName($name) !== false) {
            $this->errors['name'] = 'Данное имя уже занято.';
            return;
        }

    }

    private function validatePhone(string $phone): void
    {
        $pattern = '/^(\+7|8)?[\s-]?\(?\d{3}\)?[\s-]?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/';;
        if (!preg_match($pattern, $phone)) {
            $this->errors['phone'] = 'Некорректный формат номера телефона.';
            return;
        }

        if ($this->userDB->getUserByPhone($phone) !== false) {
            $this->errors['phone'] = 'Данный номер уже занят.';
            return;
        }
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Некорректный формат электронной почты.';
            return;
        }

        if ($this->userDB->getUserByPhone($email) !== false) {
            $this->errors['email'] = 'Данная почта уже занята.';
            return;
        }
    }

    private function validatePassword(string $password, string $confirmPassword): void
    {
        $pattern = '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/';
        if (!preg_match($pattern, $password)) {
            $this->errors['password'] = 'Пароль должен состоять из последовательности длинной от 6 символов, содержащей строчные и прописные латинские буквы, хотя бы одно число и спец символ.';
            return;
        }

        if ($password !== $confirmPassword) {
            $this->errors['password'] = 'Пароли не совпадают.';
            return;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}