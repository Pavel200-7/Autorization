<?php

namespace App\Services;

use App\DataBase\UserDB;
use App\Services\CaptchaValidator;
use App\Entities\User;

class UserValidatorAut
{
    private UserDB $userDB;
    private CaptchaValidator $captchaValidator;
    private array $errors;

    public function __construct()
    {
        $this->userDB = new UserDB();
        $this->captchaValidator = new CaptchaValidator();
        $this->errors = [];
    }

    public function validate(User $user): void
    {
        $this->validateEmail($user->getEmail());
        $this->validatePassword($user->getPassword(), $user->getEmail());
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Некорректный формат электронной почты.';
            return;
        }

        if ($this->userDB->getUserByEmail($email) === false) {
            $this->errors['email'] = 'Данная почта не найдена.';
            return;
        }
    }

    private function validatePassword(string $password, string $email): void
    {
        $correctPassword = $this->userDB->getPasswordByEmail($email);
        if (!password_verify($password, $correctPassword)) {
            $this->errors['password'] = 'Неверный пароль.';
            return;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function checkCaptcha($captchaToken): void
    {
        if (!$this->captchaValidator->check_captcha($captchaToken))
        {
            $this->errors['captcha'] = 'Пройдите проверку на робота.';
            return;
        }
    }


}