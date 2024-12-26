<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit; 
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь не найден.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Вход в систему DataVista.">
    <title>Вход | DataVista</title>

    <link rel="stylesheet" href="assets/css/login-style.css">
</head>
<body>

<?php include 'header.php'; ?>

<form method="POST">
    <div class="login-form1">
        <h2>Вход</h2>
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
        <p><a href="#">Забыли пароль?</a></p>
        <p><a href="#" onclick="showRegisterForm1()">Зарегистрироваться</a></p>
    </div>
</form>

<div id="registerForm1" class="register-form1">
    <h2>Регистрация</h2>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="assets/js/login-script.js"></script>
</body>
</html>
