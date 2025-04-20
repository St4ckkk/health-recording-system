<?php
// Helper function to get the appropriate icon for each status
function getStatusIcon($status)
{
    $status = strtolower($status);

    if (strpos($status, 'cancelled') !== false) {
        return 'bx-x-circle';
    } elseif ($status == 'completed') {
        return 'bx-check-circle';
    } elseif ($status == 'scheduled') {
        return 'bx-time';
    } elseif ($status == 'confirmed') {
        return 'bx-calendar-check';
    } elseif ($status == 'no-show') {
        return 'bx-error-circle';
    } elseif ($status == 'pending') {
        return 'bx-hourglass';
    } elseif ($status == 'check-in') {
        return 'bx-log-in-circle';
    } elseif (strpos($status, 'rescheduled') !== false) {
        return 'bx-calendar-exclamation';
    } else {
        return 'bx-calendar';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
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

        /* Status badge alignment - only layout properties */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.15rem 0.5rem;
            border-radius: 0.375rem;
        }

        /* Appointment type alignment - only layout properties */
        .appointment-type {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
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
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger);
        }

        .action-button.danger:hover {
            background-color: var(--danger-light);
        }

        /* Add styles for view, reschedule and confirm buttons */
        .action-button.view {
            background-color: transparent;
            color: var(--info-dark);
            border: 1px solid var(--info);
        }

        .action-button.view:hover {
            background-color: var(--info-light);
        }

        .action-button.reschedule {
            background-color: transparent;
            color: var(--warning-dark);
            border: 1px solid var(--warning);
        }

        .action-button.reschedule:hover {
            background-color: var(--warning-light);
        }

        .action-button.confirm {
            background-color: transparent;
            color: var(--success-dark);
            border: 1px solid var(--success);
        }

        .action-button.confirm:hover {
            background-color: var(--success-light);
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

        .appointments-table thead th {
            background-color: var(--gray-50);
            color: var(--gray-700);
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
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

<body class="font-body bg-gray-50">
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
                            <a href="<?= BASE_URL ?>/receptionist/appointments?tab=upcoming"
                                class="tab-button <?= $activeTab === 'upcoming' ? 'active' : '' ?>">Upcoming</a>
                            <a href="<?= BASE_URL ?>/receptionist/appointments?tab=past"
                                class="tab-button <?= $activeTab === 'past' ? 'active' : '' ?>">Past</a>
                            <a href="<?= BASE_URL ?>/receptionist/appointments?tab=all"
                                class="tab-button <?= $activeTab === 'all' ? 'active' : '' ?>">All</a>
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
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">REF #</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Patient
                                        </th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Date & Time
                                        </th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Type</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Reason</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Status</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Actions
                                        </th>
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
                                                            class="patient-id text-xs text-gray-500"><?= htmlspecialchars($appointment->patient_reference_number ?? 'N/A') ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="flex flex-col">
                                                        <span><?= date('m/d/Y', strtotime($appointment->appointment_date)) ?></span>
                                                        <span
                                                            class="text-xs text-gray-500"><?= date('g:i A', strtotime($appointment->appointment_time)) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="appointment-type <?= strtolower(str_replace('-', '_', $appointment->appointment_type)) ?>">
                                                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $appointment->appointment_type))) ?>
                                                    </span>
                                                </td>
                                                <td class="text-xs"><?= htmlspecialchars($appointment->reason) ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    $status = $appointment->status;

                                                    // Determine the appropriate status class
                                                    switch ($status) {
                                                        case 'completed':
                                                            $statusClass = 'bg-green-100 text-green-800';
                                                            break;
                                                        case 'confirmed':
                                                            $statusClass = 'bg-green-100 text-green-800';
                                                            break;
                                                        case 'cancelled':
                                                        case 'cancelled_by_patient':
                                                        case 'cancelled_by_clinic':
                                                        case 'cancelled_auto':
                                                            $statusClass = 'bg-red-100 text-red-800';
                                                            $status = 'cancelled';
                                                            break;
                                                        case 'cancellation_requested':
                                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                                            break;
                                                        case 'no-show':
                                                        case 'no_show':
                                                            $statusClass = 'bg-red-100 text-red-800';
                                                            $status = 'no-show';
                                                            break;
                                                        case 'pending':
                                                            $statusClass = 'bg-blue-100 text-blue-800';
                                                            break;
                                                        case 'checked_in':
                                                        case 'check-in':
                                                            $statusClass = 'bg-blue-100 text-blue-800';
                                                            break;
                                                        case 'in_progress':
                                                            $statusClass = 'bg-blue-100 text-blue-800';
                                                            break;
                                                        case 'reschedule_requested':
                                                        case 'rescheduled':
                                                            $statusClass = 'bg-purple-100 text-purple-800';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-gray-100 text-gray-800';
                                                            break;
                                                    }

                                                    // Format the display status
                                                    $displayStatus = ucwords(str_replace('_', ' ', $status));
                                                    ?>
                                                    <span
                                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize <?= $statusClass ?>">
                                                        <?= $displayStatus ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <a href="<?= BASE_URL ?>/receptionist/appointment/details?id=<?= htmlspecialchars($appointment->id) ?>"
                                                                class="action-button view icon-only">
                                                                <i class="bx bx-show"></i>
                                                                <span class="tooltip-text">View Details</span>
                                                            </a>
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
    <script src="<?= BASE_URL ?>/js/receptionist/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/appointments.js"></script>
</body>

</html>