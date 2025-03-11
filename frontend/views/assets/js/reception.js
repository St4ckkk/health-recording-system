flatpickr("#dateFilter", {
    dateFormat: "d/m/Y",
    allowInput: true,
    disableMobile: "true",
    altInput: true,
    altFormat: "F j, Y",
    nextArrow: '<i class="bx bx-chevron-right"></i>',
    prevArrow: '<i class="bx bx-chevron-left"></i>',
    onChange: function (selectedDates, dateStr) {
        console.log("Selected date:", dateStr);
    }
});

function clearFilters() {
    document.getElementById('dateFilter').value = '';
    const dateFilterInstance = document.getElementById('dateFilter')._flatpickr;
    if (dateFilterInstance) {
        dateFilterInstance.clear();
    }
    document.getElementById('typeFilter').value = '';
}