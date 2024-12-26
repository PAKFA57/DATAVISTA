
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataVista</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background: linear-gradient(90deg,rgb(92, 92, 92), #000000); 
            color: #fff;
            padding: 20px 0;
            width: 100%;
        }

        .header__wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto; 
            padding: 0 20px;
        }

        .header__logo a {
            text-decoration: none;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .header__menu-left ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex; 
        }

        .header__menu-left ul li {
            margin-right: 20px;
        }

        .header__menu-left ul li a {
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }

        .header__menu-left ul li a:hover {
            color: #ffcc00;
        }

        .header__menu-right ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .header__menu-right ul li {
            margin-left: 20px;
        }

        .header__menu-right ul li a {
            text-decoration: none;
            color: #fff;
            transition: color 0.3s ease;
        }

        .header__menu-right ul li a:hover {
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header__wrap">

            <div class="header__logo">
                <a href="index.php">DataVista</a>
            </div>

            <div class="header__menu-left">
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="solutions.php">Решения</a></li>
                    <li><a href="news.php">Новости</a></li>
                    <li><a href="contacts.php">Контакты</a></li>
                </ul>
            </div>

            <div class="header__menu-right">
                <ul>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="logout.php">Выход</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Вход</a></li>
                        <li><a href="register.php">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>
</body>
</html>
