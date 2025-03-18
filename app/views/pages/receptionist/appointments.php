<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
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
        .action-button i {
            margin-right: 0.25rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
        }

        /* Action buttons container to ensure consistent spacing */
        .action-buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        /* Status badge alignment */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
        }

        /* Appointment type alignment */
        .appointment-type {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
        }

        /* Ensure text doesn't overflow */
        .max-w-reason {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Existing styles continue below */
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
            padding: 0.15rem 0.5rem;
            /* Reduced padding from 0.25rem 0.75rem */
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
            border: 1px solid currentColor;
            background-color: transparent;
        }

        .appointment-type.checkup {
            color: var(--primary);
        }

        .appointment-type.follow-up {
            color: var(--success-dark);
        }

        .appointment-type.procedure {
            color: var(--warning-dark);
        }

        .appointment-type.specialist {
            color: var(--info-dark);
        }

        .appointment-type.emergency {
            color: var(--danger-dark);
        }

        .appointment-type.consultation {
            color: var(--primary-blue-dark);
        }

        /* Action button styles */
        .action-button.danger {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger-dark);
        }

        .action-button.danger:hover {
            background-color: var(--danger-lighter);
        }

        /* Add styles for view, reschedule and confirm buttons */
        .action-button.view {
            background-color: transparent;
            color: var(--info-dark);
            border: 1px solid var(--info-dark);
        }

        .action-button.view:hover {
            background-color: var(--info-lighter);
        }

        .action-button.reschedule {
            background-color: transparent;
            color: var(--warning-dark);
            border: 1px solid var(--warning-dark);
        }

        .action-button.reschedule:hover {
            background-color: var(--warning-lighter);
        }

        .action-button.confirm {
            background-color: transparent;
            color: var(--success-dark);
            border: 1px solid var(--success-dark);
        }

        .action-button.confirm:hover {
            background-color: var(--success-lighter);
        }

        /* Add delete button style */
        .action-button.delete {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger-dark);
        }

        .action-button.delete:hover {
            background-color: var(--danger-lighter);
        }

        /* Icon-only button styles */
        .action-button.icon-only {
            width: 2rem;
            height: 2rem;
            padding: 0.375rem;
            position: relative;
        }

        .action-button.icon-only i {
            margin-right: 0;
            font-size: 1rem;
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: auto;
            min-width: 80px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.7rem;
            white-space: nowrap;
        }

        .tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: rgba(0, 0, 0, 0.8) transparent transparent transparent;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .calendar-icon {
            display: inline-flex;
            padding-left: 5.5rem;
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
                                        <i class="search bx bx-search text-gray-400"></i>
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

                            <!-- Date Filter (moved to the right) -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Date Filter</p>
                                <div class="relative">
                                    <input type="text" id="dateFilter" placeholder="Select date"
                                        class="filter-input w-full border rounded-md px-3 py-2 pr-9 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 calendar-icon">
                                        <i class="bx bx-calendar text-gray-400"></i>
                                    </span>
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
                                                <td class="text-xs">
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
                                                <td class="text-xs"><?= htmlspecialchars($appointment->reason) ?>
                                                </td>
                                                <td><span
                                                        class="status-badge <?= strtolower($appointment->status) ?>"><?= ucfirst(htmlspecialchars($appointment->status)) ?></span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <button class="action-button view icon-only view-patient-btn"
                                                                data-patient-id="<?= htmlspecialchars($appointment->patient_id) ?>"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-show"></i>
                                                                <span class="tooltip-text">View Details</span>
                                                            </button>
                                                        </div>

                                                        <!-- Add delete button -->
                                                        <div class="tooltip">
                                                            <button
                                                                class="action-button delete icon-only delete-appointment-btn"
                                                                data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                <i class="bx bx-trash"></i>
                                                                <span class="tooltip-text">Delete</span>
                                                            </button>
                                                        </div>

                                                        <?php if ($appointment->status == 'scheduled' || $appointment->status == 'pending'): ?>
                                                            <div class="tooltip">
                                                                <button class="action-button danger icon-only"
                                                                    data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                    <i class="bx bx-x-circle"></i>
                                                                    <span class="tooltip-text">Cancel Appointment</span>
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'no-show'): ?>
                                                            <div class="tooltip">
                                                                <button class="action-button reschedule icon-only"
                                                                    data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                    <i class="bx bx-calendar-edit"></i>
                                                                    <span class="tooltip-text">Reschedule Appointment</span>
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'cancelled'): ?>
                                                            <div class="tooltip">
                                                                <button class="action-button reschedule icon-only"
                                                                    data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                    <i class="bx bx-calendar-edit"></i>
                                                                    <span class="tooltip-text">Reschedule</span>
                                                                </button>
                                                            </div>
                                                            <div class="tooltip">
                                                                <button class="action-button confirm icon-only"
                                                                    data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                    <i class="bx bx-check-circle"></i>
                                                                    <span class="tooltip-text">Confirm</span>
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if ($appointment->status == 'rescheduled'): ?>
                                                            <div class="tooltip">
                                                                <button class="action-button confirm icon-only"
                                                                    data-appointment-id="<?= htmlspecialchars($appointment->id) ?>">
                                                                    <i class="bx bx-check-circle"></i>
                                                                    <span class="tooltip-text">Confirm</span>
                                                                </button>
                                                            </div>
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
                        </div>
                    </div>


                </section>
                <!-- Table section -->

            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/js/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/appointments.js"></script>
</body>

</html>