<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: jnu_login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "registration");
if ($conn->connect_error) {
    die("Database connection failed");
}

$user_id = $_SESSION['user_id'];

/* 1️⃣ Fetch signup data */
$userStmt = $conn->prepare("SELECT name, email FROM user_data WHERE `sno.` = ?");
$userStmt->bind_param("i", $user_id);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();

/* 2️⃣ Fetch profile data */
$profileStmt = $conn->prepare(
    "SELECT school, course, centre, contact, party_status, party_affiliation
     FROM profile WHERE user_id = ?"
);
$profileStmt->bind_param("i", $user_id);
$profileStmt->execute();
$profile = $profileStmt->get_result()->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Page</title>
    <link rel="stylesheet" href="host_style.css?v=<?= time(); ?>">

</head>
<body>
    <div class="profile-wrapper">
        <div class="nav">
            <a href="#" class="logo">
                        <span>
                            <img src="adda logo.png" alt="Event Adda">
                        </span>
                    </a>
            <span id="tabs">
                    <a href="jnu_event1.html">Home</a>
                    <a href="logout.php">logout</a>
            </span>
        </div>
        <div class="profile-card">
            <div class="avatar">
                <img src="no_pp3.jpg" alt="Default Avatar">
            </div>
                <a href="index_profile.php">
                <button class="edit">Edit Profile</button></a>
           
            <br>
            <div class="profile-details">
              <h2 class="name">
    <?php echo htmlspecialchars($user['name']); ?>
</h2>

<div class="contact">
    <p class="email">
        <?php echo htmlspecialchars($user['email']); ?>
    </p>
    <p class="phone">
        <?php echo htmlspecialchars($profile['contact'] ?? ''); ?>
    </p>
</div>

<div class="other">
    <p class="department">
        <?php echo htmlspecialchars($profile['school'] ?? ''); ?>
    </p>
    <p class="center">
        <?php echo htmlspecialchars($profile['centre'] ?? ''); ?>
    </p>
    <p class="course">
        <?php echo htmlspecialchars($profile['course'] ?? ''); ?>
    </p>
    <p class="party">
        <?php echo htmlspecialchars($profile['party_affiliation'] ?? ''); ?>
    </p>
</div>

                </div>
                <div id="choice">
    <button class="create" onclick="window.location.href='index_create.html'">
        Create Event
    </button>

    <button class="pasteve" onclick="window.location.href='show_events.php'">
        Show Events
    </button>

    <form  action="upload_gallery.php" method="POST" enctype="multipart/form-data" ">
    <input id="photo" type="file" name="photos[]" multiple required ">
    <button type="submit" class="upload_photo">Upload Photo</button>
</form>

</div>
                <script src="host_events.js"></script>
                
            </div>
            
        </div>
</body>
</html>

