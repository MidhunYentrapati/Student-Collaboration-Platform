<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    $username = $_SESSION['username'];
    $college_name = $_POST["college_name"];
    $bio = $_POST["bio"];
    $dob = $_POST["dob"];
    
    // Check if a profile record for this user already exists
    $check_query = "SELECT * FROM user_profile WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // If no profile exists, insert a new record
        $insert_query = "INSERT INTO user_profile (username, dob, bio, college_name) VALUES ('$username', '$dob', '$bio', '$college_name')";
        $result = mysqli_query($conn, $insert_query);
    } else {
        // If a profile already exists, update the existing record
        $update_query = "UPDATE user_profile SET dob='$dob', bio='$bio', college_name='$college_name' WHERE username='$username'";
        $result = mysqli_query($conn, $update_query);
    }

    if ($result) {
        // Update session variables
        $_SESSION["college_name"] = $college_name;
        $_SESSION["bio"] = $bio;
        $_SESSION["dob"] = $dob;

        // Redirect back to the profile page after updating
        header("Location: start.php");
        exit();
    } else {
        die("Error updating profile: " . mysqli_error($conn));
    }
}
?>
<!-- Rest of your HTML for the edit_profile.php page -->


<!-- Rest of your HTML for the edit_profile.php page -->


<!-- Rest of your HTML for the edit_profile.php page -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_profile.css">
</head>
<body>

<div class="profile">
    <h1>Edit Profile</h1>
    <form method="POST" action="">
        <div id="clg_name">
        <!-- Add input fields for editing profile details (college_name, bio, dob) -->
        <label for="college_name">College Name:</label>
        <input type="text" name="college_name" value=""><br>
        </div>
        <div id="bio">
        <label for="bio">Bio:</label><br>
        <textarea name="bio" rows="5" cols="30"></textarea><br>
        </div>
        <div id="dateob">
        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" value=""><br>
        </div>
        <input type="submit" value="Save Changes">

    </form>

    <p><a href="start.php">Back to Profile</a></p>
</div>
</body>
</html>
