<?php
// follow_user.php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $followed_id = $_POST['followed_id']; // User ID to follow
    $follower_id = $_SESSION['user_id']; // Logged-in user ID

    // Check if already following
    $stmt = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND followed_id = ?");
    $stmt->execute([$follower_id, $followed_id]);

    if ($stmt->rowCount() === 0) {
        // Not following, so follow
        $stmt = $pdo->prepare("INSERT INTO followers (follower_id, followed_id) VALUES (?, ?)");
        $stmt->execute([$follower_id, $followed_id]);

        // Add notification
        $notification = "You have a new follower.";
        $notification_stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notification_stmt->execute([$followed_id, $notification]);
    } else {
        // Already following, so unfollow
        $stmt = $pdo->prepare("DELETE FROM followers WHERE follower_id = ? AND followed_id = ?");
        $stmt->execute([$follower_id, $followed_id]);
    }

    header("Location: user_profile.php?id=$followed_id"); // Redirect to user profile
    exit;
}
