<div id="appointmentDetails" class="card bg-white shadow-sm rounded-lg p-6 flex-1 fade-in">
    <div id="appointment-details-container" class="patient-details">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 id="patient-name" class="text-md font-medium text-gray-900">Loading...</h3>
                <p class="text-sm text-gray-400">Appointment Details</p>
            </div>
            <div class="flex gap-2">
                <span id="appointment-type" class="appointment-type checkup">Loading...</span>
                <span id="appointment-status" class="status-badge scheduled"
                    style="border-radius: 5px;">Loading...</span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <p class="detail-label font-medium">Ref #:</p>
                <p id="ref-number" class="detail-value">Loading...</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Patient #:</p>
                <p id="patient-id" class="detail-value">Loading...</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Date</p>
                <p id="appointment-date" class="detail-value">Loading...</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Time</p>
                <p id="appointment-time" class="detail-value">Loading...</p>
            </div>
        </div>

        <hr class="border-gray-200 my-6 mt-5 mb-4 space">

        <div class="">
            <p class="text-sm mb-2 font-medium">Appointment Information</p>
            <div class="ml-1">
                <table class="w-full border-collapse">
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Reason
                        </td>
                        <td id="appointment-reason" class="text-sm text-gray-900 py-2">Loading...</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                        </td>
                        <td id="appointment-location" class="text-sm text-gray-900 py-2">Loading...</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                        <td id="appointment-notes" class="text-sm text-gray-900 py-2">Loading...</td>
                    </tr>
                    <tr class="">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                        </td>
                        <td id="patient-insurance" class="text-sm text-gray-900 py-2">Loading...</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="border-gray-200 my-4">

        <div class="mb-6">
            <p class="text-sm mb-2 font-medium mb-2">Patient Contact Information</p>

            <div class="space-y-2">
                <p class="contact-info">
                    <i class="bx bx-phone text-gray-500 mr-2"></i>
                    <span id="patient-phone">Loading...</span>
                </p>
                <p class="contact-info">
                    <i class="bx bx-envelope text-gray-500 mr-2"></i>
                    <span id="patient-email">Loading...</span>
                </p>
            </div>
        </div>

        <div id="appointment-actions" class="flex gap-3 mt-6">
            <!-- Action buttons will be added dynamically based on appointment status -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to update action buttons based on appointment status
        function updateActionButtons(status) {
            const actionsContainer = document.getElementById('appointment-actions');
            actionsContainer.innerHTML = '';

            // Convert status to lowercase and trim any whitespace
            status = status.toLowerCase().trim();

            console.log("Current appointment status:", status);

            if (status === 'scheduled' || status === 'loading...') {
                actionsContainer.innerHTML = `
                    <div class="flex-1">
                        <button class="action-button border border-danger text-danger" onclick="cancelAppointment()">
                            <i class="bx bx-x-circle text-danger mr-2 text-md"></i>
                            Cancel Appointment
                        </button>
                    </div>
                    <button class="action-button secondary" onclick="confirmAppointment()">
                        <i class="bx bx-check-circle mr-2 text-md"></i>
                        Confirm
                    </button>
                    <button class="action-button secondary" onclick="sendReminder()">
                        <i class="bx bx-bell mr-2 text-md"></i>
                        Send Reminder
                    </button>
                `;
            } else if (status === 'no-show') {
                actionsContainer.innerHTML = `
                    <div class="flex-1">
                        <button class="action-button secondary" onclick="rescheduleAppointment()">
                            <i class="bx bx-calendar mr-2 text-md"></i>
                            Reschedule
                        </button>
                    </div>
                `;
            } else if (status === 'cancelled') {
                actionsContainer.innerHTML = `
                    <div class="flex-1">
                        <button class="action-button secondary" onclick="rescheduleAppointment()">
                            <i class="bx bx-calendar mr-2 text-md"></i>
                            Reschedule
                        </button>
                    </div>
                    <button class="action-button secondary border " onclick="confirmCancellation()">
                        <i class="bx bx-check-circle mr-2 text-md"></i>
                        Confirm Cancellation
                    </button>
                `;
            } else if (status === 'rescheduled') {
                actionsContainer.innerHTML = `
                    <div class="flex-1">
                        <button class="action-button secondary" onclick="confirmReschedule()">
                            <i class="bx bx-check-circle mr-2 text-md"></i>
                            Confirm Reschedule
                        </button>
                    </div>
                `;
            }

            // Add View Patient Record button for all statuses
            const viewRecordButton = document.createElement('button');
            viewRecordButton.className = 'action-button bg-gray-900';
            viewRecordButton.onclick = function () { viewPatientRecord(); };
            viewRecordButton.innerHTML = `
                <i class="bx bx-file mr-2 text-white text-md"></i>
                <span class="text-white">Patient Record</span>
            `;
            actionsContainer.appendChild(viewRecordButton);
        }

        // Add the action functions
        window.cancelAppointment = function () {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                // Update the status badge to show cancelled
                const statusBadge = document.getElementById('appointment-status');
                statusBadge.textContent = 'Cancelled';
                statusBadge.className = 'status-badge cancelled';

                // Update the buttons
                updateActionButtons('cancelled');

                alert('Appointment cancelled');
                // Update UI or make AJAX call to backend
            }
        };

        window.confirmAppointment = function () {
            if (confirm('Are you sure you want to confirm this appointment?')) {
                // Update the status badge to show confirmed
                const statusBadge = document.getElementById('appointment-status');
                statusBadge.textContent = 'Confirmed';
                statusBadge.className = 'status-badge confirmed';

                alert('Appointment confirmed');
                // Update UI or make AJAX call to backend
            }
        };

        window.sendReminder = function () {
            alert('Reminder sent to patient');
            // Make AJAX call to backend
        };

        window.rescheduleAppointment = function () {
            // Update the status badge to show rescheduled
            const statusBadge = document.getElementById('appointment-status');
            statusBadge.textContent = 'Rescheduled';
            statusBadge.className = 'status-badge rescheduled';

            // Update the buttons
            updateActionButtons('rescheduled');

            alert('Redirecting to reschedule page');
        };

        window.confirmCancellation = function () {
            if (confirm('Are you sure you want to confirm this cancellation?')) {
                alert('Cancellation confirmed');
                // Update UI or make AJAX call to backend
            }
        };

        window.confirmReschedule = function () {
            if (confirm('Are you sure you want to confirm this reschedule?')) {
                // Update the status badge to show confirmed
                const statusBadge = document.getElementById('appointment-status');
                statusBadge.textContent = 'Confirmed';
                statusBadge.className = 'status-badge confirmed';

                // Update the buttons
                updateActionButtons('confirmed');

                alert('Reschedule confirmed');
                // Update UI or make AJAX call to backend
            }
        };

        window.viewPatientRecord = function () {
            alert('Viewing patient record');
            // Redirect to patient record page
        };

        // Set up a function to initialize the buttons
        function initializeButtons() {
            const statusElement = document.getElementById('appointment-status');
            let statusText = statusElement.textContent.trim();

            // Check if the status is still loading
            if (statusText === 'Loading...') {
                // Wait a bit and try again
                setTimeout(initializeButtons, 500);
                return;
            }

            // Get status from class if possible
            let status = 'scheduled'; // Default
            if (statusElement.classList.contains('cancelled')) {
                status = 'cancelled';
            } else if (statusElement.classList.contains('no-show')) {
                status = 'no-show';
            } else if (statusElement.classList.contains('rescheduled')) {
                status = 'rescheduled';
            } else if (statusElement.classList.contains('confirmed')) {
                status = 'confirmed';
            } else {
                // Try to get from text content
                status = statusText.toLowerCase();
            }

            console.log("Detected status:", status);
            updateActionButtons(status);
        }

        // Initialize buttons when DOM is loaded
        initializeButtons();

        // Also set up a MutationObserver to watch for status changes
        const statusElement = document.getElementById('appointment-status');
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type === 'attributes' || mutation.type === 'childList') {
                    initializeButtons();
                }
            });
        });

        observer.observe(statusElement, {
            attributes: true,
            childList: true,
            characterData: true
        });
    });
</script>