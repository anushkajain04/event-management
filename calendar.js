// ------------------------------
//  EVENT DATA (ADD YOUR EVENTS HERE)
// ------------------------------
const events = {
    "2025-01-10": [
        { img: "event1.jpg", title: "Cultural Fest" },
        { img: "event2.jpg", title: "Music Night" }
    ],
    "2025-01-15": [
        { img: "event3.jpg", title: "Sports Meet" }
    ],
    "2025-02-05": [
        { img: "event4.jpg", title: "Workshop" }
    ]
};

// ------------------------------
// CALENDAR LOGIC
// ------------------------------
let currentYear = new Date().getFullYear();
let currentMonth = new Date().getMonth();

const monthYear = document.getElementById("monthYear");
const calendarBody = document.getElementById("calendarBody");
const selectedDate = document.getElementById("selectedDate");
const eventGrid = document.getElementById("eventGrid");

const months = [
    "January","February","March","April","May","June",
    "July","August","September","October","November","December"
];

function generateCalendar() {
    calendarBody.innerHTML = "";

    monthYear.textContent = `${months[currentMonth]} ${currentYear}`;

    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    let totalDays = new Date(currentYear, currentMonth + 1, 0).getDate();

    let row = document.createElement("tr");

    for (let i = 0; i < firstDay; i++) {
        row.appendChild(document.createElement("td"));
    }

    for (let day = 1; day <= totalDays; day++) {
        if ((firstDay + day - 1) % 7 === 0) {
            calendarBody.appendChild(row);
            row = document.createElement("tr");
        }

        let cell = document.createElement("td");
        cell.textContent = day;

        let today = new Date();
        if (
            day === today.getDate() &&
            currentMonth === today.getMonth() &&
            currentYear === today.getFullYear()
        ) {
            cell.classList.add("today");
        }

        cell.addEventListener("click", () => showEvents(day));

        row.appendChild(cell);
    }

    calendarBody.appendChild(row);
}

function showEvents(day) {
    let month = currentMonth + 1;
    let dateString = `${currentYear}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

    selectedDate.textContent = dateString;

    eventGrid.innerHTML = "";

    if (events[dateString]) {
        events[dateString].forEach(ev => {
            let card = document.createElement("div");
            card.classList.add("event-card");
            card.innerHTML = `<img src="${ev.img}"><h3>${ev.title}</h3>`;
            eventGrid.appendChild(card);
        });
    } else {
        eventGrid.innerHTML = `<div class="no-events">No events on this date.</div>`;
    }
}

// ------------------------------
// YEAR & MONTH BUTTONS
// ------------------------------
document.getElementById("prevMonth").addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar();
});

document.getElementById("nextMonth").addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar();
});

document.getElementById("prevYear").addEventListener("click", () => {
    currentYear--;
    generateCalendar();
});

document.getElementById("nextYear").addEventListener("click", () => {
    currentYear++;
    generateCalendar();
});

// Load Calendar
generateCalendar();
