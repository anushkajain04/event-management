<?php
require 'connect.php';

$sql = "SELECT event_name, event_date, event_time, venue, poster_path 
        FROM events 
        ORDER BY created_at DESC 
        LIMIT 10";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    $poster = (!empty($row['poster_path']) && file_exists($row['poster_path']))
                ? $row['poster_path']
                : "assets/default_event.jpg";

    echo '
    <li class="top">
        <a class="latest-event" href="#">
            <div class="event-card">
                <img class="latest-event-img" src="'.$poster.'">
                <div class="event-info">
                    <h3>'.htmlspecialchars($row['event_name']).'</h3>
                    <p>Date: '.date("d M Y", strtotime($row['event_date'])).'</p>
                    <p>Time: '.date("h:i A", strtotime($row['event_time'])).'</p>
                    <p>Venue: '.htmlspecialchars($row['venue']).'</p>
                </div>
            </div>
        </a>
    </li>';
}
?>
