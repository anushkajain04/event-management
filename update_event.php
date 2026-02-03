<?php
require 'connect.php';

$id=$_POST['id'];
$name=$_POST['event_name'];
$date=$_POST['event_date'];
$time=$_POST['event_time'];
$venue=$_POST['venue'];

mysqli_query($conn,"UPDATE events SET 
event_name='$name',
event_date='$date',
event_time='$time',
venue='$venue'
WHERE id=$id");

echo json_encode(["status"=>"updated"]);
