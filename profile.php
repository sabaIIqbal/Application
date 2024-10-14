<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Fetch user data if already exists
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];
    $affiliation = $_POST['affiliation'];
    $research_interests = $_POST['research_interests'];
    
    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = $target_file; // Save the file path
    }

    // Update user data in the database
    $stmt = $pdo->prepare("UPDATE users SET bio = ?, affiliation = ?, research_interests = ?, profile_picture = ? WHERE id = ?");
    $stmt->execute([$bio, $affiliation, $research_interests, $profile_picture, $_SESSION['user_id']]);

    header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .profile-container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container mx-auto">
            <h2 class="text-center">Edit Profile</h2>
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea name="bio" class="form-control" id="bio" rows="4"><?= isset($user['bio']) ? htmlspecialchars($user['bio']) : ''; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="affiliation" class="form-label">Affiliation</label>
                    <input type="text" name="affiliation" class="form-control" id="affiliation" value="<?= isset($user['affiliation']) ? htmlspecialchars($user['affiliation']) : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="research_interests" class="form-label">Research Interests</label>
                    <textarea name="research_interests" class="form-control" id="research_interests" rows="4"><?= isset($user['research_interests']) ? htmlspecialchars($user['research_interests']) : ''; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
            <?php if (isset($user['profile_picture'])): ?>
                <h3 class="mt-4">Current Profile Picture:</h3>
                <img src="<?= htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="img-fluid" style="max-width: 200px;">
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
