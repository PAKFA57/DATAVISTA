<?php
session_start();
include 'config.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = null;

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if ($user_id === null) {
    die("Ошибка: пользователь не найден.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_store'])) {
        $store_name = trim($_POST['store_name']);
        if (!empty($store_name)) {
            $stmt = $conn->prepare("INSERT INTO stores (user_id, name) VALUES (?, ?)");
            if (!$stmt) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt->bind_param("is", $user_id, $store_name);
            if (!$stmt->execute()) {
                die("Ошибка выполнения запроса: " . $stmt->error);
            }
            $stmt->close();
        } else {
            echo "Название магазина не может быть пустым.";
        }
    }


    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $csv_file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($csv_file, 'r');
        if ($handle) {
            while (($data = fgetcsv($handle, 1000, ";")) !== false) { // Разделитель точка с запятой
                if (count($data) < 2) {
                    echo "Ошибка: каждая строка CSV должна содержать дату и доход.<br>";
                    continue;
                }
                $date = $data[0];
                $revenue = $data[1];
    
                // Проверка формата даты
                $dateObj = DateTime::createFromFormat('Y-m-d', $date);
                if (!$dateObj) {
                    $dateObj = DateTime::createFromFormat('m/d/Y', $date); // Если дата в формате MM/DD/YYYY
                }
                if ($dateObj) {
                    $date = $dateObj->format('Y-m-d'); // Преобразуем в формат YYYY-MM-DD
                } else {
                    echo "Ошибка: неверный формат даты в CSV.<br>";
                    continue;
                }
    
                $stmt = $conn->prepare("INSERT INTO revenues (store_id, date, revenue) VALUES (?, ?, ?)");
                if (!$stmt) {
                    die("Ошибка подготовки запроса: " . $conn->error);
                }
                $stmt->bind_param("iss", $store_id, $date, $revenue);
                if (!$stmt->execute()) {
                    echo "Ошибка выполнения запроса: " . $stmt->error . "<br>";
                }
            }
            fclose($handle);
        } else {
            echo "Не удалось открыть файл CSV.";
        }
    } else {
        echo "Ошибка загрузки файла: " . $_FILES['csv_file']['error'];
    }
    


    if (isset($_POST['delete_store'])) {
        $store_id = intval($_POST['store_id']);


        $stmt = $conn->prepare("SELECT id FROM stores WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $store_id, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            die("Ошибка: магазин не найден или у вас нет прав на его удаление.");
        }
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM revenues WHERE store_id = ?");
        if (!$stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt->bind_param("i", $store_id);
        if (!$stmt->execute()) {
            die("Ошибка выполнения запроса: " . $stmt->error);
        }
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM stores WHERE id = ?");
        if (!$stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt->bind_param("i", $store_id);
        if (!$stmt->execute()) {
            die("Ошибка выполнения запроса: " . $stmt->error);
        }
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT id, name FROM stores WHERE user_id = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stores = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Управление магазинами и загрузка данных.">
    <title>Панель управления | DataVista</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="dashboard-container1">
    <h1>Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</h1>

    <div class="dashboard-section1">
        <h2 onclick="toggleSection1('storeSection1')">Ваши магазины</h2>
        <div id="storeSection1" class="collapsed1">
            <table class="dashboard-table1">
                <thead>
                    <tr>
                        <th>Название магазина</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stores as $store): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($store['name']); ?></td>
                            <td>
                                <form method="POST" enctype="multipart/form-data" class="dashboard-form1" style="display:inline;">
                                    <input type="hidden" name="store_id" value="<?php echo $store['id']; ?>">
                                    <input type="file" name="csv_file" required>
                                    <button type="submit" name="upload_csv">Загрузить данные</button>
                                </form>
                                <form method="POST" class="dashboard-form1" style="display:inline;">
                                    <input type="hidden" name="store_id" value="<?php echo $store['id']; ?>">
                                    <button type="submit" name="delete_store" class="delete-button1">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="dashboard-section1">
        <h2 onclick="toggleSection1('newStoreSection1')">Добавить новый магазин</h2>
        <div id="newStoreSection1" class="collapsed1">
            <form method="POST" class="dashboard-form1">
                <input type="text" name="store_name" placeholder="Название магазина" required>
                <button type="submit" name="new_store">Добавить</button>
            </form>
        </div>
    </div>

    <div class="dashboard-section1">
        <h2 onclick="toggleSection1('storeAnalysisSection1')">Выберите магазин для анализа</h2>
        <div id="storeAnalysisSection1" class="collapsed1">
            <form id="storeForm1" class="dashboard-form1">
                <select id="storeSelect1" name="store_id" required>
                    <option value="">Выберите магазин</option>
                    <?php foreach ($stores as $store): ?>
                        <option value="<?php echo $store['id']; ?>"><?php echo htmlspecialchars($store['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" id="loadDates1">Загрузить даты</button>
            </form>
        </div>
    </div>

    <div id="dateRangeForm1" class="dashboard-section1">
        <h3>Выберите диапазон дат</h3>
        <form id="rangeForm1" method="GET" action="chart.php" target="_blank" class="dashboard-form1">
        <input type="hidden" id="selectedStoreName1" name="store_name">
        <input type="hidden" id="selectedStoreId1" name="store_id">
            <label for="startDate1">Начальная дата:</label>
            <select id="startDate1" name="start_date" required></select>
            <label for="endDate1">Конечная дата:</label>
            <select id="endDate1" name="end_date" required></select>
            <button type="submit">Показать график</button>
        </form>
    </div>

    <div id="deleteModal1" class="modal1">
        <div class="modal-content1">
            <span class="close1" id="closeModal1">&times;</span>
            <h3>Вы уверены, что хотите удалить магазин?</h3>
            <form method="POST" id="deleteForm1">
                <input type="hidden" name="store_id" id="storeIdToDelete1">
                <button type="submit" name="delete_store" class="delete-button1">Удалить</button>
                <button type="button" id="cancelDelete1" class="button1">Отмена</button>
            </form>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>

<script src="script.js"></script>
</body>
</html>
