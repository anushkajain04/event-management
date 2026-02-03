<?php
session_start();
include "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header("Content-Type: application/json");

/* SAFETY */
if (!isset($_POST['action'])) {
    echo json_encode(["status" => "invalid_request"]);
    exit;
}

/* SEND OTP */
if ($_POST['action'] === "send") {

    $email = trim($_POST['email']);

    $stmt = mysqli_prepare($conn, "SELECT email FROM user_data WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) !== 1) {
        echo json_encode(["status" => "email_not_found"]);
        exit;
    }

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = (string)$otp;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'iamhorizon1253@gmail.com';
        $mail->Password = 'ktwc zaaq jtdu gudr';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('iamhorizon1253@gmail.com', 'JNU Event');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP';
        $mail->Body = "Your OTP is: $otp";

        $mail->send();

        echo json_encode(["status" => "otp_sent"]);
        exit;

    } catch (Exception $e) {
        echo json_encode(["status" => "mail_failed"]);
        exit;
    }
}

/* VERIFY OTP */
if ($_POST['action'] === "verify") {

    if (!isset($_SESSION['otp'])) {
        echo json_encode(["status" => "expired"]);
        exit;
    }

    if (trim($_POST['otp']) === $_SESSION['otp']) {
        echo json_encode(["status" => "success"]);
        

    } else {
        echo json_encode(["status" => "invalid"]);
    }
    exit;
}
