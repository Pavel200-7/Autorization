<?php
session_start();
$userId = $_SESSION['userId'] ?? null;
$errors = $_SESSION['errors'] ?? null;
$success_message = $_SESSION['success_message'] ?? null;

redirectToIndexIfItUnAuthorized($userId);

function redirectToIndexIfItUnAuthorized(?int $userId): void
{
    if ($userId == null) {
        header("Location: index.php");
    }
}

function getSuccessMessageAndDropSessionData(?string $message): string
{
    dropSessionData();
    return "<h1 class='success'>" . htmlspecialchars($message) . "</h1>";
}

function dropSessionData(): void
{
    $_SESSION['errors'] = null;
    $_SESSION['success_message'] = null;
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/form.css">
</head>
<body>
<div class="block">
    <div class="form">
        <form action="/src/Controllers/PersonalAccountController/PersonalAccount.php" method="post"
              class="form__container form__container_short">

            <?php if (isset($success_message['name'])):   ?>
                <?= getSuccessMessageAndDropSessionData($success_message['name']) ?>
            <?php endif; ?>

            <h1>Изменить имя</h1>

            <div class="form-group">
                <label for="name">Имя:</label>

                <?php if (isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>

                <input type="text" id="name" name="name" placeholder="Введите ваше имя" class="form__element"
                       minlength="3" maxlength="64" value="">
            </div>

            <input type="hidden" name="operation_type" value="name">

            <input type="submit" class="form__button" value="Сменить имя">
        </form>
    </div>

    <div class="form form_shorten">
        <form action="/src/Controllers/PersonalAccountController/PersonalAccount.php" method="post"
              class="form__container form__container_short">

            <?php if (isset($success_message['phone'])):   ?>
                <?= getSuccessMessageAndDropSessionData($success_message['phone']) ?>
            <?php endif; ?>

            <h1>Изменить телефон</h1>

            <div class="form-group">
                <label for="phone">телефон:</label>

                <?php if (isset($errors['phone'])) echo "<p class='error'>{$errors['phone']}</p>"; ?>

                <input type="tel" id="phone" name="phone" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,11}$" placeholder="+7 (000) 000-00-00"
                       class="form__element" minlength="11" maxlength="19" value="">
            </div>

            <input type="hidden" name="operation_type" value="phone">

            <input type="submit" class="form__button" value="Сменить телефон">
        </form>
    </div>

    <div class="form form_shorten">
        <form action="/src/Controllers/PersonalAccountController/PersonalAccount.php" method="post"
              class="form__container form__container_short">

            <?php if (isset($success_message['email'])):   ?>
                <?= getSuccessMessageAndDropSessionData($success_message['email']) ?>
            <?php endif; ?>

            <h1>Изменить email</h1>

            <div class="form-group">
                <label for="email">email:</label>

                <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>

                <input type="email" id="email" name="email" placeholder="Введите ваш email" class="form__element"
                       minlength="3" maxlength="255" value="">
            </div>

            <input type="hidden" name="operation_type" value="email">

            <input type="submit" class="form__button" value="Сменить email">
        </form>
    </div>

    <div class="form form_shorten">
        <form action="/src/Controllers/PersonalAccountController/PersonalAccount.php" method="post"
              class="form__container form__container_short">

            <?php if (isset($success_message['password'])):   ?>
                <?= getSuccessMessageAndDropSessionData($success_message['password']) ?>
            <?php endif; ?>

            <h1>Изменить пароль</h1>
            <div class="form-group">
                <label for="password">Пароль:</label>

                <?php if (isset($errors['password'])) echo "<p class='error'>{$errors['password']}</p>"; ?>

                <input type="password" id="password" name="password" placeholder="Введите ваш пароль"
                       class="form__element" minlength="6" maxlength="30" value="">
            </div>

            <div class="form-group">
                <label for="confirm_password">Подтвердить пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       placeholder="Подтвердите ваш пароль" class="form__element" minlength="6" maxlength="30">
            </div>

            <input type="hidden" name="operation_type" value="password">

            <input type="submit" class="form__button" value="Сменить пароль">
        </form>
    </div>

</div>

<script src="https://unpkg.com/imask"></script>
<script src="/js/PhoneMask.js" defer></script>

</body>
</html>
