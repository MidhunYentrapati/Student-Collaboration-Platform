<?php
session_start();
require('db.php');

if (isset($_POST["project_id"]) && isset($_SESSION["username"])) {
    // Get the project_id and username from the POST data and session
    $project_id = mysqli_real_escape_string($conn, $_POST["project_id"]);
    $username = $_SESSION["username"];

    // Check if the user has already liked the project
    $checkQuery = "SELECT * FROM project_likes WHERE project_id = '$project_id' AND username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // User has not liked this project before
        $insertQuery = "INSERT INTO project_likes (project_id, username) VALUES ('$project_id', '$username')";
        mysqli_query($conn, $insertQuery);

        // Increment the like_count in the projects table
        $updateQuery = "UPDATE projects SET like_count = like_count + 1 WHERE project_id = '$project_id'";
        mysqli_query($conn, $updateQuery);
    }
}

// Redirect back to the project page (main_home.php) with the project_id
header("Location: main_home.php?project_id=" . $project_id);
exit();
?>
