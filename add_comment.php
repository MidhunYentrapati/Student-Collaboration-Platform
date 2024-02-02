<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["project_id"]) && isset($_POST["comment_text"]) && isset($_POST["commenter_username"])) {
        $project_id = mysqli_real_escape_string($conn, $_POST["project_id"]);
        $comment_text = mysqli_real_escape_string($conn, $_POST["comment_text"]);
        $commenter_username = $_POST["commenter_username"];
        
        // Insert the comment into the database
        $insertQuery = "INSERT INTO project_comments (project_id, comment_text, commenter_username) VALUES ('$project_id', '$comment_text', '$commenter_username')";
        
        if (mysqli_query($conn, $insertQuery)) {
            // Comment added successfully
            header("Location: main_home.php");
        } else {
            // Comment insertion failed
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
