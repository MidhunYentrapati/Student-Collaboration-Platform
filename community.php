<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Fetch communities from the database
$query = "SELECT * FROM `communities`";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="community_style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communities</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Communities</h1>
            <a href="main_home.php" style="position: absolute; top: 20px; right: 20px; color: #fff; text-decoration: none; color: #66fcf1;"><b>Home</b></a><!-- Add the Home page navigation button here -->
        </header>

        <section class="community-grid" id="community-grid">
            <!-- Loop through communities and display them as cards -->
            <?php
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="community-card">
                    <img src="community_icons/<?php echo $row['icon_filename']; ?>" alt="Community Icon">
                    <h2><?php echo $row['name']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                    <a href="community_details.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
                <?php
                $count++;
                // Display a maximum of 4 communities per row
                if ($count % 4 == 0) {
                    echo '</div><div class="community-grid">';
                }
            endwhile;
            ?>
        </section>
    </div>

    <script>
        // JavaScript for infinite scrolling
        const communityGrid = document.getElementById('community-grid');

        function loadMoreCommunities() {
            // Simulate loading more communities from the server (you can replace this with an AJAX request)
            // For demonstration, let's assume you have fetched more communities from the server
            const moreCommunitiesHTML = `
                <!-- Insert more community cards here -->
                <!-- Example:
                <div class="community-card">
                    <!-- Community card content -->
                </div>
                -->
            `;

            // Append the new communities to the grid
            communityGrid.innerHTML += moreCommunitiesHTML;
        }

        // Detect when the user scrolls to the bottom of the page
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY || window.pageYOffset;
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const documentHeight = document.body.scrollHeight;

            if (scrollY + windowHeight >= documentHeight - 200) {
                // Load more communities when the user is near the bottom
                loadMoreCommunities();
            }
        });
    </script>
</body>
</html>
