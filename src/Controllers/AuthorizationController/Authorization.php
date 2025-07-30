<?php

require_once dirname(__DIR__, 2) . '/bootstrap.php';

use App\Controllers\AuthorizationController\AuthorizationController;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();
    $_SESSION['errors'] = null;
    $_SESSION['success_message'] = null;
    $_SESSION['formData'] = null;

    $email = htmlspecialchars($_POST['email'] ?? null);
    $password = htmlspecialchars($_POST['password'] ?? null);
    $captchaToken = $_POST["smart-token"] ?? null;

    $authorization = new AuthorizationController();
    $authorization->authorize($email, $password, $captchaToken);
}





