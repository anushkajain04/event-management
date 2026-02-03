function toggleGuest() {
    const val = document.getElementById('has_guest').value;
    const div = document.getElementById('guest_fields');
    div.classList.toggle('hidden', val === 'no');
}

function toggleLink() {
    const val = document.getElementById('has_reg_link').value;
    const div = document.getElementById('link_field');
    div.classList.toggle('hidden', val === 'no');
}