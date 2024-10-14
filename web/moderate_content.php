<?php
// Include the database connection file
include 'db_connect.php';
$posts = $pdo->query("SELECT posts.id, users.name, posts.content, posts.status 
                      FROM posts 
                      JOIN users ON posts.user_id = users.id")->fetchAll();

if (isset($_POST['approve_post'])) {
    $postId = $_POST['post_id'];
    $stmt = $pdo->prepare("UPDATE posts SET status = 'approved' WHERE id = ?");
    $stmt->execute([$postId]);
    header('Location: moderate_content.php');
}

if (isset($_POST['flag_post'])) {
    $postId = $_POST['post_id'];
    $stmt = $pdo->prepare("UPDATE posts SET status = 'flagged' WHERE id = ?");
    $stmt->execute([$postId]);
    header('Location: moderate_content.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Moderate Content</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= $post['id'] ?></td>
                        <td><?= $post['name'] ?></td>
                        <td><?= $post['content'] ?></td>
                        <td><?= $post['status'] ?></td>
                        <td>
                            <?php if ($post['status'] === 'pending'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <button type="submit" name="approve_post" class="btn btn-success btn-sm">Approve</button>
                                    <button type="submit" name="flag_post" class="btn btn-warning btn-sm">Flag</button>
                                </form>
                            <?php elseif ($post['status'] === 'approved'): ?>
                                <span class="text-success">Approved</span>
                            <?php elseif ($post['status'] === 'flagged'): ?>
                                <span class="text-warning">Flagged</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
