<?php
session_start();

// Block unauthenticated access
if (!isset($_SESSION['user_id'])) {
    header("Location: jnu_login.html");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "registration";

// DB connection
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logged-in user
$user_id = $_SESSION['user_id'];

// POST data
$name    = $_POST['name']; // read-only from session user
$school  = $_POST['school'];
$course  = $_POST['course'];
$centre  = $_POST['centre'];
$contact = $_POST['contact'];
$party_status = $_POST['party_status'];
$party_affiliation = ($party_status === 'Yes') ? $_POST['party_affiliation'] : NULL;

/*
  OPTIONAL but RECOMMENDED:
  Prevent duplicate profile entries
*/
$check = mysqli_prepare($conn, "SELECT id FROM profile WHERE user_id = ?");
mysqli_stmt_bind_param($check, "i", $user_id);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    // Update existing profile
    $sql = "UPDATE profile SET
            school=?, course=?, centre=?, contact=?, party_status=?, party_affiliation=?
            WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $school,
        $course,
        $centre,
        $contact,
        $party_status,
        $party_affiliation,
        $user_id
    );
} else {
    // Insert new profile
    $sql = "INSERT INTO profile
            (user_id, name, school, course, centre, contact, party_status, party_affiliation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isssssss",
        $user_id,
        $name,
        $school,
        $course,
        $centre,
        $contact,
        $party_status,
        $party_affiliation
    );
}

// Execute
if (mysqli_stmt_execute($stmt)) {
    echo "
    <script>
        alert('Profile completed successfully');
        window.location.replace('host.php');
    </script>
    ";
} else {
    echo "
    <script>
        alert('Error saving profile. Please try again.');
        window.history.back();
    </script>
    ";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
