<?php
require 'connect.php';

$event_id = $_POST['event_id'] ?? null;

$uploadDir = "uploads/gallery/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {

    $fileName = time() . "_" . basename($_FILES['photos']['name'][$key]);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $targetPath)) {
       $stmt = $conn->prepare(
    "INSERT INTO event_gallery (event_id, image_path) VALUES (?, ?)"
);
$stmt->bind_param("is", $event_id, $fileName);

        $stmt->execute();
    }
}

header("Location: host.php?upload=success");
exit;
