<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Регистрация нового пользователя в системе DataVista.">
    <link rel="stylesheet" href="assets/css/register-style.css">
    <title>Регистрация | DataVista</title>
</head>
<body>

<?php include 'header.php'; ?>

<form method="POST">
    <div class="registration-form1">
        <h2>Регистрация</h2>
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
        <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>
</form>

<?php include 'footer.php'; ?>

</body>
</html>
