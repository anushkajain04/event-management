<?php
require 'connect.php';

$sql = "SELECT image_path FROM event_gallery ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo '<img src="uploads/gallery/'.$row['image_path'].'" class="gallery-img">';
}
