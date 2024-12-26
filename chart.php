<?php
include 'config.php';

if (isset($_GET['store_id'], $_GET['start_date'], $_GET['end_date'])) {
    $store_id = $_GET['store_id'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $store_name = htmlspecialchars($_GET['store_name']);

    $stmt = $conn->prepare("SELECT date, revenue FROM revenues WHERE store_id = ? AND date BETWEEN ? AND ? ORDER BY date ASC");
    $stmt->bind_param("iss", $store_id, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo "<script>
        document.title = '$store_name';
    </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>График выручки: <?php echo $store_name; ?></h1>
<canvas id="revenueChart"></canvas>
<script>
    const data = <?php echo json_encode($data); ?>;
    const labels = data.map(entry => entry.date);
    const revenues = data.map(entry => entry.revenue);

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Выручка',
                data: revenues,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
</body>
</html>
