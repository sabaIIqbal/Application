<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO project_members (project_id, user_id) VALUES (?, ?)");
    $stmt->execute([$project_id, $user_id]);

    header("Location: project_details.php?id=$project_id"); // Redirect to project details page
    exit;
}
?>
