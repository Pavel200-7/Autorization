<?php
session_start();
$userId = $_SESSION['userId'] ?? null;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Главная</title>
    <link rel="stylesheet" href="/styles/main.css">
  </head>
  <body>
    <h1>Вы находитесь на главной странице</h1>
    <div class="block">
        <a class="link registration-link" href="pages/Registration.php">Регистрация</a>
        <a class="link autorization-link" href="pages/Authorization.php">Авторизация</a>
    </div>
    <?php if (isset($userId)): ?>
        <div class="block">
            <a class="link personal-account-link" href="pages/PersonalAccount.php"> Личный кабинет</a>
        </div>
    <?php endif; ?>
  </body>
</html>
