<?php
session_start();
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["question_id"]) && isset($_POST["answer_text"])) {
    $questionId = mysqli_real_escape_string($conn, $_POST["question_id"]);
    $answerText = mysqli_real_escape_string($conn, $_POST["answer_text"]);
    $username = $_SESSION["username"]; // Assuming you have a username stored in the session

    // Construct the SQL query
    $insertAnswerQuery = "INSERT INTO answers (question_id, username, answer_text, created_at) VALUES ('$questionId', '$username', '$answerText', NOW())";

    // Insert the answer into the database
    if (mysqli_query($conn, $insertAnswerQuery)) {
        // Answer inserted successfully
        header("Location: question_details.php?question_id=$questionId");
        exit();
    } else {
        // Handle the insertion error
        echo "Error: " . mysqli_error($conn);
        // Additional error handling code can be added here if needed
    }
} else {
    // Handle invalid form submissions or direct access to this file
    header("Location: ask_question.php");
    exit();
}
?>
