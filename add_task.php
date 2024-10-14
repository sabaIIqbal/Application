<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO project_tasks (project_id, task_name, assigned_to) VALUES (?, ?, ?)");
    $stmt->execute([$project_id, $task_name, $user_id]);

    header("Location: project_details.php?id=$project_id"); // Redirect back to project details
    exit;
}
?>
