<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataVista</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@900&family=Open+Sans:wght@600&display=swap');

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: rgb(41, 41, 41); 
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            max-width: 1200px;
            margin-top: 250px; 
            opacity: 0;
            animation: fadeIn 3s forwards;
        }

        .text-container {
            flex: 1;
            text-align: left;
        }

        h1 {
            margin: 0;
            font-size: 8rem;
            font-weight: bold;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
        }

        p {
            margin: 10px 0;
            font-size: 2rem; 
            color: #ffffff; 
        }

        .image-container {
            flex: 0 0 auto;
            margin-left: 30px;
            display: flex;
            align-items: center;
            opacity: 0;
            animation: fadeInImage 4s forwards;
        }

        .image-container img {
            max-width: 350px;
            height: auto;
            border-radius: 15px;
        }

        .button-container {
            position: relative;
            text-align: center;
            width: 100%;
            margin-bottom: 150px; 
            opacity: 0;
            animation: fadeInButton 5s forwards;
        }

        .button {
            display: inline-block;
            padding: 20px 50px;
            font-size: 1.8rem;
            font-family: 'Open Sans', sans-serif;
            color: rgb(14, 14, 14);
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid #ffffff;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, color 0.3s ease;
        }

        .button:hover {
            background-color: #ffffff;
            color: #000000;
            transform: scale(1.1);
        }

        /* Анимации */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInImage {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInButton {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="text-container">
            <h1 id="title"></h1>
            <div id="text"></div>
        </div>
        <div class="image-container">
            <img src="http://localhost/123/images/41241.png">
        </div>
    </div>
    <div class="button-container">
        <a href="index.php" class="button">Перейти на основную страницу</a>
    </div>

    <script>
        const title = "DataVista";
        const text = [
            "Инструменты для анализа данных",
            "Доступные решения для малого бизнеса",
            "Прогнозирование и визуализация",
            "Всё необходимое в одном месте"
        ];

        const titleElement = document.getElementById('title');
        const textElement = document.getElementById('text');

        let charIndex = 0;

        function typeTitle() {
            if (charIndex < title.length) {
                titleElement.textContent += title[charIndex];
                charIndex++;
                setTimeout(typeTitle, 150);
            } else {
                typeText();
            }
        }

        let lineIndex = 0;

        function typeText() {
            if (lineIndex < text.length) {
                const p = document.createElement("p");
                p.textContent = text[lineIndex];
                textElement.appendChild(p);
                lineIndex++;
                setTimeout(typeText, 2000);
            }
        }

        typeTitle();
    </script>
</body>
</html>
