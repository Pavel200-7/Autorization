<?php
session_start();

$errors = $_SESSION['errors'] ?? [];
$success_message = $_SESSION['success_message'] ?? '';
$formData = $_SESSION['formData'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/registration.css">
</head>
<body>
<div class="block">
</div>
<div class="block">
    <div class="form">
        <form action="/src/Controllers/RegistrationController/Registration.php" method="post"
              class="form__container">
            <?php if (mb_strlen($success_message) !== 0): ?>
                <?php
                $_SESSION['errors'] = [];
                $_SESSION['success_message'] = '';
                $_SESSION['formData'] = null;
                ?>
                <h1 class='success'><?=$success_message?></h1>
                <script>
                    setTimeout(function() {
                        window.location.href = "/index.php";
                    }, 3000);
                </script>
            <?php endif; ?>
            <h1>Авторизация</h1>

            <div class="form-group">
                <label for="email">Email:</label>
                <?php
                if (!empty($errors['email'])) {
                    echo "<p class='error'>{$errors['email']}</p>";
                }
                ?>
                <input type="email" id="email" name="email" placeholder="Введите ваш email" class="form__element"
                       minlength="3" maxlength="255" value="<?= $formData['email'] ?? ''?>">
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <?php
                if (!empty($errors['password'])) {
                    echo "<p class='error'>{$errors['password']}</p>";
                }
                ?>
                <input type="password" id="password" name="password" placeholder="Введите ваш пароль"
                       class="form__element" minlength="6" maxlength="30" value="<?= $formData['password'] ?? ''?>">
            </div>
            <input type="submit" class="form__button" value="Авторизоваться">
        </form>
        <a href="/index.php">Главная</a>
        <a href="/pages/Registration.php">Регистрация</a>
    </div>
</div>
<script src="https://unpkg.com/imask"></script>
<script src="/js/PhoneMask.js" defer></script>

</body>
</html>
