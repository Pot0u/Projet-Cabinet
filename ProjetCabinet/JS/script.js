function toggleFilterForm() {
    var filterForm = document.getElementById("filForm");
    filterForm.style.display = (filterForm.style.display === "none") ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("toggleFilter").addEventListener("change", toggleFilterForm);
});

function toggleFilter() {
    var filterForm = document.getElementById("filForm");
    filterForm.style.display = (filterForm.style.display === "none" || filterForm.style.display === "") ? "block" : "none";
}

function resetForm() {
    document.getElementById("filForm").reset();
    window.location.href = window.location.pathname;  // Recharge la page actuelle
}
