function toggleParty() {
    var status = document.getElementById("party_status").value;
    var partyDiv = document.getElementById("partyAffiliationDiv");
    var partyInput = document.getElementById("party_affiliation");

    if (status === "Yes") {
        partyDiv.style.display = "block";
        partyInput.required = true;
    } else {
        partyDiv.style.display = "none";
        partyInput.required = false;
        partyInput.value = "";
    }
}

function validateForm() {
    var name = document.getElementById("name").value.trim();
    var contact = document.getElementById("contact").value.trim();
    var status = document.getElementById("party_status").value;
    var party = document.getElementById("party_affiliation").value.trim();

    if (name === "") {
        alert("Please enter your name.");
        return false;
    }

    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(contact)) {
        alert("Please enter a valid 10-digit contact number.");
        return false;
    }

    if (status === "Yes" && party === "") {
        alert("Please specify your party affiliation.");
        return false;
    }

    // IMPORTANT: no success alert here
    return true;
}
