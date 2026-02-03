<?php $id=$_GET['id']; ?>
<h3>Delete Event?</h3>
<p>This action cannot be undone.</p>

<button onclick="del()">Yes, Delete</button>

<script>
function del(){
fetch("delete_event_action.php",{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"id=<?= $id ?>"
}).then(()=>location.reload());
}
</script>
