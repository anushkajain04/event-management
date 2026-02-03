// CREATE EVENT
document.getElementById("createEventBtn").onclick = function () {
    window.location.href = "index_create.html";
};

// SHOW EVENTS
document.getElementById("showEventsBtn").onclick = function () {
    fetch("fetch_events.php")
        .then(res => res.text())
        .then(data => {
            document.getElementById("eventsContainer").innerHTML = data;
        });
};
