<?php
$conn = new mysqli('localhost', 'root', '', 'project_db');
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
