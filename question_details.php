<?php
require('db.php');

if (isset($_GET['question_id'])) {
    $questionId = mysqli_real_escape_string($conn, $_GET['question_id']);
    
    // Fetch the question details with user information
    $getQuestionQuery = "SELECT q.question_id, q.question_text, q.created_at, u.username FROM questions q INNER JOIN users u ON q.username = u.username WHERE q.question_id = $questionId";
    $questionResult = mysqli_query($conn, $getQuestionQuery);
    $question = mysqli_fetch_assoc($questionResult);
    
    // Fetch answers for the question
    $getAnswersQuery = "SELECT * FROM answers WHERE question_id = $questionId ORDER BY created_at DESC";
    $answersResult = mysqli_query($conn, $getAnswersQuery);
} else {
    // Handle case where question_id is not provided
    header("Location: ask_question.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS stylesheet here -->
    <link rel="stylesheet" href="question_details.css">
    <title>Question Details</title>
</head>
<body>
    <div class="question-details">
        <div class="question">
            <p><strong><?php echo $question['username']; ?></strong> - <?php echo $question['created_at']; ?></p>
            <p><?php echo $question['question_text']; ?></p>
        </div>
        <div class="answers">
            <?php while ($answer = mysqli_fetch_assoc($answersResult)): ?>
                <div class="answer">
                    <p><strong><?php echo $answer['username']; ?></strong> - <?php echo $answer['created_at']; ?></p>
                    <p><?php echo $answer['answer_text']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Form to submit an answer -->
        <div class="answer-form">
            <h2>Submit Your Answer</h2>
            <form action="submit_answer.php" method="POST">
                <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">
                <textarea name="answer_text" placeholder="Your answer..." required></textarea>
                <button type="submit">Submit Answer</button>
            </form>
        </div>
    </div>
</body>
</html>
