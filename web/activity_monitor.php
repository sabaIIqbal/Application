<?php
// Include the database connection file
include 'db_connect.php';
$activities = $pdo->query("SELECT activity_logs.id, users.name, activity_logs.action, activity_logs.description, activity_logs.created_at
                           FROM activity_logs 
                           JOIN users ON activity_logs.user_id = users.id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Monitor Platform Activity</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        <td><?= $activity['id'] ?></td>
                        <td><?= $activity['name'] ?></td>
                        <td><?= $activity['action'] ?></td>
                        <td><?= $activity['description'] ?></td>
                        <td><?= $activity['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
