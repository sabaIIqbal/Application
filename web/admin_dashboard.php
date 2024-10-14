<?php
// Ensure admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin_styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                <li class="nav-item"><a class="nav-link" href="moderate_content.php">Moderate Content</a></li>
                <li class="nav-item"><a class="nav-link" href="guidelines.php">Enforce Guidelines</a></li>
                <li class="nav-item"><a class="nav-link" href="activity_monitor.php">Monitor Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Welcome, Admin</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View, edit, and delete users.</p>
                        <a href="manage_users.php" class="btn btn-primary">Go to User Management</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Moderate Content</h5>
                        <p class="card-text">Review, approve, or flag user content.</p>
                        <a href="moderate_content.php" class="btn btn-primary">Go to Content Moderation</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Monitor Activity</h5>
                        <p class="card-text">View platform activity and user statistics.</p>
                        <a href="activity_monitor.php" class="btn btn-primary">Go to Activity Monitoring</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
