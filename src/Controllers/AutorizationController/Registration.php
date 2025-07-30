<?php

namespace App\Controllers\RegistrationController;

require_once dirname(__DIR__, 2) . '/bootstrap.php';

use App\Controllers\RegistrationController\RegistrationController;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();
    $_SESSION['errors'] = [];

    $name = htmlspecialchars($_POST['name'] ?? null);
    $phone = htmlspecialchars($_POST['phone'] ?? null);
    $email = htmlspecialchars($_POST['email'] ?? null);
    $password = htmlspecialchars($_POST['password'] ?? null);
    $confirmPassword = htmlspecialchars($_POST['confirm_password'] ?? null);

    $registration = new RegistrationController();
    $registration->register($name, $phone, $email, $password, $confirmPassword);
}





