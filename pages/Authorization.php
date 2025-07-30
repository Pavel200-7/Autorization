<?php
session_start();

$errors = $_SESSION['errors'] ?? null;
$success_message = $_SESSION['success_message'] ?? null;
$formData = $_SESSION['formData'] ?? null;

function getSuccessMessageAndDropSessionData(?string $message): string
{
    dropSessionData();
    return "<h1 class='success'>" . htmlspecialchars($message) . "</h1>";
}

function dropSessionData(): void
{
    $_SESSION['errors'] = null;
    $_SESSION['success_message'] = null;
    $_SESSION['formData'] = null;
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/form.css">
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <script src="/js/redirectToIndex.js"></script>
</head>
<body>
<div class="block">
</div>
<div class="block">
    <div class="form">
        <form action="/src/Controllers/AuthorizationController/Authorization.php" method="post"
              class="form__container">

            <?php if (isset($success_message['page'])):   ?>
                <?= getSuccessMessageAndDropSessionData($success_message['page']) ?>
                <script>redirectToIndexIn3Sec()</script>
            <?php endif; ?>

            <h1>Авторизация</h1>

            <div class="form-group">
                <label for="email">Email:</label>

                <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>

                <input type="email" id="email" name="email" placeholder="Введите ваш email" class="form__element"
                       minlength="3" maxlength="255" value="<?= $formData['email'] ?? ''?>">
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>

                <?php if (isset($errors['password'])) echo "<p class='error'>{$errors['password']}</p>"; ?>

                <input type="password" id="password" name="password" placeholder="Введите ваш пароль"
                       class="form__element" minlength="6" maxlength="30" value="<?= $formData['password'] ?? ''?>">
            </div>

            <div class="form-group">

                <?php if ($errors['captcha']) echo "<p class='error'>{$errors['captcha']}</p>"; ?>

                <div
                        id="captcha-container"
                        class="smart-captcha"
                        data-sitekey="ysc1_JxmaTDmEfaPbC6hWxarYNiDPmQcHZp7K1Zqpscxd05feebcc"
                ></div>
            </div>

            <input type="submit" class="form__button" value="Авторизоваться">

        </form>
        <a href="/index.php">Главная</a>
        <a href="/pages/Registration.php">Регистрация</a>
    </div>
</div>
</body>
</html>
