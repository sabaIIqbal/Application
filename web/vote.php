<?php
session_start();
include 'db_connect.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discussion_id = $_POST['discussion_id'];
    $vote_type = $_POST['vote_type'];

    // Check if the user has already voted
    $stmt = $pdo->prepare("SELECT * FROM votes WHERE discussion_id = ? AND user_id = ?");
    $stmt->execute([$discussion_id, $_SESSION['user_id']]);
    $existing_vote = $stmt->fetch();

    if ($existing_vote) {
        // Update existing vote
        $stmt = $pdo->prepare("UPDATE votes SET vote_type = ? WHERE discussion_id = ? AND user_id = ?");
        $stmt->execute([$vote_type, $discussion_id, $_SESSION['user_id']]);
    } else {
        // Insert new vote
        $stmt = $pdo->prepare("INSERT INTO votes (discussion_id, user_id, vote_type) VALUES (?, ?, ?)");
        $stmt->execute([$discussion_id, $_SESSION['user_id'], $vote_type]);
    }

    header("Location: discussions.php");
    exit;
}
