<?php
session_start();
include 'db_connect.php';

// Ensure user_id is valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID.");
}

$user_id = $_GET['id']; // User profile being viewed
$current_user_id = $_SESSION['user_id'] ?? null; // Logged-in user (default to null if not set)

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// Fetch followers and following
$followers_stmt = $pdo->prepare("SELECT * FROM followers WHERE followed_id = ?");
$followers_stmt->execute([$user_id]);
$followers = $followers_stmt->fetchAll();

$following_stmt = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ?");
$following_stmt->execute([$user_id]);
$following = $following_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['username']); ?>'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?= htmlspecialchars($user['username']); ?></h2>
        <p><?= htmlspecialchars($user['bio']); ?></p>

        <h4>Followers (<?= count($followers); ?>)</h4>
        <ul>
            <?php foreach ($followers as $follower): ?>
                <?php
                // Fetch follower's username for better display
                $follower_stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
                $follower_stmt->execute([$follower['follower_id']]);
                $follower_user = $follower_stmt->fetch();
                ?>
                <li><?= htmlspecialchars($follower_user['username'] ?? 'Unknown User'); ?></li>
            <?php endforeach; ?>
        </ul>

        <h4>Following (<?= count($following); ?>)</h4>
        <ul>
            <?php foreach ($following as $followed): ?>
                <?php
                // Fetch followed user's username for better display
                $followed_stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
                $followed_stmt->execute([$followed['followed_id']]);
                $followed_user = $followed_stmt->fetch();
                ?>
                <li><?= htmlspecialchars($followed_user['username'] ?? 'Unknown User'); ?></li>
            <?php endforeach; ?>
        </ul>

        <?php if ($current_user_id): ?>
            <form action="follow_user.php" method="POST">
                <input type="hidden" name="followed_id" value="<?= $user_id; ?>">
                <button type="submit" class="btn btn-primary">
                    <?php
                    // Check if currently following
                    $stmt = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND followed_id = ?");
                    $stmt->execute([$current_user_id, $user_id]);
                    if ($stmt->rowCount() > 0) {
                        echo "Unfollow";
                    } else {
                        echo "Follow";
                    }
                    ?>
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
