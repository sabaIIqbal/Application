<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : []; // Tags as comma-separated values

    // Insert discussion into the database
    $stmt = $pdo->prepare("INSERT INTO discussions (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $content]);
    $discussion_id = $pdo->lastInsertId();

    // Insert tags into the database
    foreach ($tags as $tag) {
        $tag = trim($tag);
        // Check if tag exists, if not insert it
        $stmt = $pdo->prepare("INSERT IGNORE INTO tags (name) VALUES (?)");
        $stmt->execute([$tag]);

        // Get the tag ID
        $stmt = $pdo->prepare("SELECT id FROM tags WHERE name = ?");
        $stmt->execute([$tag]);
        $tag_id = $stmt->fetchColumn();

        // Link discussion and tag
        $stmt = $pdo->prepare("INSERT INTO discussion_tags (discussion_id, tag_id) VALUES (?, ?)");
        $stmt->execute([$discussion_id, $tag_id]);
    }

    // Redirect to discussion list after creating
    header("Location: discussions.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Discussion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create a New Discussion</h2>
        <form method="POST" action="create_discussion.php">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control" id="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tags (comma-separated)</label>
                <input type="text" name="tags" class="form-control" id="tags">
            </div>
            <button type="submit" class="btn btn-primary">Create Discussion</button>
        </form>
    </div>
</body>
</html>
