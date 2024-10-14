<?php
session_start();
include 'db_connect.php';

// Assuming you have a user ID stored in the session
$user_id = $_SESSION['user_id'] ?? null; // Get the logged-in user ID

if (!$user_id) {
    die("<h1>You must be logged in to view this page.</h1>");
}

// Fetch user metrics
$stmt = $pdo->prepare("SELECT * FROM user_metrics WHERE user_id = ?");
$stmt->execute([$user_id]);
$metrics = $stmt->fetch();

if (!$metrics) {
    $metrics = [
        'downloads' => 0,
        'citations' => 0,
        'engagement_score' => 0
    ]; // Set default values if no metrics are found
}

// Fetch engagement data over time (example: monthly data)
$engagement_stmt = $pdo->prepare("SELECT month, engagement_score FROM engagement_metrics WHERE user_id = ?");
$engagement_stmt->execute([$user_id]);
$engagement_data = $engagement_stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$labels = [];
$data = [];
foreach ($engagement_data as $entry) {
    $labels[] = $entry['month']; // Assuming month is a string, e.g., 'January'
    $data[] = $entry['engagement_score'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Your Analytics Dashboard</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Downloads</h5>
                        <p class="card-text"><?= htmlspecialchars($metrics['downloads']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Citations</h5>
                        <p class="card-text"><?= htmlspecialchars($metrics['citations']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Engagement Score</h5>
                        <p class="card-text"><?= htmlspecialchars($metrics['engagement_score']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Engagement Over Time</h4>
        <canvas id="engagementChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Engagement data fetched from PHP
        const engagementData = <?= json_encode($data); ?>; // Convert PHP array to JavaScript array
        const labels = <?= json_encode($labels); ?>; // Month labels for the chart

        const ctx = document.getElementById('engagementChart').getContext('2d');
        const engagementChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Use labels from PHP
                datasets: [{
                    label: 'Engagement Score',
                    data: engagementData, // Use data from PHP
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
