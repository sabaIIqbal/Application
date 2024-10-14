<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Fetch uploaded files for the logged-in user
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM uploads WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $uploads = $stmt->fetchAll();
} else {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploaded Resources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .uploads-container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="uploads-container mx-auto">
            <h2 class="text-center">My Uploaded Resources</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>File Type</th>
                        <th>Upload Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($uploads) > 0): ?>
                        <?php foreach ($uploads as $upload): ?>
                            <tr>
                                <td><?= htmlspecialchars($upload['file_name']); ?></td>
                                <td><?= htmlspecialchars($upload['file_type']); ?></td>
                                <td><?= htmlspecialchars($upload['created_at']); ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($upload['file_path']); ?>" class="btn btn-primary" download>Download</a>
                                    <!-- Add a delete button if needed -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No uploaded resources found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
