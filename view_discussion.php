<?php
session_start();
include 'db_connect.php'; // Include your database connection

if (!isset($_GET['id'])) {
    die("Discussion ID not provided.");
}

$discussion_id = $_GET['id'];

// Fetch discussion details
$stmt = $pdo->prepare("SELECT d.*, u.name AS user_name FROM discussions d JOIN users u ON d.user_id = u.id WHERE d.id = ?");
$stmt->execute([$discussion_id]);
$discussion = $stmt->fetch();

// Fetch comments
$stmt = $pdo->prepare("SELECT c.*, u.name AS user_name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.discussion_id = ? ORDER BY c.created_at");
$stmt->execute([$discussion_id]);
$comments = $stmt->fetchAll();

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $stmt = $pdo->prepare("INSERT INTO comments (discussion_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$discussion_id, $_SESSION['user_id'], $content]);
    header("Location: view_discussion.php?id=$discussion_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($discussion['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?= htmlspecialchars($discussion['title']); ?></h2>
        <p><?= htmlspecialchars($discussion['content']); ?></p>
        <p><small class="text-muted">Posted by <?= htmlspecialchars($discussion['user_name']); ?> on <?= $discussion['created_at']; ?></small></p>

        <h4>Comments</h4>
        <form method="POST" action="view_discussion.php?id=<?= $discussion['id']; ?>">
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>

        <div class="mt-3">
            <?php foreach ($comments as $comment): ?>
                <div class="card mb-2">
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($comment['content']); ?></p>
                        <p class="card-text"><small class="text-muted">Commented by <?= htmlspecialchars($comment['user_name']); ?> on <?= $comment['created_at']; ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
