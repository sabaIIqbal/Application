<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to a logout confirmation page or homepage
    header("Location: login.php?message=You have been logged out successfully.");
    exit; // Ensure no further code is executed
} else {
    // If no session exists, redirect to the login page
    header("Location: login.php?message=You are not logged in.");
    exit;
}
?>
