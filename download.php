<?php

// download.php (when a user downloads a research paper)
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paper_id = $_POST['paper_id'];
    $user_id = $_SESSION['user_id'];

    // Update download count
    $stmt = $pdo->prepare("UPDATE metrics SET downloads = downloads + 1 WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Serve the file for download
    // Code to serve the file...

    header("Location: paper_details.php?id=$paper_id");
    exit;
}
?>