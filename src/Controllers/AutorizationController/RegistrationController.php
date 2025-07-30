<?php

namespace App\Controllers\RegistrationController;

require_once dirname(__DIR__, 2) . '/bootstrap.php';

use App\DataBase\UserDB;
use App\Entities\User;
use App\Services\UserValidator;


class RegistrationController
{
    private UserValidator $validator;


    public function register(?string $name, ?string $phone, ?string $email, ?string $password, ?string $confirmPassword)
    {
        $User = new User($name, $phone, $email, $password, $confirmPassword);
        $this->validator = new UserValidator();
        $this->validator->validate($User);

        if (!empty($errors = $this->validator->getErrors())) {
            $this->redirectBackWithError($errors, $User);
        } else {
            $UserDB = new UserDB();
            $UserDB->createUserFromObject($User);
            $this->redirectBackWithoutError($errors, $User);
        }
    }

    public function redirectBackWithError(array $errors, User $user)
    {
        $_SESSION['errors'] = $errors;
        $_SESSION['success_message'] = null;
        $_SESSION['formData'] = $this->getFormDataIfItCorrect($errors, $user);
        header('Location: /pages/Registration.php');
        exit();
    }

    public function redirectBackWithoutError(array $errors, User $user)
    {
        $_SESSION['errors'] = $errors;
        $_SESSION['success_message'] = "Регистрация прошла успешно";
        $_SESSION['formData'] = $this->getFormDataIfItCorrect($errors, $user);
        header('Location: /pages/Registration.php');
        exit();
    }

    private function getFormDataIfItCorrect(array $errors, User $user): array
    {
        $formData = array();
        $formData['name'] = isset($errors['name']) ? '' : $user->getName();
        $formData['phone'] = isset($errors['phone']) ? '' : $user->getPhone();
        $formData['email'] = isset($errors['email']) ? '' : $user->getEmail();
        $formData['password'] = isset($errors['password']) ? '' : $user->getPassword();
        return $formData;
    }

}