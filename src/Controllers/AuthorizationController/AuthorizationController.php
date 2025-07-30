<?php

namespace App\Controllers\AuthorizationController;

use App\Controllers\AbstractController;
use App\Entities\User;
use App\Services\UserValidatorAut;

class AuthorizationController extends AbstractController
{
    public function authorize(?string $email, ?string $password, $captchaToken): void
    {
        $User = new User();
        $User->setEmail($email);
        $User->setPassword($password);

        $validator = new UserValidatorAut();
        $validator->validate($User);
        $validator->checkCaptcha($captchaToken);

        if (!empty($errors = $validator->getErrors())) {
            $this->redirectBack($User, $errors);
        } else {
            $this->authorizeUser($User);
            $successMessage = $this->successMessage->getSeccessMessagePage('Авторизация прошла успешно');
            $this->redirectBack($User, $errors, $successMessage);
        }
    }

    private function authorizeUser(User $user): void
    {
        $userId = $this->userDB->getUserIdByEmail($user->getEmail());
        $_SESSION['userId'] = $userId;
    }

    public function redirectBack(User $user, array $errors, array $successMessage = null): void
    {
        $_SESSION['errors'] = empty($errors) ? null : $errors;
        $_SESSION['success_message'] = $successMessage;
        $_SESSION['formData'] = $this->getFormDataIfItCorrect($errors, $user);

        header('Location: /pages/Authorization.php');
        exit();
    }

    private function getFormDataIfItCorrect(array $errors, User $user): array
    {
        $formData = array();
        $formData['email'] = isset($errors['email']) ? '' : $user->getEmail();
        $formData['password'] = isset($errors['password']) ? '' : $user->getPassword();
        return $formData;
    }
}