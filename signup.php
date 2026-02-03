<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // STEP 1 — check if email already exists
    $check = "SELECT * FROM user_data WHERE email = '$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email already registered! Please use another email.');
                window.location='jnu_login.html';
              </script>";
        exit;
    }

    // STEP 2 — insert new user
    $sql = "INSERT INTO user_data (name, email, password) 
            VALUES ('$name', '$email', '$pass')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registration Successful!');
                window.location='jnu_login.html';
              </script>";
    } else {
        echo "Database Error: " . $conn->error;
    }

    $conn->close();
}
?>
