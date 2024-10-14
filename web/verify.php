<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET verified = 1 WHERE token = ?");
        $stmt->execute([$token]);
        echo "Email verified successfully!";
    } else {
        echo "Invalid token!";
    }
}
?>
