<?php
session_start();

// Block unauthenticated access
if (!isset($_SESSION['user_id'])) {
    header("Location: jnu_login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "registration");
if ($conn->connect_error) {
    die("Database connection failed");
}

$user_id = $_SESSION['user_id'];

// Fetch ONLY logged-in user's events
$sql = "SELECT * FROM events WHERE user_id = ? ORDER BY event_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Events</title>
<link rel="stylesheet" href="host_style.css">

<style>
.events-wrapper {
    max-width: 1000px;
    margin: 40px auto;
}

.event-container {
    display: flex;
    gap: 40px;
    padding: 10px;
    margin-left: 40px;
    margin-bottom: 2px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.event-image img {
    width: 220px;
    height: 100%;
    object-fit: cover;
    border-radius: 3px;
}

.event-details {
    flex: 1;
}

.back-btn {
    display: inline-block;
    margin-bottom: 20px;
    color: white;
    font-size: 20px;
}

h4{
    color:white;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top:200px;
}
h2{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
</head>

<body>

<div class="events-wrapper">

    <a href="host.php" class="back-btn">← Back to Profile</a>
    <h2 style="color: white">My Events</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

    <div class="event-container">

        <div class="event-image">
            <img src="<?php echo (!empty($row['poster_path']) ? htmlspecialchars($row['poster_path']) : 'assets/default_event.jpg'); ?>" alt="Event Poster">
        </div>

        <div class="event-details">

            <h3><?php echo htmlspecialchars($row['event_name']); ?></h3>

            <?php if (!empty($row['about_event'])) { ?>
                <p><?php echo nl2br(htmlspecialchars($row['about_event'])); ?></p>
            <?php } ?>

            <p>
                <b>Date:</b> <?php echo $row['event_date']; ?> |
                <?php echo $row['event_time']; ?>
            </p>

            <?php if (!empty($row['venue'])) { ?>
                <p><b>Venue:</b> <?php echo htmlspecialchars($row['venue']); ?></p>
            <?php } ?>

            <?php if (!empty($row['category'])) { ?>
                <p><b>Category:</b> <?php echo htmlspecialchars($row['category']); ?></p>
            <?php } ?>

            <?php if (!empty($row['organization'])) { ?>
                <p><b>Organised By:</b> <?php echo htmlspecialchars($row['organization']); ?></p>
            <?php } ?>

            <?php if ($row['has_guest'] === 'yes' && !empty($row['guest_name'])) { ?>
                <p>
                    <b>Guest:</b>
                    <?php echo htmlspecialchars($row['guest_name']); ?>
                    <?php if (!empty($row['guest_designation'])) { ?>
                        (<?php echo htmlspecialchars($row['guest_designation']); ?>)
                    <?php } ?>
                </p>
            <?php } ?>

            <?php if ($row['has_reg_link'] === 'yes' && !empty($row['reg_link'])) { ?>
                <p>
                    <a href="<?php echo htmlspecialchars($row['reg_link']); ?>" target="_blank">
                        Registration Link
                    </a>
                </p>
            <?php } ?>

            <?php if (!empty($row['phone'])) { ?>
                <p><b>Contact:</b> <?php echo htmlspecialchars($row['phone']); ?></p>
            <?php } ?>

            <?php if (!empty($row['social_link'])) { ?>
                <p>
                    <a href="<?php echo htmlspecialchars($row['social_link']); ?>" target="_blank">
                        Social Media Link
                    </a>
                </p>
            <?php } ?>

        </div>

    </div>

<?php
    }
} else {
    echo "<h4>No events created by you yet.</h4>";
}

$stmt->close();
$conn->close();
?>

</div>

</body>
</html>
