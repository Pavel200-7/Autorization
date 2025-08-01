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
    <title>Регистрация</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/form.css">
    <script src="https://unpkg.com/imask"></script>
    <script src="/js/PhoneMask.js" defer></script>
    <script src="/js/redirectToIndex.js"></script>
</head>
<body>
<div class="block">
</div>
<div class="block">

    <div class="form">
        <form action="/src/Controllers/RegistrationController/Registration.php" method="post"
              class="form__container">

            <?php if (isset($success_message['page'])): ?>
                <?= getSuccessMessageAndDropSessionData($success_message['page']) ?>
                <script>redirectToIndexIn3Sec()</script>
            <?php endif; ?>

            <h1>Регистрация</h1>

            <div class="form-group">
                <label for="name">Имя:</label>

                <?php if (isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>

                <input type="text" id="name" name="name" placeholder="Введите ваше имя" class="form__element"
                       minlength="3" maxlength="64" value="<?= $formData['name'] ?? ''?>">
            </div>

            <div class="form-group">
                <label for="phone">Телефон:</label>

                <?php if (isset($errors['phone'])) echo "<p class='error'>{$errors['phone']}</p>"; ?>

                <input type="tel" id="phone" name="phone" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,11}$" placeholder="+7 (000) 000-00-00"
                       class="form__element" minlength="11" maxlength="19" value="<?= $formData['phone'] ?? '' ?>">
            </div>

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
                <label for="confirm_password">Подтвердить пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       placeholder="Подтвердите ваш пароль" class="form__element" minlength="6" maxlength="30">
            </div>

            <input type="submit" class="form__button" value="Зарегистрироваться">
        </form>

        <a href="/index.php">Главная</a>
        <a href="/pages/Authorization.php">Авторизация</a>
    </div>
</div>



</body>
</html>
