<?php
require 'connect.php';

$category = $_GET['category'] ?? '';

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM events WHERE category = ? ORDER BY event_date DESC"
);
mysqli_stmt_bind_param($stmt, "s", $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$eventCount = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($category) ?> Events</title>

<link rel="stylesheet" href="category (1).css">

<!-- 🔒 ISOLATED EVENT CARD STYLES (NO CONFLICT POSSIBLE) -->
<style>
/* wrapper */
.category-events-page .events-grid{
    width:90%;
    margin:40px auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

/* card */
.category-events-page .event-card{
    background:#ffffff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,.15);
}

/* image — FORCED */
.category-events-page .event-card img{
    width:100%;
    height:220px;
    object-fit:cover;
    display:block;
}

/* info */
.category-events-page .event-info{
    padding:15px;
}

.category-events-page .event-info h3{
    margin:0 0 8px;
    font-size:20px;
    color:rgb(5,48,82);
}

.category-events-page .event-info p{
    margin:4px 0;
    font-size:14px;
    color:#333;
}
</style>
</head>

<body class="category-events-page">

<div class="nav">
    <a href="category (1).html">
        <img src="Icons/left-arrow.png" alt="Back">
    </a>
</div>

<h1 class="category-heading">
    <?= htmlspecialchars($category) ?> Events
</h1>

<div class="events-grid">

<?php if ($eventCount === 0) { ?>

    <div style="grid-column:1/-1;text-align:center;font-size:22px;color:rgb(5,48,82)">
        No events yet in this category.
    </div>

<?php } else { ?>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    
<?php
$posterFile = trim($row['poster'] ?? '');

if ($posterFile !== '') {

    // If DB already contains uploads/ path, use it directly
    if (strpos($posterFile, 'uploads/') !== false) {
        $posterPath = $posterFile;
    } else {
        // Otherwise assume filename only
        $posterPath = "uploads/" . $posterFile;
    }

} else {
    // Only when no image was ever uploaded
    $posterPath = "assets/default_event.jpg";
}

    ?>

    <div class="event-card">
        <img src="<?= htmlspecialchars($posterPath) ?>" alt="Event image">

        <div class="event-info">
            <h3><?= htmlspecialchars($row['event_name']) ?></h3>
            <p><strong>Date:</strong> <?= htmlspecialchars($row['event_date']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($row['event_time']) ?></p>
            <p><strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?></p>
        </div>
    </div>

<?php } } ?>

</div>

</body>
</html>
