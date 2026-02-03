<?php
session_start();
$conn = new mysqli("localhost", "root", "", "registration");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM user_data WHERE email=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $_SESSION['user_id'] = $row['sno.'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];

    header("Location: host.php");
    exit;
} else {
    echo "Invalid credentials";
}
