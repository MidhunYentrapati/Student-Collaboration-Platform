<?php while ($row = mysqli_fetch_assoc($result)): ?>

<div class="post">
    <!-- User Profile Picture and Username -->
    <div class="user-info">
        <div class="user-circle">
            <img src="profile_picture.jpg" alt="Profile Picture">
        </div>
        <p><b style="font-family: cursive;"><?php echo $row['username']; ?></b></p>
    </div>

    <!-- Post Content -->
    <div class="post-content">
        <!-- Title -->
        <h2>Title: <?php echo $row['projecttitle']; ?></h2>

        <!-- Description -->
        <p class="project-description">
            <?php
            // Display the first 2 lines of project description
            $description = $row['projectDescription'];
            $descriptionLines = explode("\n", $description);
            echo $descriptionLines[0] . "<br>" . $descriptionLines[1];
            ?>
            <span class="ellipsis">...</span>
        </p>

        <!-- Tech Stack -->
        <div class="tech-stack">
            <?php
            // Display the first 3 tech stack items
            $techStack = explode(",", $row['techStack']);
            for ($i = 0; $i < min(3, count($techStack)); $i++) {
                echo '<span class="tech-item">' . trim($techStack[$i]) . '</span>';
            }
            ?>
        </div>
    </div>

    <!-- Save Post Option -->
    <div class="save-post">
        <button>Save</button>
    </div>
</div>

<!-- Right side of the post layout (image, date, etc.) remains unchanged -->
<div class="post-item2">
    <img class="imgpos" src="images/img1.jpg" alt="">
    <p>Post Date: <?php echo $row['post_date']; ?></p>
</div>

<?php endwhile; ?>