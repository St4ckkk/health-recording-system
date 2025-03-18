document.addEventListener('DOMContentLoaded', function () {
    // Initialize flatpickr for date filter
    flatpickr("#dateFilter", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        locale: "en"
    });

    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            // Get the tab type
            const tabType = this.textContent.trim().toLowerCase();

            // Reload the page with the appropriate filter
            // Use the meta tag for base URL instead of PHP variable
            const baseUrl = document.querySelector('meta[name="base-url"]').content;
            window.location.href = `${baseUrl}/receptionist/appointments?tab=${tabType}`;
        });
    });

    // View switching functionality
    const appointmentsView = document.getElementById('appointmentsView');
    const patientAppView = document.getElementById('patientAppView');
    const rescheduleAppView = document.getElementById('rescheduleAppView');
    const viewButtons = document.querySelectorAll('.view-patient-btn');
    const backButton = document.getElementById('backToAppointments');
    const backFromRescheduleButton = document.getElementById('backFromReschedule');

    // Function to show patient details
    function showPatientDetails(appointmentId) {
        // Hide appointments view
        appointmentsView.classList.remove('visible-view');
        appointmentsView.classList.add('hidden-view');

        // Show patient app view
        patientAppView.classList.remove('hidden-view');
        patientAppView.classList.add('visible-view');

        // Fetch appointment details using AJAX
        fetch(`${document.querySelector('meta[name="base-url"]').content}/receptionist/getAppointmentDetails`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `appointmentId=${appointmentId}`
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        console.error('Response text:', text);
                        throw new Error('Invalid JSON response from server');
                    }
                });
            })
            .then(data => {
                // Populate the patient_app.php with the fetched data
                populateAppointmentDetails(data);
            })
            .catch(error => {
                console.error('Error fetching appointment details:', error);
                alert('Failed to load appointment details. Please try again.');
            });

        // Scroll to top
        window.scrollTo(0, 0);
    }

    // Function to populate appointment details in the patient_app.php view
    function populateAppointmentDetails(data) {
        console.log('Received data:', data);

        if (data.error) {
            console.error('Error from server:', data.error);
            alert('Error: ' + data.error);
            return;
        }

        // Extract patient data from appointment if patient data is not available
        let patientData = data.patient;
        if (!patientData || patientData === false) {
            console.log('Patient data not found, extracting from appointment');
            // Create patient object from appointment data
            patientData = {
                patient_id: data.appointment.patient_id,
                first_name: data.appointment.first_name,
                last_name: data.appointment.last_name,
                email: data.appointment.email,
                contact_number: data.appointment.contact_number,
                // Add any other patient fields you need
            };
        }

        // Get elements from patient_app.php
        const patientName = document.getElementById('patient-name');
        const patientId = document.getElementById('patient-id');
        const refNumber = document.getElementById('ref-number');
        const appointmentDate = document.getElementById('appointment-date');
        const appointmentTime = document.getElementById('appointment-time');
        const appointmentType = document.getElementById('appointment-type');
        const appointmentReason = document.getElementById('appointment-reason');
        const appointmentStatus = document.getElementById('appointment-status');
        const appointmentNotes = document.getElementById('appointment-notes');
        const appointmentLocation = document.getElementById('appointment-location');
        const patientPhone = document.getElementById('patient-phone');
        const patientEmail = document.getElementById('patient-email');
        const patientInsurance = document.getElementById('patient-insurance');

        // Populate elements with data
        if (patientName) patientName.textContent = `${patientData.first_name} ${patientData.last_name}`;
        if (patientId) patientId.textContent = patientData.patient_id || 'N/A';
        if (refNumber) refNumber.textContent = data.appointment.reference_number || 'N/A';

        // Format date
        if (appointmentDate) {
            const date = new Date(data.appointment.appointment_date);
            const formattedDate = date.toLocaleDateString('en-US', {
                month: '2-digit',
                day: '2-digit',
                year: 'numeric'
            });
            appointmentDate.textContent = formattedDate;
        }

        // Format time
        if (appointmentTime) {
            appointmentTime.textContent = data.appointment.appointment_time || 'N/A';
        }

        if (appointmentType) {
            appointmentType.textContent = data.appointment.type || 'Checkup';
            appointmentType.className = `appointment-type ${(data.appointment.type || 'checkup').toLowerCase()}`;
        }

        if (appointmentReason) appointmentReason.textContent = data.appointment.reason || 'N/A';

        if (appointmentStatus) {
            appointmentStatus.textContent = data.appointment.status ? data.appointment.status.charAt(0).toUpperCase() + data.appointment.status.slice(1) : 'Scheduled';
            appointmentStatus.className = `status-badge ${(data.appointment.status || 'scheduled').toLowerCase()}`;
        }

        if (appointmentNotes) appointmentNotes.textContent = data.appointment.special_instructions || 'No notes available';
        if (appointmentLocation) appointmentLocation.textContent = data.appointment.location || 'Main Clinic';
        if (patientPhone) patientPhone.textContent = data.patient ? data.patient.contact_number : 'N/A';
        if (patientEmail) patientEmail.textContent = data.patient ? data.patient.email : 'N/A';
        if (patientInsurance) patientInsurance.textContent = data.patient && data.patient.insurance ? data.patient.insurance : 'Not provided';

        // Update action buttons based on appointment status
        if (typeof updateActionButtons === 'function') {
            updateActionButtons(data.appointment.status || 'scheduled');
        }
    }

    // Function to show reschedule interface
    function showRescheduleInterface(appointmentId) {
        // Hide appointments view and patient view
        appointmentsView.classList.remove('visible-view');
        appointmentsView.classList.add('hidden-view');
        patientAppView.classList.remove('visible-view');
        patientAppView.classList.add('hidden-view');

        // Show reschedule view
        rescheduleAppView.classList.remove('hidden-view');
        rescheduleAppView.classList.add('visible-view');

        // You can use appointmentId to load specific appointment data if needed
        console.log('Rescheduling appointment:', appointmentId);

        // Scroll to top
        window.scrollTo(0, 0);
    }

    // Function to go back to appointments
    function showAppointments() {
        // Hide patient app view and reschedule view
        patientAppView.classList.remove('visible-view');
        patientAppView.classList.add('hidden-view');
        rescheduleAppView.classList.remove('visible-view');
        rescheduleAppView.classList.add('hidden-view');

        // Show appointments view
        appointmentsView.classList.remove('hidden-view');
        appointmentsView.classList.add('visible-view');

        // Scroll to top
        window.scrollTo(0, 0);
    }

    // Add click event to all view buttons
    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const appointmentId = this.getAttribute('data-appointment-id');
            const patientId = this.getAttribute('data-patient-id');
            showPatientDetails(appointmentId, patientId);
        });
    });

    // Function to show patient details
    function showPatientDetails(appointmentId, patientId) {
        // Hide appointments view
        appointmentsView.classList.remove('visible-view');
        appointmentsView.classList.add('hidden-view');

        // Show patient app view
        patientAppView.classList.remove('hidden-view');
        patientAppView.classList.add('visible-view');

        // Fetch appointment details using AJAX
        fetch(`${document.querySelector('meta[name="base-url"]').content}/receptionist/getAppointmentDetails`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `appointmentId=${appointmentId}&patientId=${patientId}`
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        console.error('Response text:', text);
                        throw new Error('Invalid JSON response from server');
                    }
                });
            })
            .then(data => {
                // Populate the patient_app.php with the fetched data
                populateAppointmentDetails(data);
            })
            .catch(error => {
                console.error('Error fetching appointment details:', error);
                alert('Failed to load appointment details. Please try again.');
            });

        // Scroll to top
        window.scrollTo(0, 0);
    }

    // Add click event to back buttons
    if (backButton) {
        backButton.addEventListener('click', showAppointments);
    }

    if (backFromRescheduleButton) {
        backFromRescheduleButton.addEventListener('click', showAppointments);
    }

    // Add event listener for reschedule buttons in patient details
    document.addEventListener('click', function (event) {
        // Check if the clicked element is a reschedule button
        if (event.target.matches('.action-button') &&
            event.target.textContent.includes('Reschedule') ||
            (event.target.closest('.action-button') &&
                event.target.closest('.action-button').textContent.includes('Reschedule'))) {

            // Get the button element (could be the target or its parent)
            const button = event.target.matches('.action-button') ?
                event.target :
                event.target.closest('.action-button');

            // Get the appointment ID from the data attribute
            const appointmentId = button.getAttribute('data-appointment-id');

            // Show the reschedule interface
            showRescheduleInterface(appointmentId);
        }
    });

    // Function to clear filters
    window.clearFilters = function () {
        document.getElementById('dateFilter').value = '';
        document.getElementById('typeFilter').selectedIndex = 0;
        // Reload the page without filters
        window.location.href = '<?= BASE_URL ?>/receptionist/appointments';
    }

    // Action functions
    window.cancelAppointment = function (appointmentId) {
        console.log('Cancelling appointment:', appointmentId);
        // Implement AJAX call to cancel appointment
    }

    // Add pagination functionality
    const paginationButtons = document.querySelectorAll('.pagination-btn');
    const paginationSelect = document.querySelector('.pagination-select');

    // Handle pagination button clicks
    paginationButtons.forEach(button => {
        if (!button.classList.contains('disabled')) {
            button.addEventListener('click', function () {
                // Remove active class from all buttons
                paginationButtons.forEach(btn => {
                    if (!btn.querySelector('i')) { // Skip the prev/next buttons
                        btn.classList.remove('active');
                    }
                });

                // If this is a numbered button (not prev/next), add active class
                if (!this.querySelector('i')) {
                    this.classList.add('active');
                }

                // Get the page number or direction
                const pageValue = this.textContent.trim();
                const isNext = this.querySelector('.bx-chevron-right');
                const isPrev = this.querySelector('.bx-chevron-left');

                let page = 1;

                if (isNext) {
                    // Get current active page and increment
                    const activePage = document.querySelector('.pagination-btn.active');
                    page = parseInt(activePage.textContent) + 1;
                } else if (isPrev) {
                    // Get current active page and decrement
                    const activePage = document.querySelector('.pagination-btn.active');
                    page = parseInt(activePage.textContent) - 1;
                } else {
                    page = parseInt(pageValue);
                }

                // Here you would typically load the data for the selected page
                console.log('Loading page:', page);

                // For demo purposes, we'll just update the "Showing X to Y" text
                const perPage = parseInt(paginationSelect.value);
                const start = (page - 1) * perPage + 1;
                const end = Math.min(start + perPage - 1, 24); // Assuming 24 total items

                document.querySelector('.pagination-container .text-sm.text-gray-500 span:nth-child(1)').textContent = start;
                document.querySelector('.pagination-container .text-sm.text-gray-500 span:nth-child(2)').textContent = end;

                // Update prev/next button states
                const prevButton = document.querySelector('.pagination-btn:first-child');
                const nextButton = document.querySelector('.pagination-btn:last-child');

                prevButton.disabled = page === 1;
                prevButton.classList.toggle('disabled', page === 1);

                nextButton.disabled = page === 5; // Assuming 5 total pages
                nextButton.classList.toggle('disabled', page === 5);
            });
        }
    });

    // Handle per-page selection change
    if (paginationSelect) {
        paginationSelect.addEventListener('change', function () {
            const perPage = parseInt(this.value);
            console.log('Items per page changed to:', perPage);

            // Here you would typically reload the data with the new per-page setting
            // For demo purposes, we'll just update the "Showing X to Y" text
            document.querySelector('.pagination-container .text-sm.text-gray-500 span:nth-child(2)').textContent =
                Math.min(perPage, 24); // Assuming 24 total items
        });
    }

    window.confirmAppointment = function (appointmentId) {
        console.log('Confirming appointment:', appointmentId);
        // Implement AJAX call to confirm appointment
    }

    window.sendReminder = function (appointmentId) {
        console.log('Sending reminder for appointment:', appointmentId);
        // Implement AJAX call to send reminder
    }

    window.rescheduleAppointment = function (appointmentId) {
        console.log('Rescheduling appointment:', appointmentId);
        showRescheduleInterface(appointmentId);
    }

    window.confirmCancellation = function (appointmentId) {
        console.log('Confirming cancellation for appointment:', appointmentId);
        // Implement AJAX call to confirm cancellation
    }

    window.confirmReschedule = function (appointmentId) {
        console.log('Confirming reschedule for appointment:', appointmentId);
        // Implement AJAX call to confirm reschedule
    }

    window.viewPatientRecord = function (appointmentId) {
        console.log('Viewing patient record for appointment:', appointmentId);
        // Implement navigation to patient record
    }
});