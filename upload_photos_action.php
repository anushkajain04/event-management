<?php
require 'connect.php';

$event_id=$_POST['event_id'];
$count=count($_FILES['photos']['name']);
if($count>10) exit;

for($i=0;$i<$count;$i++){
    $name=time().$_FILES['photos']['name'][$i];
    move_uploaded_file($_FILES['photos']['tmp_name'][$i],"uploads/$name");
    mysqli_query($conn,"INSERT INTO event_photos(event_id,photo) VALUES($event_id,'$name')");
}

echo json_encode(["status"=>"uploaded"]);
