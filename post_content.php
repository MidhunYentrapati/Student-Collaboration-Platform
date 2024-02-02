<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to insert user's post
    $username = $_SESSION["username"];
    $content = mysqli_real_escape_string($conn, $_POST["post_content"]);

    // File upload handling
    if (!empty($_FILES["file"]["name"])) {
        $file_name = $_FILES["file"]["name"];
        $file_type = $_FILES["file"]["type"];
        $file_data = file_get_contents($_FILES["file"]["tmp_name"]);

        // Prepare an SQL statement with placeholders
        $insertQuery = "INSERT INTO posts (username, content, file_name, file_type, file_data) VALUES (?, ?, ?, ?, ?)";
        
        // Use prepared statement to insert data
        $stmt = mysqli_prepare($conn, $insertQuery);

        if ($stmt) {
            // Bind parameters to placeholders
            mysqli_stmt_bind_param($stmt, "sssss", $username, $content, $file_name, $file_type, $file_data);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to a success page or back to the profile page
                header("Location: start.php");
                exit();
            } else {
                echo "Error inserting data: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
    } else {
        echo "Please select a file to upload.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Content</title>
    <link rel="stylesheet" href="post_style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li><a href="start.php" style="color: #66fcf1;">Profile</a></li>
                    <li><a href="post_content.php" style="color: #66fcf1;">Post Content</a></li>
                    <!-- Add more links as needed -->
                    <li><a href="welcome.php" style="color: #66fcf1;">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="post-section">
                <h1>Post Your Content</h1>
                <form method="POST" action="post_content.php" enctype="multipart/form-data">
                    <label for="post_content">Description:</label>
                    <textarea id="post_content" name="post_content" rows="4" cols="50" required></textarea><br>
                    <label for="file">File Upload:</label>
                    <input type="file" id="file" name="file"><br>
                    <input type="submit" value="Submit">
                </form>
            </section>
        </main>
    </div>
</body>
</html>
