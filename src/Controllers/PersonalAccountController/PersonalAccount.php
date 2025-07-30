<?php

require_once dirname(__DIR__, 2) . '/bootstrap.php';

use \App\Controllers\PersonalAccountController\PersonalAccountController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $operationType = $_POST['operation_type'] ?? null;
    $userId = $_SESSION['userId'] ?? null;

    $personalAccountController = new PersonalAccountController();

    switch ($operationType) {
        case 'name':
            $name = $_POST['name'];
            $personalAccountController->changeName($name, $userId);
            break;
        case 'phone':
            $phone = $_POST['phone'];
            $personalAccountController->changePhone($phone, $userId);
            break;
        case 'email':
            $email = $_POST['email'];
            $personalAccountController->changeEmail($email, $userId);
            break;
        case 'password':
            $password = $_POST['password'];
            $passwordConfirm = $_POST['confirm_password'];
            $personalAccountController->changePassword($password, $passwordConfirm, $userId);
            break;
        default:
            header("Location: /pages/PersonalAccount.php");
            break;
    }

}


