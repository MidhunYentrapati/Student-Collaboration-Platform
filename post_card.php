<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Check if a project_id is provided in the URL
if (isset($_GET["project_id"])) {
    $project_id = mysqli_real_escape_string($conn, $_GET["project_id"]);
    
    // Fetch project details from the database based on project_id
    $query = "SELECT * FROM `projects` WHERE project_id = '$project_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Project details found, including file details
        $project_title = $row['project_title'];
        $about = $row['about'];
        $tech_stack = $row['tech_stack'];
        $features = $row['features'];
        $how_to_run = $row['how_to_run'];
        $extra_description = $row['extra_description'];
        $created_at = $row['created_at'];
        $username = $row['username'];
        
        // Display project title
        echo "<h1>$project_title</h1>";
        echo "<p>Project by: $username</p>";
        echo "<p>Created at: $created_at</p>";
        echo "<hr>";
        
        // About Block
        echo "<div class='block'>";
        echo "<h2>About</h2>";
        echo "<p>$about</p>";
        echo "<button class='read-more'>Read More</button>";
        echo "</div>";
        
        // Tech Stack Block
        echo "<div class='block'>";
        echo "<h2>Tech Stack</h2>";
        echo "<p>$tech_stack</p>";
        echo "</div>";
        
        // Features Block
        echo "<div class='block'>";
        echo "<h2>Features</h2>";
        echo "<p>$features</p>";
        echo "</div>";
        
        // How to Run the Project Block
        echo "<div class='block'>";
        echo "<h2>How to Run the Project</h2>";
        echo "<p>$how_to_run</p>";
        echo "</div>";
        
        // Extra Description Block
        echo "<div class='block'>";
        echo "<h2>Extra Description</h2>";
        echo "<p>$extra_description</p>";
        echo "</div>";
        
// Download File Block
echo "<div class='block'>";
echo "<h2>Download File</h2>";
echo "<a href='download.php?project_id=$project_id' download>Download Project</a>";        
echo "</div>";

        
        // Project Preview Block (Placeholder)
        echo "<div class='block'>";
        echo "<h2>Project Preview</h2>";
        echo "<div class='image-scroll'>";
        // Display project images here if you have a way to associate them with the project
        // You may fetch and display images from the database or a file system
        // Add your image elements or logic here
        echo "</div>";
        echo "</div>";
    } else {
        // Project not found, you can handle this case, e.g., display an error message
        echo "Project not found.";
    }
} else {
    // Project_id not provided in the URL, you can handle this case as needed
    echo "Project ID is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS stylesheet here -->
    <link rel="stylesheet" href="post_card.css">
    <!-- Rest of your code... -->
</head>
<body>
    <!-- Rest of your HTML... -->
</body>
</html>