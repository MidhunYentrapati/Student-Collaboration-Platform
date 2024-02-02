<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the form data
    $project_title = mysqli_real_escape_string($conn, $_POST['project_title']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $tech_stack = mysqli_real_escape_string($conn, $_POST['tech_stack']);
    $features = mysqli_real_escape_string($conn, $_POST['features']);
    $how_to_run = mysqli_real_escape_string($conn, $_POST['how_to_run']);
    $extra_description = mysqli_real_escape_string($conn, $_POST['extra_description']);

    // File Upload
    $project_file = $_FILES['project_file'];

    // Extract the project file type from the uploaded file's extension
    $file_name = $project_file['name'];
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // Insert data into the 'projects' table, including the project file type
    $username = $_SESSION["username"];
    $query = "INSERT INTO `projects` (username, project_title, about, tech_stack, features, how_to_run, extra_description, project_file, project_type)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $username, $project_title, $about, $tech_stack, $features, $how_to_run, $extra_description, $file_name, $file_extension);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Successfully inserted project details

            // Handle file uploads (project_file and project_images)
            // You can use PHP functions like move_uploaded_file() to handle file uploads

            // Redirect to a success page or display a success message
            header("Location: main_home.php");
            exit();
        } else {
            // Error occurred while executing the statement
            // Handle the error or redirect to an error page
            echo "Error: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error occurred while preparing the statement
        // Handle the error or redirect to an error page
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS stylesheet here -->
    <!--link rel="stylesheet" href="upload.css"-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project Details</title>
</head>
<body>
    <h1>Upload Project Details</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <!-- Project Title Block -->
        <h2>Project Title</h2>
        <input type="text" id="project_title" name="project_title" required>

        <!-- About Block -->
        <h2>About</h2>
        <textarea id="about" name="about" rows="4" cols="50" required></textarea>

        <!-- Tech Stack Block -->
        <h2>Tech Stack</h2>
        <input type="text" id="tech_stack" name="tech_stack" required>

        <!-- Features Block -->
        <h2>Features</h2>
        <input type="text" id="features" name="features" required>

        <!-- How to Run the Project Block -->
        <h2>How to Run the Project</h2>
        <textarea id="how_to_run" name="how_to_run" rows="4" cols="50" required></textarea>

        <!-- Download File Block -->
        <h2>Download File</h2>
        <input type="file" id="project_file" name="project_file" required>

        <!-- Project Preview Block>
        <h2>Project Preview</h2>
        <input type="file" id="project_images" name="project_images[]" multiple required>
        < Allow multiple image uploads -->

        <!-- Extra Description Block -->
        <h2>Extra Description</h2>
        <textarea id="extra_description" name="extra_description" rows="4" cols="50"></textarea>

        <input type="submit" value="Upload">
    </form>
</body>
</html>
