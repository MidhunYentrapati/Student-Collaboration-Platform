<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="start.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul style="text-align: left;">
                    <li><a href="main_home.php" style="color: #66fcf1;">Home</a></li>
                    <li><a href="post_content.php" style="color: #66fcf1;">Post Content</a></li>
                    <!-- Add more links as needed -->
                    <li><a href="welcome.php" style="color: #66fcf1;">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="profile-section">
                <div>
                    <img src="images/img5.jpg" width="300px" alt="">
                </div>
                <?php
                session_start();
                require('db.php');

                if (!isset($_SESSION["username"])) {
                    header("Location: index.php");
                    exit();
                }

                $username = $_SESSION["username"];
                $college_name = $_SESSION["college_name"] ?? '';
                $bio = $_SESSION["bio"] ?? '';
                $dob = $_SESSION["dob"] ?? '';

                // Fetch user details from the database
                $query = "SELECT * FROM `users` WHERE `username`='$username'";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    // Display user details
                    echo "<h1>Welcome, {$row['username']}</h1>";
                    echo "<p>Email: {$row['Email']}</p>";

                    // Display additional details
                    echo "<h2>Additional Details</h2>";
                    echo "<p>College Name: $college_name</p>";
                    echo "<p>Bio: $bio</p>";
                    echo "<p>Date of Birth: $dob</p>";

                    // Add a link to edit profile
                    echo "<p><a class='edit-link' href='edit_profile.php'>Edit Profile</a></p>";
                } else {
                    echo "<p>User not found.</p>";
                }
                ?>
            </section>
        </main>
    </div>
</body>
</html>
