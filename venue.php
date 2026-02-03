<?php
session_start();
// Establish database connection
$conn = new mysqli("localhost", "root", "", "registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events grouped by venue
$sql = "SELECT * FROM events ORDER BY venue ASC, event_date DESC";
$result = $conn->query($sql);

$events_by_venue = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events_by_venue[$row['venue']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events by Venue - JNU Event Adda</title>
    <link rel="stylesheet" href="style_create.css">
    <style>
        body { 
            background: white; 
            padding: 20px; 
            margin: 0; 
            font-family: 'Segoe UI', sans-serif; 
        }

        .nav{
    width: 100vw;
    height: 50px;
    background-color: rgb(5, 48, 82);
}
.nav img{
    width: 30px;
    height: 30px;
    margin: 12px 0px 0px 20px;
    padding: 0px 45px;
}

        .venue-container { max-width: 1200px; margin: auto; }
        
        .venue-title { 
            color: #053052; 
            border-left: 5px solid #053052; 
            padding-left: 15px; 
            margin: 40px 0 20px; 
            text-transform: uppercase;
        }

        /* Horizontal Layout for Events */
        .event-grid { 
            display: flex; 
            flex-direction: row; 
            overflow-x: auto; 
            gap: 40px; 
            padding-bottom: 15px; 
        }
        
        /* Interactive Card Styling */
        .event-card { 
            min-width: 280px; 
            max-width: 280px;
            background: white; 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 6px 15px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease; 
            cursor: pointer;
        }
        .event-card:hover { transform: translateY(-5px); }
        .event-card img { width: 100%; height: 200px; object-fit: cover; }
        .event-details { padding: 15px; }
        .event-details h3 { margin: 0 0 10px; color: #053052; }

        /* Centered Modal Pop-up */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; top: 0; 
            width: 100%; height: 100%; 
            background-color: rgba(0,0,0,0.7); 
            backdrop-filter: blur(4px);
            align-items: center; /* Centering horizontally */
            justify-content: center; /* Centering vertically */
        }

        /* Modal Box - Does not cover the whole screen */
        .modal-content {
            background: white; 
            width: 80%; 
            max-width: 850px; /* Prevents covering the whole desktop */
            height: auto;
            max-height: 90vh; 
            display: flex; 
            border-radius: 15px; 
            overflow: hidden; 
            position: relative; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .modal-left { flex: 1; background: #000; display: flex; align-items: center; }
        .modal-left img { width: 100%; height: auto; max-height: 100%; object-fit: contain; }

        .modal-right { 
            flex: 1; 
            padding: 30px; 
            overflow-y: auto; 
            color: #333; 
        }

        .close-btn { 
            position: absolute; top: 15px; right: 20px; 
            font-size: 28px; font-weight: bold; color: #555; 
            cursor: pointer; z-index: 10;
        }

        .info-row { margin-bottom: 15px; }
        .info-label { font-weight: bold; color: #053052; font-size: 0.9rem; }
        .info-value { font-size: 1rem; margin-top: 3px; }

        /* Custom scrollbar for horizontal event list */
        .event-grid::-webkit-scrollbar { height: 8px; }
        .event-grid::-webkit-scrollbar-thumb { background: #053052; border-radius: 10px; }
    </style>
</head>
<body>

<div class="nav">
            <a href="jnu_event1.html" class="home">
                        <span>
                            <img src="Icons/left-arrow.png" alt="Home">
                        </span>
                    </a>
           
        </div>

<div class="venue-container">
    <h1 style="text-align:center; color:#053052;">Explore Events by Venue</h1>

    <?php foreach ($events_by_venue as $venue => $events): ?>
        <h2 class="venue-title">📍 <?php echo htmlspecialchars($venue); ?></h2>
        <div class="event-grid">
            <?php foreach ($events as $event): ?>
                <div class="event-card" onclick='openModal(<?php echo json_encode($event); ?>)'>
                    <img src="<?php echo htmlspecialchars($event['poster_path']); ?>" alt="Poster">
                    <div class="event-details">
                        <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                        <p>📅 <?php echo $event['event_date']; ?></p>
                        <p>⏰ <?php echo $event['event_time']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-left">
            <img id="modalImg" src="" alt="Event Poster">
        </div>
        <div class="modal-right">
            <h2 id="modalTitle" style="color:#053052; margin-top:0;"></h2>
            <hr>
            <div class="info-row">
                <span class="info-label">DATE & TIME</span>
                <div id="modalDateTime" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">VENUE</span>
                <div id="modalVenue" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">CATEGORY</span>
                <div id="modalCategory" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">ABOUT EVENT</span>
                <div id="modalAbout" class="info-value"></div>
            </div>
            <div class="info-row">
                <span class="info-label">ORGANISED BY</span>
                <div id="modalOrg" class="info-value"></div>
            </div>
            <div id="regLinkWrapper">
                <a id="modalRegLink" href="" target="_blank" 
                   style="display:block; text-align:center; padding:12px; background:#053052; color:white; text-decoration:none; border-radius:5px; margin-top:20px;">
                   Register Now
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(data) {
        document.getElementById('modalImg').src = data.poster_path;
        document.getElementById('modalTitle').innerText = data.event_name;
        document.getElementById('modalDateTime').innerText = data.event_date + " | " + data.event_time;
        document.getElementById('modalVenue').innerText = data.venue;
        document.getElementById('modalCategory').innerText = data.category;
        document.getElementById('modalAbout').innerText = data.about_event || "No description provided.";
        document.getElementById('modalOrg').innerText = data.organization;

        // Display registration link only if available
        const regLink = document.getElementById('modalRegLink');
        if(data.has_reg_link === "yes" && data.reg_link) {
            regLink.href = data.reg_link;
            document.getElementById('regLinkWrapper').style.display = "block";
        } else {
            document.getElementById('regLinkWrapper').style.display = "none";
        }

        document.getElementById('eventModal').style.display = "flex";
    }

    function closeModal() {
        document.getElementById('eventModal').style.display = "none";
    }

    // Close modal on outside click
    window.onclick = function(event) {
        let modal = document.getElementById('eventModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>