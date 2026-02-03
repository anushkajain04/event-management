function toggleParty() {
    var status = document.getElementById("party_status").value;
    var partyDiv = document.getElementById("partyAffiliationDiv");
    var partySelect = document.getElementById("party_affiliation");

    if (status === "Yes") {
        partyDiv.style.display = "block";
        partySelect.setAttribute('required', 'required');
    } else {
        partyDiv.style.display = "none";
        partySelect.removeAttribute('required');
        partySelect.value = ""; 
    }
}

function validateForm() {
    var name = document.getElementById("name").value.trim();
    var contact = document.getElementById("contact").value.trim();
    var status = document.getElementById("party_status").value;
    var party = document.getElementById("party_affiliation").value;

    if (name === "") {
        alert("Please enter your name.");
        return false;
    }

    // Ensures exactly 10 digits
    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(contact)) {
        alert("Please enter a valid 10-digit contact number.");
        return false;
    }

    if (status === "Yes" && party === "") {
        alert("Please select your party affiliation.");
        return false;
    }

    return true;
}