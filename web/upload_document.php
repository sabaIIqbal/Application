<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $user_id = $_SESSION['user_id'];

    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    $target_file = $target_dir . basename($_FILES["document"]["name"]);
    move_uploaded_file($_FILES["document"]["tmp_name"], $target_file);

    $stmt = $pdo->prepare("INSERT INTO project_documents (project_id, file_path, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$project_id, $target_file, $user_id]);

    header("Location: project_details.php?id=$project_id"); // Redirect back to project details
    exit;
}
?>
