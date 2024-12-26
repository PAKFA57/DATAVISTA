<?php
include 'config.php';

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    $stmt = $conn->prepare("SELECT DISTINCT date FROM revenues WHERE store_id = ? ORDER BY date ASC");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $dates = [];
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['date'];
    }

    echo json_encode(['success' => true, 'dates' => $dates]);
} else {
    echo json_encode(['success' => false]);
}
?>
