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


document.addEventListener('DOMContentLoaded', function () {
    // Clear filters functionality
    const clearFiltersBtn = document.querySelector('button[onclick="clearFilters()"]');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function () {
            document.getElementById('dateFilter').value = '';
            document.getElementById('typeFilter').selectedIndex = 0;
        });
    }

    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Appointment selection functionality
    const appointmentItems = document.querySelectorAll('.appointment-item');
    const patientDetails = document.querySelectorAll('.patient-details');

    appointmentItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all items
            appointmentItems.forEach(i => i.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Get patient identifier
            const patientId = this.getAttribute('data-patient');

            // Hide all patient details
            patientDetails.forEach(detail => detail.classList.add('hidden'));

            // Show selected patient details
            const selectedDetails = document.getElementById(`${patientId}-details`);
            if (selectedDetails) {
                selectedDetails.classList.remove('hidden');

                // Add fade-in animation
                selectedDetails.classList.add('fade-in');

                // Remove animation class after animation completes
                setTimeout(() => {
                    selectedDetails.classList.remove('fade-in');
                }, 300);
            }
        });
    });
});