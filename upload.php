<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['file_upload']['name'];
        $file_tmp = $_FILES['file_upload']['tmp_name'];
        $file_type = $_FILES['file_upload']['type'];
        
        // Define allowed file types
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // PDF and Word
                          'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', // PowerPoint
                          'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Excel
                          'text/plain', 'application/zip']; // Text and Zip

        // Check if the file type is allowed
        if (in_array($file_type, $allowed_types)) {
            // Specify the directory for uploads
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file_name);
            
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Insert file information into the database
                $stmt = $pdo->prepare("INSERT INTO uploads (user_id, file_name, file_path, file_type) VALUES (?, ?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $file_name, $target_file, $file_type]);
                echo "<div class='alert alert-success'>File uploaded successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error uploading file.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Invalid file type. Allowed types: PDF, Word, PowerPoint, Excel, Text, Zip.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>File upload error.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Research Resources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .upload-container {
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
        <div class="upload-container mx-auto">
            <h2 class="text-center">Upload Research Resources</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="file_upload" class="form-label">Select File</label>
                    <input type="file" name="file_upload" class="form-control" id="file_upload" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload File</button>
            </form>
        </div>
    </div>
</body>
</html>
