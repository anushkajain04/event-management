<?php
require 'connect.php';
$id=$_POST['id'];
mysqli_query($conn,"DELETE FROM events WHERE id=$id");
echo json_encode(["status"=>"deleted"]);
