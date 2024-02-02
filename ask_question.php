<?php
session_start();
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["question"])) {
    $question = mysqli_real_escape_string($conn, $_POST["question"]);
    $username = $_SESSION["username"]; // Assuming you have a username stored in the session

    // Insert the question into the database
    $insertQuestionQuery = "INSERT INTO questions (username, question_text, created_at) VALUES ('$username', '$question', NOW())";
    mysqli_query($conn, $insertQuestionQuery);
}

// Fetch questions with user details and timestamps from the database
$getQuestionsQuery = "SELECT q.question_id, q.question_text, q.created_at, u.username FROM questions q INNER JOIN users u ON q.username = u.username ORDER BY q.created_at DESC";
$questionsResult = mysqli_query($conn, $getQuestionsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS stylesheet here -->
    <link rel="stylesheet" href="ask_question.css">
    <title>Ask Questions</title>
</head>
<body>
    <div class="navbar">
        <!-- Your navigation bar code here -->
    </div>
    <div class="question-form">
        <h2>Ask a Question</h2>
        <form action="ask_question.php" method="POST">
            <textarea name="question" placeholder="Type your question here..." required></textarea>
            <button type="submit">Post Question</button>
        </form>
    </div>
    <div class="questions-feed">
        <?php while ($question = mysqli_fetch_assoc($questionsResult)): ?>
            <div class="question">
                <p><strong><?php echo $question['username']; ?></strong> - <?php echo $question['created_at']; ?></p>
                <p><?php echo $question['question_text']; ?></p>
                <!-- Link to view individual question details -->
                <a href="question_details.php?question_id=<?php echo $question['question_id']; ?>">View Answers</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
