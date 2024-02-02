<?php
session_start();
require('db.php');

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$community = null; // Initialize the $community variable

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    $community_id = $_GET['id'];

    // Fetch community details from the database based on the 'id'
    $query = "SELECT c.*, d.description AS community_description FROM `communities` c
              LEFT JOIN `community_descriptions` d ON c.id = d.community_id
              WHERE c.id = $community_id";
    $result = mysqli_query($conn, $query);
    $community = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="community_style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $community['name'] ?? 'Community'; ?> Community
    </title>

    <!-- Add this script inside the <head> section of your HTML -->
    <script>
        function joinCommunity() {
            // Replace 'community_join.php' with the URL of the page you want to navigate to
            window.location.href = 'community_join.php?community_id=<?php echo $community_id; ?>';
        }
    </script>
</head>

<body>
    <div class="container">
        <header>
            <h1>
                <?php echo $community['name'] ?? 'Community'; ?> Community
            </h1>
        </header>

        <section class="community-details">
            <div class="community-card">

                <h2>
                    <?php echo $community['name'] ?? 'Community'; ?>
                </h2>
                <p>
                    <?php echo $community['community_description'] ?? 'Description not available'; ?>
                </p> <!-- Use the community_description field here -->
                <!-- Add an 'onclick' attribute to the button to call the JavaScript function -->
                <button onclick="joinCommunity()">Join</button>
            </div>
            <div class="community-actions">
                <!-- Add your community guidelines here following the structure you provided -->
                <!-- Add your community guidelines here following the structure you provided -->
                <h2>Community Guidelines</h2>
                <h3>Respect and Civility:</h3>
                <ul>
                    <li>Treat all members with respect and courtesy, regardless of their background or opinions.</li>
                    <li>Avoid offensive language, personal attacks, and harassment.</li>
                    <li>Engage in constructive and civil discussions, even when you disagree.</li>
                </ul>

                <h3>Stay On-Topic:</h3>
                <ul>
                    <li>Contribute to discussions and activities related to the community's main focus or topic.</li>
                    <li>Avoid posting unrelated or off-topic content.</li>
                </ul>

                <h3>No Spam or Self-Promotion:</h3>
                <ul>
                    <li>Refrain from spamming the community with unsolicited advertisements, promotions, or links.</li>
                    <li>Self-promotion is often allowed to some extent but should be done in a non-intrusive and
                        relevant manner.</li>
                </ul>
                <h3>Privacy and Confidentiality:</h3>
                <ul>
                    <li>Respect the privacy and confidentiality of other members.</li>
                    <li>Do not share personal information without consent.</li>
                </ul>
                <h3>Content Guidelines:</h3>
                <ul>
                    <li>Follow the community's guidelines regarding content, such as image, video, or text restrictions.
                    </li>
                    <li>Avoid posting explicit, offensive, or illegal content.</li>
                </ul>
                <h3>Quality Contributions:</h3>
                <ul>
                    <li>Strive to make meaningful contributions to discussions and activities.</li>
                    <li>Avoid one-word or low-effort responses.</li>
                </ul>
                <h3>Respect Moderators' Decisions:</h3>
                <ul>
                    <li>Accept and respect decisions made by community moderators.</li>
                    <li>If you have concerns, address them privately with moderators.</li>
                </ul>
                <h3>Reporting and Flagging:</h3>
                <ul>
                    <li>Report any inappropriate or rule-violating content to community moderators.</li>
                    <li>Use the reporting system responsibly, avoiding false reports.</li>
                </ul>
                <h3>No Multiple Accounts or Impersonation:</h3>
                <ul>
                    <li>Typically, communities discourage having multiple accounts for the same person.</li>
                    <li>Impersonating other members or using fake identities is usually prohibited.</li>
                </ul>
                <h3>Legal Compliance:</h3>
                <ul>
                    <li>Abide by local, national, and international laws when using the community platform.</li>
                    <li>Do not engage in illegal activities or share illegal content.</li>
                </ul>
                <h3>Participate and Contribute:</h3>
                <ul>
                    <li>Actively participate in the community by contributing ideas, knowledge, and experiences.</li>
                    <li>Help other members when you can and share your expertise.</li>
                </ul>
                <h3>Stay Informed:</h3>
                <ul>
                    <li>Familiarize yourself with the specific community guidelines and rules, as they may vary from one
                        community to another.</li>

                </ul>
                <h3>Temporary or Permanent Bans:</h3>
                <ul>
                    <li>Understand that violations of community guidelines may result in warnings, temporary
                        suspensions, or permanent bans.</li>
                </ul>

            </div>
        </section>
    </div>
</body>

</html>

