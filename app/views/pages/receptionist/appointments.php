<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
        .filter-section {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            padding: 1.25rem;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .filter-group {
                min-width: 100%;
            }

            .filter-actions {
                width: 100%;
                justify-content: stretch;
            }
        }

        /* Add styles for view transitions */
        .view-transition {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .hidden-view {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }

        .visible-view {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Back button styles */
        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .back-button:hover {
            background-color: #e5e7eb;
        }

        .back-button i {
            margin-right: 0.5rem;
        }

        /* Action buttons container */
        .action-buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Consistent button styling */
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 110px;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .action-button i {
            font-size: 1rem;
            margin-right: 0.375rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Status-specific button styles */
        .action-button.full-width {
            width: 100%;
        }

        .action-button.secondary {
            background-color: var(--neutral-light);
            color: var(--neutral-dark);
            border: 1px solid var(--neutral-light);
        }

        .action-button.secondary:hover {
            background-color: var(--neutral-lighter);
        }

        .action-button.danger {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border: 1px solid var(--danger-light);
        }

        .action-button.danger:hover {
            background-color: var(--danger-lighter);
        }

        /* Enhanced status badge styles using CSS variables - text color only */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-pill);
            font-size: var(--font-size-xs);
            font-weight: 500;
            text-transform: capitalize;
            border: 1px solid currentColor;
            background-color: transparent;
        }

        .status-badge.scheduled {
            color: var(--info-dark);
        }

        .status-badge.completed {
            color: var(--success-dark);
        }

        .status-badge.cancelled {
            color: var(--danger-dark);
        }

        .status-badge.no-show {
            color: var(--warning-dark);
        }

        .status-badge.pending {
            color: var(--primary-dark);
        }

        .status-badge.rescheduled {
            color: var(--warning-dark);
        }

        .status-badge.confirmed {
            color: var(--success-dark);
        }

        /* Keep the appointment type styles as they were */
        .appointment-type {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-pill);
            font-size: var(--font-size-xs);
            font-weight: 500;
            text-transform: capitalize;
        }

        .appointment-type.checkup {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .appointment-type.follow-up {
            background-color: var(--success-light);
            color: var(--success-dark);
        }

        .appointment-type.procedure {
            background-color: var(--warning-light);
            color: var(--warning-dark);
        }

        .appointment-type.specialist {
            background-color: var(--info-light);
            color: var(--info-dark);
        }

        .appointment-type.emergency {
            background-color: var(--danger-light);
            color: var(--danger-dark);
        }

        .appointment-type.consultation {
            background-color: var(--primary-blue-light);
            color: var(--primary-blue-dark);
        }

        /* Action button styles */
        .action-button.danger {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border-color: var(--danger-light);
        }

        .action-button.danger:hover {
            background-color: var(--danger-lighter);
        }

        /* Add pagination styles */
        .pagination-container {
            padding: 1rem 0;
            border-top: 1px solid var(--border-color, #e5e7eb);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.5rem;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .pagination-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-color, #374151);
            background-color: var(--bg-color, white);
            border: 1px solid var(--border-color, #e5e7eb);
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(.disabled):not(.active) {
            background-color: var(--hover-bg, #f3f4f6);
            border-color: var(--hover-border, #d1d5db);
        }

        .pagination-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-ellipsis {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
            color: var(--text-color, #374151);
            margin: 0 0.125rem;
        }

        .pagination-per-page {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-select {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color, #e5e7eb);
            font-size: 0.875rem;
            background-color: white;
            min-width: 4.5rem;
        }

        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                gap: 1rem;
            }

            .pagination-per-page {
                order: -1;
            }
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <!-- Patient App View (initially hidden) -->
                <div id="patientAppView" class="view-transition hidden-view">
                    <div class="p-6">
                        <button id="backToAppointments" class="back-button">
                            <i class="bx bx-arrow-back"></i> Back to Appointments
                        </button>
                        <?php include('components/patient_app.php') ?>
                    </div>
                </div>

                <div id="rescheduleAppView" class="view-transition hidden-view">
                    <div class="p-6">
                        <button id="backFromReschedule" class="back-button">
                            <i class="bx bx-arrow-back"></i> Back to Appointments
                        </button>
                        <?php include('components/reschedule_app.php') ?>
                    </div>
                </div>

                <!-- Appointments Overview (initially visible) -->
                <section id="appointmentsView" class="p-6 view-transition visible-view">
                    <!-- Header section -->
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Appointments</h2>
                        <p class="text-sm text-gray-500">View and manage appointments</p>
                    </div>
                    <div class="filter-section">
                        <!-- In the tab container section -->
                        <div class="tab-container mb-4">
                            <button
                                class="tab-button <?= $activeTab === 'upcoming' ? 'active' : '' ?>">Upcoming</button>
                            <button class="tab-button <?= $activeTab === 'past' ? 'active' : '' ?>">Past</button>
                            <button class="tab-button <?= $activeTab === 'all' ? 'active' : '' ?>">All</button>
                        </div>
                        <div class="filter-row">
                            <div class="filter-group" style="flex: 2;">
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search by patient name or ID..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Date Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Date Filter</p>
                                <div class="relative">
                                    <input type="text" id="dateFilter" placeholder="Select date"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 calendar-icon">
                                        <i class="bx bx-calendar text-gray-400"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Type Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Type Filter</p>
                                <div class="relative">
                                    <select id="typeFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>All Types</option>
                                        <option>Checkup</option>
                                        <option>Follow-up</option>
                                        <option>Procedure</option>
                                        <option>Specialist</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Clear Filters Button -->
                            <div>
                                <button
                                    class="flex items-center justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onclick="clearFilters()">
                                    <i class='bx bx-filter-alt mr-2 text-lg'></i>
                                    <span class="text-xs font-medium mr-2">
                                        Clear Filters
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table section -->
                    <div class="card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="p-4">
                            <table class="appointments-table">
                                <thead>
                                    <tr>
                                        <th>REF #</th>
                                        <th>Patient</th>
                                        <th>Date & Time</th>
                                        <th>Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($displayAppointments)):
                                        foreach ($displayAppointments as $appointment):
                                            ?>
                                            <tr>
                                                <td class="whitespace-nowrap">
                                                    <?= htmlspecialchars($appointment->reference_number) ?>
                                                </td>
                                                <td>
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="font-medium text-md"><?= htmlspecialchars($appointment->first_name . ' ' . $appointment->last_name) ?></span>
                                                        <span
                                                            class="patient-id text-xs text-gray-500"><?= htmlspecialchars($appointment->patient_id) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="flex flex-col">
                                                        <span><?= date('m/d/Y', strtotime($appointment->appointment_date)) ?></span>
                                                        <span
                                                            class="text-xs text-gray-500"><?= date('g:i A', strtotime($appointment->appointment_time)) ?></span>
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="appointment-type <?= strtolower($appointment->type) ?>"><?= htmlspecialchars($appointment->appointment_type) ?></span>
                                                </td>
                                                <td class="max-w-[200px] truncate"><?= htmlspecialchars($appointment->reason) ?>
                                                </td>
                                                <td><span
                                                        class="status-badge <?= strtolower($appointment->status) ?>"><?= ucfirst(htmlspecialchars($appointment->status)) ?></span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons-container">
                                                        <button class="action-button secondary view-patient-btn"
                                                            data-patient-id="<?= htmlspecialchars($appointment->patient_id) ?>"
                                                            data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                            <i class="bx bx-user"></i> View
                                                        </button>

                                                        <?php if ($appointment->status == 'scheduled' || $appointment->status == 'pending'): ?>
                                                            <button class="action-button danger"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-x-circle"></i> Cancel
                                                            </button>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'no-show'): ?>
                                                            <button class="action-button secondary"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-calendar-edit"></i> Reschedule
                                                            </button>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'cancelled'): ?>
                                                            <button class="action-button secondary"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-calendar-edit"></i> Reschedule
                                                            </button>
                                                            <button class="action-button secondary"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-check-circle"></i> Confirm
                                                            </button>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'rescheduled'): ?>
                                                            <button class="action-button secondary"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-check-circle"></i> Confirm
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No appointments found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <!-- Replace the simple "View All Appointments" link with a proper pagination component -->
                            <div class="pagination-container">
                                <div class="text-sm text-gray-500">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of
                                    <span class="font-medium">24</span> appointments
                                </div>
                                <div class="pagination-controls">
                                    <button class="pagination-btn disabled" disabled aria-label="Previous page">
                                        <i class="bx bx-chevron-left"></i>
                                    </button>
                                    <button class="pagination-btn active" aria-label="Page 1">1</button>
                                    <button class="pagination-btn" aria-label="Page 2">2</button>
                                    <button class="pagination-btn" aria-label="Page 3">3</button>
                                    <div class="pagination-ellipsis" aria-hidden="true">...</div>
                                    <button class="pagination-btn" aria-label="Page 5">5</button>
                                    <button class="pagination-btn" aria-label="Next page">
                                        <i class="bx bx-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="pagination-per-page">
                                    <span class="text-sm text-gray-500">Show</span>
                                    <select class="pagination-select" aria-label="Items per page">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                    </select>
                                    <span class="text-sm text-gray-500">per page</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/js/reception.js"></script>
    <script>
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
                    window.location.href = '<?= BASE_URL ?>/receptionist/appointments?tab=' + tabType;
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
            function showPatientDetails(patientId) {
                // Hide appointments view
                appointmentsView.classList.remove('visible-view');
                appointmentsView.classList.add('hidden-view');

                // Show patient app view
                patientAppView.classList.remove('hidden-view');
                patientAppView.classList.add('visible-view');

                // You can use patientId to load specific patient data if needed
                console.log('Viewing patient:', patientId);

                // Scroll to top
                window.scrollTo(0, 0);
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
                    const patientId = this.getAttribute('data-patient-id');
                    showPatientDetails(patientId);
                });
            });

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
    </script>
</body>

</html>