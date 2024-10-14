<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Fetch discussions from the database
$stmt = $pdo->query("SELECT d.*, u.name AS user_name FROM discussions d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
$discussions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Discussions</h2>
        <a href="create_discussion.php" class="btn btn-success">Create New Discussion</a>
        <div class="mt-3">
            <?php foreach ($discussions as $discussion): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($discussion['title']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($discussion['content']); ?></p>
                        <p class="card-text"><small class="text-muted">Posted by <?= htmlspecialchars($discussion['user_name']); ?> on <?= $discussion['created_at']; ?></small></p>
                        <a href="view_discussion.php?id=<?= $discussion['id']; ?>" class="btn btn-primary">View Comments</a>

                        <!-- Voting Form -->
                        <form method="POST" action="vote.php" style="display: inline;">
                            <input type="hidden" name="discussion_id" value="<?= $discussion['id']; ?>">
                            <button type="submit" name="vote_type" value="upvote" class="btn btn-outline-success">Upvote</button>
                            <button type="submit" name="vote_type" value="downvote" class="btn btn-outline-danger">Downvote</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
