<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Fetch user data
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
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
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .profile-container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-picture {
            max-width: 200px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container mx-auto">
            <h2 class="text-center"><?= htmlspecialchars($user['name']); ?>'s Profile</h2>
            <?php if ($user['profile_picture']): ?>
                <img src="<?= htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-picture img-fluid">
            <?php endif; ?>
            <h3>Bio</h3>
            <p><?= htmlspecialchars($user['bio']); ?></p>
            <h3>Affiliation</h3>
            <p><?= htmlspecialchars($user['affiliation']); ?></p>
            <h3>Research Interests</h3>
            <p><?= htmlspecialchars($user['research_interests']); ?></p>
        </div>
    </div>
</body>
</html>
