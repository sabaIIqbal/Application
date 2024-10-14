<?php
// Start a session if not already started
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']); // Adjust as per your login mechanism
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ResearchHub - Home</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link to your CSS file -->

    <style>
        /* General Styles */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-image: url('../images/undraw_Master_plan_re_jvit.png');
            background-size: contain;
            background-position: right center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }

        main {
            flex: 1;
            padding: 20px;
            transition: margin-right 0.5s;
            margin-left: 100px;
        }

        footer {
            padding: 10px;
            text-align: center;
            background-color: #333;
            color: white;
        }

        /* Header styles */
        header {
            padding: 10px;
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: 'Brush Script MT', cursive;
            font-size: 36px;
            margin: 0;
            color: #ffffff;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            display: inline-block;
            margin: 0 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.8);
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: -5px 0 5px rgba(0, 0, 0, 0.5);
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .closebtn {
            position: absolute;
            top: 10px;
            left: 25px;
            font-size: 36px;
            cursor: pointer;
        }

        #menuIcon {
            font-size: 30px;
            cursor: pointer;
            color: white;
        }

        /* Open the sidebar */
        .sidebar.open {
            width: 300px;
        }

        /* Paragraph description above main section */
        .description {
            padding: 20px;
            margin-left: 100px;
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            color: #333;
            max-width: 600px;
            font-size: 18px;
            line-height: 1.6;
            border-radius: 10px;
        }

    </style>
</head>
<body>

    <header>
        <h1 class="logo">ResearchHub</h1>
        <span id="menuIcon" onclick="openNav()">&#9776; Menu</span>
        <nav>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
                    <li><a href="my_uploads.php">My Uploads</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Paragraph description section -->
    <div class="description">
        <p>
            Welcome to ResearchHub, a platform designed to facilitate collaboration and knowledge sharing among researchers, academics, and students. 
            At ResearchHub, you can upload, discover, and discuss research papers, articles, datasets, and more. Whether you're looking to collaborate on a 
            project or engage in academic discussions, ResearchHub offers all the tools you need to connect with like-minded individuals and contribute to the research community.
        </p>
    </div>

    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="create_project.php">Create Project</a>
        <a href="create_discussion.php">Create Discussion</a>
        <a href="search.php">Search Resources</a>
        <a href="notifications.php">Notifications</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="profile.php">Profile</a>
        <a href="usersdashboard.php">User Dashboard</a>
    </div>

    <main>
        <section>
            <h2>Recent Discussions</h2>
            <a href="discussions.php">View All Discussions</a>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> ResearchHub. All rights reserved.</p>
    </footer>

    <script>
        function openNav() {
            document.getElementById("mySidebar").classList.add("open");
        }

        function closeNav() {
            document.getElementById("mySidebar").classList.remove("open");
        }
    </script>
</body>
</html>
