<?php
require 'connect.php';
$id = $_GET['id'];
$event = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM events WHERE id=$id"));
?>

<h3>Edit Event</h3>
<form id="editForm">
<input type="hidden" name="id" value="<?= $id ?>">

<input name="event_name" value="<?= $event['event_name'] ?>" required>
<input type="date" name="event_date" value="<?= $event['event_date'] ?>" required>
<input type="time" name="event_time" value="<?= $event['event_time'] ?>" required>
<input name="venue" value="<?= $event['venue'] ?>" required>

<button>Update</button>
</form>

<script>
document.getElementById("editForm").onsubmit = e => {
    e.preventDefault();
    fetch("update_event.php", {
        method:"POST",
        body:new FormData(e.target)
    }).then(()=>location.reload());
};
</script>
