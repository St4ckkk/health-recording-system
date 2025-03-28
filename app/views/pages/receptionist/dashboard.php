<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/receptionist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/receptionist/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Image Header for Receptionist Dashboard -->
                    <div class="image-header">
                        <img src="<?= BASE_URL ?>/images/receptionist-header.png" class="image-header-bg"
                            alt="Reception Desk">
                        <div class="image-header-overlay"></div>
                        <div class="image-header-pattern"></div>
                        <div class="image-header-content">
                            <h1 class="image-header-title">Receptionist Dashboard</h1>
                            <p class="image-header-subtitle">Efficiently manage patient appointments and schedules</p>

                            <div class="image-header-stats">
                                <div class="stat-item">
                                    <div class="stat-number"><?= $stats['today'] ?></div>
                                    <div class="stat-label">Today's Appointments</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?= $stats['pending'] ?></div>
                                    <div class="stat-label">Pending Appointments</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?= $stats['cancelled'] ?></div>
                                    <div class="stat-label">Cancelled Appointments</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <!-- Upcoming Appointments -->
                        <!-- Fix for the appointment type issue in the upcoming appointments section -->
                        <div class="card card-upcoming bg-white shadow-md rounded-lg p-4 w-full max-w-full fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Upcoming Appointments</h3>
                            <p class="text-sm text-gray-500">Future scheduled visits</p>
                            <div class="mt-2 space-y-6">
                                <?php if (!empty($upcomingAppointments)): ?>
                                    <?php foreach (array_slice($upcomingAppointments, 0, 2) as $index => $appointment): ?>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-gray-900">Dr. <?= $appointment->doctor_first_name ?>
                                                    <?= $appointment->doctor_last_name ?>
                                                </p>
                                                <p class="text-sm text-gray-500 capitalize">
                                                    <?= $appointment->appointment_type ?? 'General appointment' ?>
                                                </p>
                                            </div>
                                            <span class="badge-upcoming text-white px-3 py-1 rounded text-xs">
                                                <?= date('M d', strtotime($appointment->appointment_date)) ?>,
                                                <?= date('h:i A', strtotime($appointment->appointment_time)) ?>
                                            </span>
                                        </div>
                                        <?php if ($index < count(array_slice($upcomingAppointments, 0, 2)) - 1): ?>
                                            <hr class="border-gray-200 my-2">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No upcoming appointments</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Fix for Today's Appointments section -->
                        <div class="card card-today bg-white shadow-md rounded-lg p-4 w-full max-w-full fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Today's Appointments</h3>
                            <p class="text-sm text-gray-500">Current day's appointments</p>
                            <div class="mt-2 space-y-6">
                                <?php if (!empty($todayAppointments)): ?>
                                    <?php foreach (array_slice($todayAppointments, 0, 2) as $index => $appointment): ?>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-gray-900">Dr. <?= $appointment->doctor_first_name ?>
                                                    <?= $appointment->doctor_last_name ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <?= $appointment->reason ?? 'General appointment' ?>
                                                </p>
                                            </div>
                                            <span class="badge-today text-white px-3 py-1 rounded text-xs">
                                                Today, <?= date('h:i A', strtotime($appointment->appointment_time)) ?>
                                            </span>
                                        </div>
                                        <?php if ($index < count(array_slice($todayAppointments, 0, 2)) - 1): ?>
                                            <hr class="border-gray-200 my-2">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No appointments today</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Fix for Past Appointments section -->
                        <div class="card card-past bg-white shadow-md rounded-lg p-4 w-full max-w-full fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Past Appointments</h3>
                            <p class="text-sm text-gray-500">Previously completed visits</p>
                            <div class="mt-2 space-y-6">
                                <?php if (!empty($pastAppointments)): ?>
                                    <?php foreach (array_slice($pastAppointments, 0, 2) as $index => $appointment): ?>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-gray-900">Dr. <?= $appointment->doctor_first_name ?>
                                                    <?= $appointment->doctor_last_name ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <?= $appointment->reason ?? 'General appointment' ?>
                                                </p>
                                            </div>
                                            <span class="badge-past text-white px-3 py-1 rounded text-xs">
                                                <?= date('M d', strtotime($appointment->appointment_date)) ?>,
                                                <?= date('h:i A', strtotime($appointment->appointment_time)) ?>
                                            </span>
                                        </div>
                                        <?php if ($index < count(array_slice($pastAppointments, 0, 2)) - 1): ?>
                                            <hr class="border-gray-200 my-2">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No past appointments</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="p-6">
                    <div class="flex gap-6 w-full">
                        <!-- Left: Appointment List -->
                        <div class="card shadow-sm rounded-lg w-[450px] fade-in">
                            <div class="p-4">
                                <h2 class="text-md font-medium">Appointments</h2>
                                <p class="text-sm text-gray-400">View and manage patient appointments</p>

                                <div class="relative w-full mt-3">
                                    <input type="text" placeholder="Search by patient name or ID..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="bx bx-search text-gray-400"></i>
                                    </span>
                                </div>

                                <div class="tab-container">
                                    <button class="tab-button active">Upcoming</button>
                                    <button class="tab-button">Past</button>
                                    <button class="tab-button">All</button>
                                </div>

                                <div class="filter-container flex justify-between gap-2">
                                    <div class="w-full">
                                        <p class="filter-label text-xs font-medium mb-1">Date Filter</p>
                                        <div class="relative">
                                            <input type="text" id="dateFilter" placeholder="Select date"
                                                class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 calendar-icon"
                                                style="padding-left: 3rem;">
                                                <i class="bx bx-calendar text-gray-400"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="w-full">
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
                                </div>

                                <div class="mt-2">
                                    <button
                                        class="flex items-center justify-center w-full px-2 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onclick="clearFilters()">
                                        <i class='bx bx-filter-alt mr-1 text-lg'></i>
                                        <span class="text-xs font-medium">
                                            Clear Filters
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <div class="appointment-list-container">
                                <?php if (!empty($allAppointments)): ?>
                                    <?php foreach ($allAppointments as $index => $appointment): ?>
                                        <div class="appointment-item <?= $index === 0 ? 'active' : '' ?>"
                                            data-patient="patient-<?= $appointment->id ?>">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="text-gray-900 font-medium">
                                                        <?= htmlspecialchars($appointment->first_name) ?>
                                                        <?= htmlspecialchars($appointment->last_name) ?>
                                                    </h4>
                                                    <p class="text-xs text-gray-500">
                                                        <?= htmlspecialchars($appointment->patient_id) ?>
                                                    </p>
                                                    <div class="flex items-center mt-2">
                                                        <i class="bx bx-calendar text-gray-400 text-sm mr-1"></i>
                                                        <span
                                                            class="text-sm"><?= date('l, F j, Y', strtotime($appointment->appointment_date)) ?></span>
                                                        <span class="mx-2 text-sm mr-1 ml-2">•</span>
                                                        <i class="bx bx-time text-gray-400 text-sm mr-1"></i>
                                                        <span
                                                            class="text-sm"><?= date('h:i A', strtotime($appointment->appointment_time)) ?></span>
                                                    </div>
                                                </div>

                                                <?php
                                                // Define valid appointment types
                                                $validTypes = [
                                                    'checkup',
                                                    'follow_up',
                                                    'consultation',
                                                    'treatment',
                                                    'emergency',
                                                    'specialist',
                                                    'vaccination',
                                                    'laboratory_test',
                                                    'medical_clearance'
                                                ];

                                                $appointmentType = $appointment->appointment_type ?? $appointment->type ?? 'checkup';
                                                if (!in_array($appointmentType, $validTypes)) {
                                                    $appointmentType = 'checkup';
                                                }
                                                ?>

                                                <span class="appointment-type <?= strtolower($appointmentType) ?>">
                                                    <?= ucwords(str_replace('_', ' ', $appointmentType)) ?>
                                                </span>
                                            </div>

                                            <div>
                                                <?php
                                                // Define status classes and icons
                                                $statusMapping = [
                                                    'completed' => ['class' => 'completed', 'icon' => 'bx-check-circle'],
                                                    'cancelled' => ['class' => 'cancelled', 'icon' => 'bx-x-circle'],
                                                    'cancelled_by_clinic' => ['class' => 'cancelled', 'icon' => 'bx-x-circle'],
                                                    'cancellation_requested' => ['class' => 'cancellation_requested', 'icon' => 'bx-time', 'label' => 'Cancellation Waiting For Confirmation'],
                                                    'no-show' => ['class' => 'no-show', 'icon' => 'bx-error-circle'],
                                                    'pending' => ['class' => 'pending', 'icon' => 'bx-hourglass'],
                                                    'confirmed' => ['class' => 'confirmed', 'icon' => 'bx-calendar-check'],
                                                    'checked-in' => ['class' => 'checked-in', 'icon' => 'bx-log-in-circle'],
                                                    'in_progress' => ['class' => 'in_progress', 'icon' => 'bx-hourglass'],
                                                    'rescheduled' => ['class' => 'rescheduled', 'icon' => 'bx-calendar-exclamation'],
                                                    'reschedule_requested' => ['class' => 'rescheduled', 'icon' => 'bx-time', 'label' => 'Reschedule Waiting For Confirmation'],
                                                ];

                                                $statusInfo = $statusMapping[$appointment->status] ?? $statusMapping['checked-in'];
                                                $statusLabel = $statusInfo['label'] ?? ucwords(str_replace('_', ' ', $appointment->status));
                                                ?>

                                                <span class="status-badge <?= $statusInfo['class'] ?>">
                                                    <i class="bx <?= $statusInfo['icon'] ?> mr-1"></i>
                                                    <span class="text-xs"><?= $statusLabel ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-4 text-center">
                                        <p class="text-gray-500">No appointments found</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Cancellation Modal -->
                        <div id="cancellationModal"
                            class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
                            <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
                                id="modalContent">
                                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">Cancel Appointment</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                        id="closeModal">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>

                                <div class="px-6 py-4">
                                    <p class="mb-4 text-sm text-gray-500">Please select a reason for cancellation:</p>

                                    <form id="cancellationForm" class="space-y-3">
                                        <input type="hidden" id="appointmentId" name="appointmentId" value="">

                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="cancellation_reason"
                                                        value="schedule_conflict" class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Schedule Conflict</span>
                                                        <span class="text-xs text-gray-500">Patient has another
                                                            appointment</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="cancellation_reason"
                                                        value="patient_request" class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Patient Request</span>
                                                        <span class="text-xs text-gray-500">Patient requested to
                                                            cancel</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="cancellation_reason"
                                                        value="doctor_unavailable" class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Doctor
                                                            Unavailable</span>
                                                        <span class="text-xs text-gray-500">Doctor not available</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="cancellation_reason"
                                                        value="medical_reason" class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Medical Reason</span>
                                                        <span class="text-xs text-gray-500">Medical circumstances</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                            <label class="flex cursor-pointer items-start">
                                                <input type="radio" name="cancellation_reason" value="other"
                                                    class="mt-1 mr-2">
                                                <div>
                                                    <span class="block text-sm font-medium">Other Reason</span>
                                                    <span class="text-xs text-gray-500">Please specify in details</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="cancellation_details"
                                                class="block text-sm font-medium text-gray-700 mb-1">Additional
                                                Details:</label>
                                            <textarea id="cancellation_details" name="cancellation_details" rows="2"
                                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                                placeholder="Please provide any additional information..."></textarea>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                                    <button type="button" id="cancelModalBtn"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Cancel
                                    </button>
                                    <button type="button" id="confirmCancelBtn"
                                        class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none"
                                        disabled>
                                        Confirm Cancellation
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation Modal -->
                        <div id="confirmationModal"
                            class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
                            <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
                                id="confirmModalContent">
                                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">Confirm Appointment</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                        id="closeConfirmModal">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>

                                <div class="px-6 py-4">
                                    <p class="mb-4 text-sm text-gray-500">Are you sure you want to confirm this
                                        appointment?</p>

                                    <form id="confirmationForm" class="space-y-3">
                                        <input type="hidden" id="confirmAppointmentId" name="appointmentId" value="">

                                        <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                            <label class="flex cursor-pointer items-start">
                                                <input type="checkbox" name="send_confirmation" value="1"
                                                    class="mt-1 mr-2" checked>
                                                <div>
                                                    <span class="block text-sm font-medium">Send confirmation to
                                                        patient</span>
                                                    <span class="text-xs text-gray-500">Patient will receive an email
                                                        notification</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="confirmation_notes"
                                                class="block text-sm font-medium text-gray-700 mb-1">Additional
                                                Notes:</label>
                                            <textarea id="confirmation_notes" name="confirmation_notes" rows="2"
                                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                                placeholder="Add any special instructions or notes..."></textarea>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                                    <button type="button" id="cancelConfirmBtn"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Cancel
                                    </button>
                                    <button type="button" id="confirmAppointmentBtn"
                                        class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                                        Confirm Appointment
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Approve Cancellation Modal -->
                        <div id="approveCancellationModal"
                            class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
                            <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
                                id="approveCancellationModalContent">
                                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">Approve Cancellation Request</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                        id="closeApproveCancellationModal">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>

                                <div class="px-6 py-4">
                                    <p class="mb-4 text-sm text-gray-500">Are you sure you want to approve this
                                        cancellation request?</p>

                                    <form id="approveCancellationForm" class="space-y-3">
                                        <input type="hidden" id="approveCancellationAppointmentId" name="appointmentId"
                                            value="">

                                        <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                            <label class="flex cursor-pointer items-start">
                                                <input type="checkbox" name="send_cancellation_confirmation" value="1"
                                                    class="mt-1 mr-2" checked>
                                                <div>
                                                    <span class="block text-sm font-medium">Send confirmation to
                                                        patient</span>
                                                    <span class="text-xs text-gray-500">Patient will receive an email
                                                        notification</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="approve_cancellation_notes"
                                                class="block text-sm font-medium text-gray-700 mb-1">Additional
                                                Notes:</label>
                                            <textarea id="approve_cancellation_notes" name="approve_cancellation_notes"
                                                rows="2"
                                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                                placeholder="Add any notes about this cancellation..."></textarea>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                                    <button type="button" id="cancelApproveCancellationBtn"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Cancel
                                    </button>
                                    <button type="button" id="confirmApproveCancellationBtn"
                                        class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                                        Approve Cancellation
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Deny Cancellation Modal -->
                        <div id="denyCancellationModal"
                            class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
                            <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
                                id="denyCancellationModalContent">
                                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">Deny Cancellation Request</h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                        id="closeDenyCancellationModal">
                                        <i class="bx bx-x text-2xl"></i>
                                    </button>
                                </div>

                                <div class="px-6 py-4">
                                    <p class="mb-4 text-sm text-gray-500">Please provide a reason for denying this
                                        cancellation request:</p>

                                    <form id="denyCancellationForm" class="space-y-3">
                                        <input type="hidden" id="denyCancellationAppointmentId" name="appointmentId"
                                            value="">

                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="denial_reason" value="late_notice"
                                                        class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Late Notice</span>
                                                        <span class="text-xs text-gray-500">Request received too
                                                            late</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="denial_reason" value="policy_violation"
                                                        class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Policy Violation</span>
                                                        <span class="text-xs text-gray-500">Against clinic policy</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="denial_reason" value="medical_necessity"
                                                        class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Medical Necessity</span>
                                                        <span class="text-xs text-gray-500">Appointment is
                                                            necessary</span>
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                                <label class="flex cursor-pointer items-start">
                                                    <input type="radio" name="denial_reason" value="other"
                                                        class="mt-1 mr-2">
                                                    <div>
                                                        <span class="block text-sm font-medium">Other Reason</span>
                                                        <span class="text-xs text-gray-500">Please specify below</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                                            <label class="flex cursor-pointer items-start">
                                                <input type="checkbox" name="send_denial_notification" value="1"
                                                    class="mt-1 mr-2" checked>
                                                <div>
                                                    <span class="block text-sm font-medium">Send notification to
                                                        patient</span>
                                                    <span class="text-xs text-gray-500">Patient will receive an email
                                                        notification</span>
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            <label for="denial_details"
                                                class="block text-sm font-medium text-gray-700 mb-1">Additional
                                                Details:</label>
                                            <textarea id="denial_details" name="denial_details" rows="2"
                                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                                                placeholder="Please provide additional information about this denial..."></textarea>
                                        </div>
                                    </form>
                                </div>

                                <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                                    <button type="button" id="cancelDenialBtn"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Cancel
                                    </button>
                                    <button type="button" id="confirmDenialBtn"
                                        class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none"
                                        disabled>
                                        Confirm Denial
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Appointment Details -->
                        <div id="appointmentDetails" class="card bg-white shadow-sm rounded-lg p-6 flex-1 fade-in">
                            <?php if (!empty($allAppointments)): ?>
                                <?php foreach ($allAppointments as $index => $appointment): ?>
                                    <div id="patient-<?= $appointment->id ?>-details"
                                        class="patient-details <?= $index === 0 ? '' : 'hidden' ?>">
                                        <div class="flex justify-between items-center mb-6">
                                            <div>
                                                <h3 class="text-md font-medium text-gray-900"><?= $appointment->first_name ?>
                                                    <?= $appointment->last_name ?>
                                                </h3>
                                                <p class="text-sm text-gray-400">Appointment Details</p>
                                            </div>
                                            <div class="flex gap-2">
                                                <?php

                                                $validTypes = ['checkup', 'follow_up', 'consultation', 'treatment', 'emergency', 'vaccination', 'laboratory_test', 'medical_clearance'];

                                                $statusClass = '';
                                                switch ($appointment->status) {
                                                    case 'completed':
                                                        $statusClass = 'border-success text-success';
                                                        break;
                                                    case 'confirmed':
                                                        $statusClass = 'border-success text-success';
                                                        break;
                                                    case 'cancelled_by_patient':
                                                    case 'cancelled_by_clinic':
                                                    case 'cancelled_auto':
                                                        $statusClass = 'border-danger text-danger';
                                                        break;
                                                    case 'cancellation_requested':
                                                        $statusClass = 'border-warning text-warning';
                                                        break;
                                                    case 'no_show':
                                                        $statusClass = 'border-danger text-danger';
                                                        break;
                                                    case 'pending':
                                                        $statusClass = 'border-info text-info';
                                                        break;
                                                    case 'checked_in':
                                                        $statusClass = 'border-primary text-primary';
                                                        break;
                                                    case 'in_progress':
                                                        $statusClass = 'border-primary text-primary';
                                                        break;
                                                    case 'reschedule_requested':
                                                        $statusClass = 'border-warning text-warning';
                                                        break;
                                                    case 'rescheduled':
                                                        $statusClass = 'border-warning text-warning';
                                                        break;
                                                    default:
                                                        $statusClass = 'border-primary text-primary';
                                                        break;
                                                }
                                                ?>
                                                <span
                                                    class="appointment-type <?= strtolower($appointmentType) ?> px-2 py-2"><?= ucwords(str_replace('_', ' ', $appointmentType)) ?>
                                                </span>
                                                <span
                                                    class="status-badge border <?= $statusClass ?> px-1 py-1 rounded text-sm status">
                                                    <?php
                                                    $displayStatus = $appointment->status ?? 'completed';
                                                    if (strpos($displayStatus, 'cancelled') !== false) {
                                                        $displayStatus = 'Cancelled';
                                                    } else {
                                                        $displayStatus = ucwords(str_replace('_', ' ', $displayStatus));
                                                    }
                                                    echo $displayStatus;
                                                    ?>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="detail-grid">
                                            <div class="detail-section">
                                                <p class="detail-label">Date</p>
                                                <p class="detail-value">
                                                    <?= date('l, F j, Y', strtotime($appointment->appointment_date)) ?>
                                                </p>
                                            </div>
                                            <div class="detail-section">
                                                <p class="detail-label">Time</p>
                                                <p class="detail-value">
                                                    <?= date('h:i A', strtotime($appointment->appointment_time)) ?>
                                                </p>
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
                                                        <td class="text-sm text-gray-900 py-2">
                                                            <?= $appointment->reason ?? 'General appointment' ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-b border-gray-200">
                                                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                                                        </td>
                                                        <td class="text-sm text-gray-900 py-2">
                                                            <?= $appointment->location ?? 'Main Clinic' ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-b border-gray-200">
                                                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                                                        <td class="text-sm text-gray-900 py-2">
                                                            <?= $appointment->special_instructions ?? 'No notes available' ?>
                                                        </td>
                                                    </tr>

                                                    <tr class="">
                                                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                        </td>
                                                        <td class="text-sm text-gray-900 py-2">
                                                            <?= $appointment->insurance_provider ?? 'Not specified' ?>
                                                            <?= !empty($appointment->insurance_id) ? '#' . $appointment->insurance_id : '' ?>
                                                        </td>
                                                    </tr>

                                                    <?php if ($appointment->status == 'cancelled_by_clinic' && (!empty($appointment->cancellation_reason) || !empty($appointment->cancellation_details))): ?>
                                                        <tr class="border-b border-gray-200">
                                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">
                                                                Cancellation Reason</td>
                                                            <td class="text-sm text-gray-900 py-2">
                                                                <?= $appointment->cancellation_reason ?? 'No reason provided' ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="border-b border-gray-200">
                                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">
                                                                Cancellation Details</td>
                                                            <td class="text-sm text-gray-900 py-2">
                                                                <?= $appointment->cancellation_details ?? 'No details available' ?>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                        </div>

                                        <hr class="border-gray-200 my-4">

                                        <div class="mb-6">
                                            <p class="text-sm mb-2 font-medium mb-2">Patient Contact Information</p>

                                            <div class="space-y-2">
                                                <p class="contact-info">
                                                    <i class="bx bx-phone text-gray-500 mr-2"></i>
                                                    <?= $appointment->contact_number ?? 'Not available' ?>
                                                </p>
                                                <p class="contact-info">
                                                    <i class="bx bx-envelope text-gray-500 mr-2"></i>
                                                    <?= $appointment->email ?? 'Not available' ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex gap-3 mt-6">
                                            <?php if ($appointment->status == 'pending'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-danger text-danger"
                                                        onclick="cancelAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-x-circle mr-2 text-md"></i>
                                                        Cancel Appointment
                                                    </button>
                                                </div>
                                                <button class="action-button border border-success text-success"
                                                    onclick="confirmAppointment(<?= $appointment->id ?>)">
                                                    <i class="bx bx-check-circle mr-2 text-md"></i>
                                                    Confirm
                                                </button>
                                                <button class="action-button border border-warning text-warning"
                                                    onclick="sendReminder(<?= $appointment->id ?>)">
                                                    <i class="bx bx-bell mr-2 text-md"></i>
                                                    Send Reminder
                                                </button>
                                            <?php elseif ($appointment->status == 'no_show'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-warning text-warning"
                                                        onclick="sendReminder(<?= $appointment->id ?>)">
                                                        <i class="bx bx-bell mr-2 text-md"></i>
                                                        Send Reminder
                                                    </button>
                                                </div>
                                            <?php elseif (in_array($appointment->status, ['cancelled_by_patient', 'cancelled_by_clinic', 'cancelled_auto'])): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-info text-info"
                                                        onclick="rescheduleAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-calendar mr-2 text-md"></i>
                                                        Reschedule
                                                    </button>
                                                </div>
                                            <?php elseif ($appointment->status == 'cancellation_requested'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-success text-success"
                                                        onclick="approveCancellation(<?= $appointment->id ?>)">
                                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                                        Approve Cancellation
                                                    </button>
                                                </div>
                                                <button class="action-button border border-danger text-danger"
                                                    onclick="denyCancellation(<?= $appointment->id ?>)">
                                                    <i class="bx bx-x-circle mr-2 text-md"></i>
                                                    Deny Cancellation
                                                </button>
                                            <?php elseif ($appointment->status == 'reschedule_requested' || $appointment->status == 'rescheduled'): ?>

                                                <?php if ($appointment->status == 'reschedule_requested'): ?>
                                                    <button class="action-button border border-success text-success"
                                                        onclick="approveReschedule(<?= $appointment->id ?>)">
                                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                                        Approve Reschedule
                                                    </button>
                                                    <button class="action-button border border-danger text-danger"
                                                        onclick="denyReschedule(<?= $appointment->id ?>)">
                                                        <i class="bx bx-x-circle mr-2 text-md"></i>
                                                        Deny Reschedule
                                                    </button>
                                                <?php endif; ?>
                                            <?php elseif ($appointment->status == 'confirmed'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-primary text-primary"
                                                        onclick="checkInPatient(<?= $appointment->id ?>)">
                                                        <i class="bx bx-log-in-circle mr-2 text-md"></i>
                                                        Check In Patient
                                                    </button>
                                                </div>
                                                <button class="action-button border border-warning text-warning"
                                                    onclick="sendReminder(<?= $appointment->id ?>)">
                                                    <i class="bx bx-bell mr-2 text-md"></i>
                                                    Send Reminder
                                                </button>
                                            <?php elseif ($appointment->status == 'checked_in'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-primary text-primary"
                                                        onclick="startAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-play-circle mr-2 text-md"></i>
                                                        Start Appointment
                                                    </button>
                                                </div>
                                            <?php elseif ($appointment->status == 'in_progress'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button border border-success text-success"
                                                        onclick="completeAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                                        Complete Appointment
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                            <button class="action-button bg-gray-900"
                                                onclick="viewPatientRecord(<?= $appointment->id ?>)">
                                                <i class="bx bx-file mr-2 text-white text-md"></i>
                                                <span class="text-white">
                                                    Patient Record
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="p-4 text-center">
                                    <p class="text-gray-500">No appointment details available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                </section>
            </div>
        </main>
    </div>
    <script src="<?= BASE_URL ?>/js/receptionist/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/confirm.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/reminder.js"></script>
</body>

</html>


<!-- Appointment Reminder Modal -->
<div id="reminderModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="reminderModalContent">
        <!-- Fixed Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Appointment Reminder</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeReminderModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Scrollable Content Area -->
        <div class="px-6 py-3 max-h-[60vh] overflow-y-auto">
            <form id="reminderForm" class="space-y-3">
                <input type="hidden" id="reminderAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-blue-50">
                    <div class="flex items-start">
                        <i class="bx bx-bell text-blue-500 text-lg mr-2"></i>
                        <p class="text-xs text-blue-700">
                            Send an email reminder about the upcoming appointment
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="rounded-md border border-gray-200 p-2 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reminder_type" value="standard" class="mt-1 mr-2" checked>
                            <div>
                                <span class="block text-sm font-medium">Standard</span>
                                <span class="text-xs text-gray-500">Basic details</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-2 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reminder_type" value="detailed" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Detailed</span>
                                <span class="text-xs text-gray-500">With instructions</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="reminder_message" class="block text-sm font-medium text-gray-700 mb-1">Message:</label>
                    <textarea id="reminder_message" name="reminder_message" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any additional information..."></textarea>
                </div>

                <div class="rounded-md border border-gray-200 p-2 bg-gray-50">
                    <div class="flex items-center">
                        <input id="send_email" name="send_email" type="checkbox" checked
                            class="h-4 w-4 text-primary border-gray-300 rounded">
                        <label for="send_email" class="ml-2 text-sm text-gray-700">Send via email</label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Footer -->
        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelReminderBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="sendReminderBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Send
            </button>
        </div>
    </div>
</div>

<div id="approveRescheduleModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="approveRescheduleModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Approve Reschedule Request</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeApproveRescheduleModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Review and approve the requested reschedule:</p>

            <form id="approveRescheduleForm" class="space-y-3">
                <input type="hidden" id="approveRescheduleAppointmentId" name="appointmentId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="requested_date" class="block text-sm font-medium text-gray-700 mb-1">Requested
                            Date:</label>
                        <div class="relative">
                            <input type="text" id="requested_date" name="requested_date" readonly
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                    </div>
                    <div>
                        <label for="requested_time" class="block text-sm font-medium text-gray-700 mb-1">Requested
                            Time:</label>
                        <div class="relative">
                            <input type="text" id="requested_time" name="requested_time" readonly
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="new_date" class="block text-sm font-medium text-gray-700 mb-1">New Date:</label>
                        <div class="relative">
                            <input type="text" id="new_date" name="new_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="bx bx-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="new_time" class="block text-sm font-medium text-gray-700 mb-1">New Time:</label>
                        <div class="relative">
                            <input type="text" id="new_time" name="new_time"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="bx bx-time text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="use_requested_datetime" name="use_requested_datetime" value="1"
                            class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Use requested date and time</span>
                            <span class="text-xs text-gray-500">Uncheck to specify a different date/time</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" name="send_reschedule_confirmation" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Send confirmation to patient</span>
                            <span class="text-xs text-gray-500">Patient will receive an email notification</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="reschedule_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="reschedule_notes" name="reschedule_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes about this reschedule..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelApproveRescheduleBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmApproveRescheduleBtn"
                class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                Approve Reschedule
            </button>
        </div>
    </div>
</div>

<!-- Deny Reschedule Modal -->
<div id="denyRescheduleModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="denyRescheduleModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Deny Reschedule Request</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeDenyRescheduleModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Please provide a reason for denying this reschedule request:</p>

            <form id="denyRescheduleForm" class="space-y-3">
                <input type="hidden" id="denyRescheduleAppointmentId" name="appointmentId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reschedule_denial_reason" value="unavailable_slot"
                                class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Unavailable Slot</span>
                                <span class="text-xs text-gray-500">Requested time is not available</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reschedule_denial_reason" value="short_notice" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Short Notice</span>
                                <span class="text-xs text-gray-500">Request received too late</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reschedule_denial_reason" value="medical_necessity"
                                class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Medical Necessity</span>
                                <span class="text-xs text-gray-500">Original time is necessary</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reschedule_denial_reason" value="other" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Other Reason</span>
                                <span class="text-xs text-gray-500">Please specify below</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" name="send_reschedule_denial_notification" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Send notification to patient</span>
                            <span class="text-xs text-gray-500">Patient will receive an email notification</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="reschedule_denial_details"
                        class="block text-sm font-medium text-gray-700 mb-1">Additional Details:</label>
                    <textarea id="reschedule_denial_details" name="reschedule_denial_details" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Please provide additional information about this denial..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelRescheduleDenialBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmRescheduleDenialBtn"
                class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none"
                disabled>
                Confirm Denial
            </button>
        </div>
    </div>
</div>

<div id="checkInModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="checkInModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Check-In Patient</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeCheckInModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Confirm patient arrival and check-in details:</p>

            <form id="checkInForm" class="space-y-3">
                <input type="hidden" id="checkInAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-time text-primary mr-2"></i>
                        <span class="text-sm font-medium">Arrival Time</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-2">Current time will be recorded as the check-in time.</p>
                    <div class="text-sm font-medium" id="currentCheckInTime"></div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="verify_insurance" name="verify_insurance" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Insurance Verified</span>
                            <span class="text-xs text-gray-500">Confirm patient's insurance information is valid</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="verify_id" name="verify_id" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">ID Verified</span>
                            <span class="text-xs text-gray-500">Confirm patient's identity has been verified</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="forms_completed" name="forms_completed" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Forms Completed</span>
                            <span class="text-xs text-gray-500">Patient has completed all required paperwork</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="notify_provider" name="notify_provider" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Notify Provider</span>
                            <span class="text-xs text-gray-500">Send notification to the healthcare provider</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="check_in_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="check_in_notes" name="check_in_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes about this check-in..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelCheckInBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmCheckInBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Complete Check-In
            </button>
        </div>
    </div>
</div>

<!-- Start Appointment Modal -->
<div id="startAppointmentModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="startAppointmentModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Start Appointment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeStartAppointmentModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Confirm that the patient is ready to see the provider:</p>

            <form id="startAppointmentForm" class="space-y-3">
                <input type="hidden" id="startAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-user-check text-primary mr-2"></i>
                        <span class="text-sm font-medium">Patient Status</span>
                    </div>
                    <p class="text-sm text-gray-500">Patient has been checked in and is ready to see the provider.</p>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="vitals_recorded" name="vitals_recorded" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Vitals Recorded</span>
                            <span class="text-xs text-gray-500">Patient's vital signs have been recorded</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="room_prepared" name="room_prepared" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Room Prepared</span>
                            <span class="text-xs text-gray-500">Examination room is ready for the patient</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="provider_notified" name="provider_notified" value="1"
                            class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Provider Notified</span>
                            <span class="text-xs text-gray-500">Healthcare provider has been notified</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="room_number" class="block text-sm font-medium text-gray-700 mb-1">Room Number:</label>
                    <select id="room_number" name="room_number"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">Select a room</option>
                        <option value="1">Room 1</option>
                        <option value="2">Room 2</option>
                        <option value="3">Room 3</option>
                        <option value="4">Room 4</option>
                        <option value="5">Room 5</option>
                    </select>
                </div>

                <div>
                    <label for="start_appointment_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="start_appointment_notes" name="start_appointment_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes for the provider..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelStartAppointmentBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmStartAppointmentBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Start Appointment
            </button>
        </div>
    </div>
</div>