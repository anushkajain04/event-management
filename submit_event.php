<?php
session_start();

// Security check
if (!isset($_SESSION['user_id'])) {
    header("Location: jnu_login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "registration");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Ensure uploads directory exists
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // 2. File upload
    $file_name = time() . "_" . basename($_FILES["poster"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {

        // 3. Collect data
        $user_id = $_SESSION['user_id'];
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $venue = $_POST['venue'];
        $category = $_POST['category'];
        $about = $_POST['about_event'];
        $org = $_POST['organization'];
        $has_guest = $_POST['has_guest'];
        $g_name = $_POST['guest_name'] ?? "";
        $g_desig = $_POST['guest_designation'] ?? "";
        $has_link = $_POST['has_reg_link'];
        $link = $_POST['reg_link'] ?? "";
        $phone = $_POST['phone'];
        $social = $_POST['social_link'];

        // 4. Prepare SQL
        $sql = "INSERT INTO events (
            user_id, event_name, event_date, event_time, venue, category,
            about_event, organization, poster_path, has_guest,
            guest_name, guest_designation, has_reg_link, reg_link,
            phone, social_link
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "isssssssssssssss",
            $user_id,
            $event_name,
            $event_date,
            $event_time,
            $venue,
            $category,
            $about,
            $org,
            $target_file,
            $has_guest,
            $g_name,
            $g_desig,
            $has_link,
            $link,
            $phone,
            $social
        );

        // 5. Execute
        if ($stmt->execute()) {
            echo "
            <script>
                alert('Event created successfully');
                window.location.replace('host.php');
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Database error while creating event');
                window.history.back();
            </cript>
            ";
        }

        $stmt->close();
    } else {
        echo "
        <script>
            alert('File upload failed. Check folder permissions.');
            window.history.back();
        </script>
        ";
    }
}

$conn->close();
?>
