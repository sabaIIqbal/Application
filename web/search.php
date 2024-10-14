<?php
include 'db_connect.php';

// Initialize the $results array and search variables
$results = [];
$keyword = '';
$author = '';
$category = '';
$publication_date = '';
$citation_metrics = '';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Check if POST data is being received
    var_dump($_POST);
    
    $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
    $author = isset($_POST['author']) ? trim($_POST['author']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $publication_date = isset($_POST['publication_date']) ? trim($_POST['publication_date']) : '';
    $citation_metrics = isset($_POST['citation_metrics']) ? trim($_POST['citation_metrics']) : '';

    // Build the query with filters
    $query = "SELECT * FROM uploads WHERE 1=1"; // '1=1' allows adding AND conditions dynamically
    $params = [];

    if ($keyword !== '') {
        $query .= " AND file_name LIKE ?";
        $params[] = "%$keyword%";
    }
    if ($author !== '') {
        $query .= " AND author LIKE ?";
        $params[] = "%$author%";
    }
    if ($category !== '') {
        $query .= " AND category LIKE ?";
        $params[] = "%$category%";
    }
    if ($publication_date !== '') {
        $query .= " AND publication_date = ?";
        $params[] = $publication_date;
    }
    if ($citation_metrics !== '') {
        $query .= " AND citation_metrics LIKE ?";
        $params[] = "%$citation_metrics%";
    }

    // Debugging: Output the query and parameters
    echo "<pre>";
    echo "Query: $query\n";
    print_r($params);
    echo "</pre>";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array

    // Debugging: Check the fetched results
    var_dump($results);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Research Resources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .search-container {
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-container mx-auto">
            <h2 class="text-center">Search Research Resources</h2>
            <form action="search.php" method="POST">
                <div class="mb-3">
                    <label for="keyword" class="form-label">Keyword</label>
                    <input type="text" name="keyword" class="form-control" id="keyword" placeholder="Enter keywords" value="<?= htmlspecialchars($keyword); ?>">
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" class="form-control" id="author" placeholder="Enter author's name" value="<?= htmlspecialchars($author); ?>">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" id="category" placeholder="Enter category" value="<?= htmlspecialchars($category); ?>">
                </div>
                <div class="mb-3">
                    <label for="publication_date" class="form-label">Publication Date</label>
                    <input type="date" name="publication_date" class="form-control" id="publication_date" value="<?= htmlspecialchars($publication_date); ?>">
                </div>
                <div class="mb-3">
                    <label for="citation_metrics" class="form-label">Citation Metrics</label>
                    <input type="text" name="citation_metrics" class="form-control" id="citation_metrics" placeholder="Enter citation metrics" value="<?= htmlspecialchars($citation_metrics); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <hr>
            <h4 class="text-center">Search Results</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Publication Date</th>
                        <th>Citation Metrics</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $upload): ?>
                            <tr>
                                <td><?= htmlspecialchars($upload['file_name']); ?></td>
                                <td><?= htmlspecialchars($upload['author']); ?></td>
                                <td><?= htmlspecialchars($upload['category']); ?></td>
                                <td><?= htmlspecialchars($upload['publication_date']); ?></td>
                                <td><?= htmlspecialchars($upload['citation_metrics']); ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($upload['file_path']); ?>" class="btn btn-primary" download>Download</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No results found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
