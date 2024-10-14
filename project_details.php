<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid project ID.");
}

$project_id = $_GET['id'];

// Fetch project details
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch();

if (!$project) {
    die("Project not found.");
}

// Fetch discussions
$discussions_stmt = $pdo->prepare("SELECT * FROM project_discussions WHERE project_id = ?");
$discussions_stmt->execute([$project_id]);
$discussions = $discussions_stmt->fetchAll();

// Fetch documents
$documents_stmt = $pdo->prepare("SELECT * FROM project_documents WHERE project_id = ?");
$documents_stmt->execute([$project_id]);
$documents = $documents_stmt->fetchAll();

// Fetch tasks
$tasks_stmt = $pdo->prepare("SELECT * FROM project_tasks WHERE project_id = ?");
$tasks_stmt->execute([$project_id]);
$tasks = $tasks_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['title']); ?> - Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2><?= htmlspecialchars($project['title']); ?></h2>
        <p><?= htmlspecialchars($project['description']); ?></p>

        <h4>Discussions</h4>
        <a href="create_discussion.php?project_id=<?= $project_id; ?>" class="btn btn-success">Start New Discussion</a>
        <div class="mt-3">
            <?php if (empty($discussions)): ?>
                <p>No discussions available.</p>
            <?php else: ?>
                <?php foreach ($discussions as $discussion): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($discussion['title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($discussion['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h4>Documents</h4>
        <form action="upload_document.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="project_id" value="<?= $project_id; ?>">
            <input type="file" name="document" required>
            <button type="submit" class="btn btn-primary">Upload Document</button>
        </form>
        <div class="mt-3">
            <?php if (empty($documents)): ?>
                <p>No documents uploaded.</p>
            <?php else: ?>
                <?php foreach ($documents as $document): ?>
                    <div class="mb-2">
                        <a href="<?= htmlspecialchars($document['file_path']); ?>" target="_blank"><?= htmlspecialchars($document['file_path']); ?></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h4>Tasks</h4>
        <form method="POST" action="add_task.php">
            <input type="hidden" name="project_id" value="<?= $project_id; ?>">
            <div class="mb-3">
                <label for="task_name" class="form-label">Task Name</label>
                <input type="text" name="task_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
        <ul class="list-group mt-3">
            <?php if (empty($tasks)): ?>
                <li class="list-group-item">No tasks available.</li>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <li class="list-group-item"><?= htmlspecialchars($task['task_name']); ?> - Status: <?= htmlspecialchars($task['status']); ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
