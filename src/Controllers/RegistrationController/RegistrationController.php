<?php

namespace App\Controllers\RegistrationController;

use App\Controllers\AbstractController;
use App\Entities\User;
use App\Services\UserValidatorReg;


class RegistrationController extends AbstractController
{
    public function register(?string $name, ?string $phone, ?string $email, ?string $password, ?string $confirmPassword): void
    {
        $User = new User();
        $User->setName($name);
        $User->setPhone($phone);
        $User->setEmail($email);
        $User->setPassword($password);
        $User->setConfirmPassword($confirmPassword);

        $validator = new UserValidatorReg();
        $validator->validate($User);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($User, $errors);
        } else {
            $this->userDB->createUserFromObject($User);
            $successMessage = $this->successMessage->getSeccessMessagePage('Авторизация прошла успешно.');
            $this->redirectBack($User, $errors, $successMessage);
        }
    }

    public function redirectBack(User $user, array $errors, $successMessage = null): void
    {
        $_SESSION['errors'] = empty($errors) ? null : $errors;
        $_SESSION['success_message'] = $successMessage;
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