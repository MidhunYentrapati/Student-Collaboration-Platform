<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Initialize $result to an empty array
$result = [];

// Check if a search query is provided
if (isset($_GET["query"])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET["query"]);
    // Modify your SQL query to search for projects containing the query in project_title or any other relevant field
    $query = "SELECT * FROM `projects` WHERE `project_title` LIKE '%$searchQuery%' ORDER BY `created_at` DESC";
    $result = mysqli_query($conn, $query);
} else {
    // Fetch all projects from the database
    $query = "SELECT * FROM `projects` ORDER BY `created_at` DESC";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS stylesheet here -->
    <link rel="stylesheet" href="main_home.css">
    <style>
        .highlight {
            background-color: yellow; /* You can change the highlight color */
            font-weight: bold;
        }

        .post {
            margin-bottom: 20px; /* Add space between posts */
            padding: 10px;
            border: 1px solid #1f2833;
        }

        .comment-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website</title>
    <script>
        // JavaScript function to highlight search query
        function highlightSearch() {
            var searchQuery = document.getElementById("search").value;
            var contentElements = document.querySelectorAll(".content");

            contentElements.forEach(function (element) {
                var content = element.textContent;
                var regex = new RegExp(searchQuery, "gi");
                var highlightedContent = content.replace(regex, function (match) {
                    return '<span class="highlight">' + match + '</span>';
                });

                element.innerHTML = highlightedContent;
            });
        }

        // JavaScript function to toggle comments
        function toggleComments(projectId) {
            var comments = document.getElementById("comments-" + projectId);
            var toggleButton = document.querySelector(".toggle-comments-" + projectId);

            if (comments.style.display === "none" || comments.style.display === "") {
                comments.style.display = "block";
                toggleButton.textContent = "Hide Comments";
            } else {
                comments.style.display = "none";
                toggleButton.textContent = "Show All Comments";
            }
        }
    </script>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-title">
            <h1>Neo Project</h1>
        </div>
        <div class="navbar-dropdown">
            <select onchange="window.location.href=this.value;">
                <option value="main_home.php" selected>Home</option>
                <option value="upload.php">Post</option>
                <option value="community.php">Community</option>
                <option value="ask_question.php">Ask Question</option>
                <option value="Settings.php">Settings</option>
                <option value="welcome.php">Logout</option>
            </select>
        </div>
        <div class="search-bar" style="padding-top: 5px;">
            <form action="main_home.php" method="GET">
                <input type="text" id="search" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="post-feed">
        <!-- Loop through user projects and display them -->
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <p><img src="icons/pf.png" alt="" width="20px"> <b style="font-family:cursive;"><?php echo $row['username']; ?></b></p>
                <p class="content">Project Title: <?php echo $row['project_title'];?></p>
                <!-- Link to project details (post_card.php) with project_id as a parameter -->
                <p>Project Details: <a href="post_card.php?project_id=<?php echo $row['project_id']; ?>">View Details</a></p>
                <p>Upload Date: <?php echo $row['created_at']; ?></p>
                
                <!-- Display the like count -->
                <?php
                // Get the project_id for the current project
                $project_id = $row['project_id'];
                // Query to retrieve the like count for this project
                $likeCountQuery = "SELECT COUNT(*) as like_count FROM project_likes WHERE project_id = '$project_id'";
                $likeCountResult = mysqli_query($conn, $likeCountQuery);
                $likeCountData = mysqli_fetch_assoc($likeCountResult);
                $likeCount = $likeCountData['like_count'];
                // Display the like count
                echo "<p>Like Count: $likeCount</p>";
                ?>

                <!-- Like button form -->
                <form method="post" action="like.php">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <button type="submit">Like</button>
                </form>
                
                <!-- Add a comment form for this project -->
                <form method="post" action="add_comment.php">
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="hidden" name="commenter_username" value="<?php echo $_SESSION['username']; ?>">
                    <textarea name="comment_text" placeholder="Add a comment"></textarea>
                    <button type="submit">Submit Comment</button>
                </form>
                
                <!-- Fetch and display project details, including the latest comment -->
                <?php
                $commentQuery = "SELECT p.project_title, p.about, p.tech_stack, p.features, p.how_to_run, p.extra_description, p.like_count, c.comment_text AS latest_comment, c.commenter_username
                        FROM projects p
                        LEFT JOIN project_comments c ON p.project_id = c.project_id
                        WHERE p.project_id = '$project_id'
                        ORDER BY c.comment_date DESC
                        LIMIT 1";
                $commentResult = mysqli_query($conn, $commentQuery);
                if ($commentRow = mysqli_fetch_assoc($commentResult)) {
                    echo "<div class='comment-section'>";
                    echo "<h2>Latest Comment</h2>";
                    if ($commentRow['latest_comment']) {
                        echo "<p>Commented by {$commentRow['commenter_username']}: {$commentRow['latest_comment']}</p>";
                    } else {
                        echo "<p>No comments yet.</p>";
                    }
                    
                    // Add a button to toggle comments
                    echo '<button class="toggle-comments-' . $project_id . '" onclick="toggleComments(' . $project_id . ')">Show All Comments</button>';
                    echo '<div class="comment-section" id="comments-' . $project_id . '" style="display: none;">';
                    
                    // Add a loop to display all comments for the project
                    $commentsQuery = "SELECT comment_text, commenter_username
                                     FROM project_comments
                                     WHERE project_id = '$project_id'
                                     ORDER BY comment_date DESC";
                    $commentsResult = mysqli_query($conn, $commentsQuery);
                    
                    while ($commentRow = mysqli_fetch_assoc($commentsResult)) {
                        echo "<p>Commented by {$commentRow['commenter_username']}: {$commentRow['comment_text']}</p>";
                    }
                    
                    echo '</div>'; // Close the comment section
                    echo "</div>";
                }
                ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
