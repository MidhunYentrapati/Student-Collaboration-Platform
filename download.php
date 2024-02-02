<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET["project_id"])) {
    $project_id = mysqli_real_escape_string($conn, $_GET["project_id"]);

    // Fetch project details from the database based on project_id
    $query = "SELECT * FROM `projects` WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $project_file = $row['project_file'];
        $project_type = $row['project_type'];

        // Set the appropriate headers for download based on the stored project_type
        header('Content-Type: ' . $project_type);
        header('Content-Disposition: attachment; filename="' . basename($project_file) . '"');

        // Read and output the file
        readfile($project_file);
        exit();
    } else {
        // Project not found, you can handle this case, e.g., display an error message
        echo "Project not found.";
        exit();
    }
} else {
    // Project_id not provided in the URL, you can handle this case as needed
    echo "Project ID is missing.";
    exit();
}
?>
