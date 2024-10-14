<?php
// Include the database connection file
include 'db_connect.php';

// Fetch the users from the database
$users = $pdo->query("SELECT * FROM users")->fetchAll();

if (isset($_POST['ban_user'])) {
    $userId = $_POST['user_id'];
    $stmt = $pdo->prepare("UPDATE users SET status = 'banned' WHERE id = ?");
    $stmt->execute([$userId]);
    header('Location: manage_users.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Users</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['status'] ?></td>
                        <td>
                            <?php if ($user['status'] === 'active'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="ban_user" class="btn btn-danger btn-sm">Ban</button>
                                </form>
                            <?php else: ?>
                                <span>Banned</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
