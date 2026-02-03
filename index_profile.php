<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: jnu_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Registration</title>
    <link rel="stylesheet" href="style_profile.css">
</head>
<body>

<div class="form-container">
    <h2>Profile Registration Form</h2>

    <form action="submit.php" method="post" onsubmit="return validateForm()">

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" readonly>


        <label for="school">School:</label>
        <input type="text" name="school" id="school" required>

        <label for="course">Course:</label>
        <input type="text" name="course" id="course" required>

        <label for="centre">Centre:</label>
        <input type="text" name="centre" id="centre" required>

        <label for="contact">Contact No:</label>
        <input type="text" name="contact" id="contact" placeholder="10-digit number" required>

        <label for="party_status">Are you affiliated with political party/club?</label>
        <select name="party_status" id="party_status" onchange="toggleParty()" required>
            <option value="">--Select--</option>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>

        <div id="partyAffiliationDiv" style="display:none;">
            <label for="party_affiliation">Specify:</label>
            <input type="text" name="party_affiliation" id="party_affiliation" >
             
        </div>

        <input type="submit" value="Submit Profile">
    </form>
</div>

<script src="script_profile.js"></script>
</body>
</html>