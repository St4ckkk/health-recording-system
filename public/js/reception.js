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

const BASE_URL = '<?= BASE_URL ?>';

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

document.addEventListener('DOMContentLoaded', function () {
    // Get all appointment items
    const appointmentItems = document.querySelectorAll('.appointment-item');

    // Add click event to each appointment item
    appointmentItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all items
            appointmentItems.forEach(i => i.classList.remove('active'));

            // Add active class to clicked item
            this.classList.add('active');

            // Get patient ID from data attribute
            const patientId = this.getAttribute('data-patient');

            // Hide all patient details
            document.querySelectorAll('.patient-details').forEach(detail => {
                detail.classList.add('hidden');
            });

            // Show selected patient details
            const detailElement = document.getElementById(patientId + '-details');
            if (detailElement) {
                detailElement.classList.remove('hidden');
            }
        });
    });
});

// Cancellation Modal Functionality
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('cancellationModal');
    const modalContent = document.getElementById('modalContent');
    if (!modal || !modalContent) return; // Exit if modal doesn't exist

    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const form = document.getElementById('cancellationForm');
    const confirmBtn = document.getElementById('confirmCancelBtn');
    const reasonInputs = form.querySelectorAll('input[name="cancellation_reason"]');

    // Function to open the modal with smooth animation
    window.cancelAppointment = function (appointmentId) {
        document.getElementById('appointmentId').value = appointmentId;

        // Reset form
        form.reset();
        updateConfirmButton();

        // Show modal with animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Trigger reflow for animation
        void modal.offsetWidth;

        // Animate in
        modal.classList.add('opacity-100');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    };

    // Function to close the modal with smooth animation
    function closeModal() {
        // Animate out
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('opacity-100');

        // Wait for animation to complete
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');

            // Restore body scrolling
            document.body.style.overflow = '';
        }, 300);
    }

    // Close the modal when clicking the close button
    closeBtn.addEventListener('click', closeModal);

    // Close the modal when clicking the cancel button
    cancelBtn.addEventListener('click', closeModal);

    // Close the modal when clicking outside of it
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Update confirm button state based on form validity
    function updateConfirmButton() {
        let isReasonSelected = false;
        reasonInputs.forEach(input => {
            if (input.checked) {
                isReasonSelected = true;
            }
        });

        confirmBtn.disabled = !isReasonSelected;

        // Update button styling based on state
        if (isReasonSelected) {
            confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            confirmBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Add event listeners to radio buttons
    reasonInputs.forEach(input => {
        input.addEventListener('change', updateConfirmButton);
    });

    // Handle form submission
    confirmBtn.addEventListener('click', function () {
        const appointmentId = document.getElementById('appointmentId').value;
        let reason = '';
        reasonInputs.forEach(input => {
            if (input.checked) {
                reason = input.value;
            }
        });
        const details = document.getElementById('cancellation_details').value;

        // Show loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...';

        // Send AJAX request to cancel the appointment
        const xhr = new XMLHttpRequest();
        xhr.open('POST', BASE_URL + '/receptionist/cancel-appointment', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Close the modal
                        closeModal();

                        // Update the UI to reflect the cancelled appointment
                        const appointmentElement = document.querySelector(`[data-patient="patient-${appointmentId}"]`);
                        if (appointmentElement) {
                            const statusBadge = appointmentElement.querySelector('.status-badge');
                            if (statusBadge) {
                                statusBadge.className = 'status-badge cancelled';
                                statusBadge.innerHTML = '<i class="bx bx-x-circle mr-1"></i><span class="text-xs">Cancelled</span>';
                            }
                        }

                        // Show success message with toast if available, otherwise use alert
                        if (typeof showToast === 'function') {
                            showToast('success', 'Appointment cancelled successfully');
                        } else {
                            alert('Appointment cancelled successfully');
                        }

                        // Reload the page to reflect changes
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast('error', 'Failed to cancel appointment: ' + response.message);
                        } else {
                            alert('Failed to cancel appointment: ' + response.message);
                        }
                    }
                } catch (e) {
                    console.error(e);
                    if (typeof showToast === 'function') {
                        showToast('error', 'Error processing response');
                    } else {
                        alert('Error processing response');
                    }
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast('error', 'Request failed. Status: ' + xhr.status);
                } else {
                    alert('Request failed. Status: ' + xhr.status);
                }
            }

            // Reset button state
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Confirm Cancellation';
        };

        xhr.onerror = function () {
            if (typeof showToast === 'function') {
                showToast('error', 'Request failed. Please try again.');
            } else {
                alert('Request failed. Please try again.');
            }
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Confirm Cancellation';
        };

        xhr.send(JSON.stringify({
            appointmentId: appointmentId,
            reason: reason,
            details: details
        }));
    });
});