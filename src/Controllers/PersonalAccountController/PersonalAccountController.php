<?php

namespace App\Controllers\PersonalAccountController;

use App\Controllers\AbstractController;
use App\Services\UserValidatorReg;
use JetBrains\PhpStorm\NoReturn;

class PersonalAccountController extends AbstractController
{
    public function changeName(string $name, int $userId): void
    {
        $validator = new UserValidatorReg();
        $validator->validateName($name);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($errors);
        } else {
            $this->userDB->changeUserName($name, $userId);
            $successMessage = $this->successMessage->getSeccessMessageName('Имя пользователя было изменено.');
            $this->redirectBack($errors,$successMessage);
        }
    }


    public function changePhone(string $phone, int $userId): void
    {
        $validator = new UserValidatorReg();
        $validator->validatePhone($phone);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($errors);
        } else {
            $this->userDB->changeUserPhone($phone, $userId);
            $successMessage = $this->successMessage->getSeccessMessagePhone('Телефон был изменен.');
            $this->redirectBack($errors,$successMessage);
        }
    }


    public function changeEmail(string $email, int $userId): void
    {
        $validator = new UserValidatorReg();
        $validator->validateEmail($email);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($errors);
        } else {
            $this->userDB->changeUserEmail($email, $userId);
            $successMessage = $this->successMessage->getSeccessMessageEmail('Почта была изменена.');
            $this->redirectBack($errors, $successMessage);
        }
    }


    public function changePassword(string $password, $confirmPassword, int $userId): void
    {
        $validator = new UserValidatorReg();
        $validator->validatePassword($password, $confirmPassword);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($errors);
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->userDB->changeUserPassword($password, $userId);
            $successMessage = $this->successMessage->getSeccessMessagePassword('Пароль был изменен.');
            $this->redirectBack($errors, $successMessage);
        }
    }

    #[NoReturn]
    public function redirectBack(array $errors, array $successMessage = null): void
    {
        $_SESSION['errors'] = empty($errors) ? null : $errors;
        $_SESSION['success_message'] = $successMessage;
        header('Location: /pages/PersonalAccount.php');
        exit();
    }
}