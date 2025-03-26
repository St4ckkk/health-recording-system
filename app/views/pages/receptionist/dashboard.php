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
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
        /* Image header styling */
        .image-header {
            position: relative;
            height: 250px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        .image-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .image-header-content {
            position: relative;
            z-index: 3;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 3rem;
            color: white;
        }

        .image-header-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.2;
            max-width: 600px;
        }

        .image-header-subtitle {
            font-size: 1.125rem;
            font-weight: 400;
            margin-bottom: 1.25rem;
            max-width: 500px;
            opacity: 0.9;
        }

        .image-header-stats {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            min-width: 110px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .image-header {
                height: 350px;
            }

            .image-header-content {
                padding: 1.5rem;
            }

            .image-header-title {
                font-size: 1.75rem;
            }

            .image-header-subtitle {
                font-size: 1rem;
            }

            .image-header-stats {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .stat-item {
                min-width: 100px;
            }
        }

        @media (max-width: 640px) {
            .image-header {
                height: 400px;
            }

            .image-header-title {
                font-size: 1.5rem;
            }

            .stat-item {
                min-width: 90px;
                padding: 0.75rem;
            }

            .stat-number {
                font-size: 1.25rem;
            }
        }

        /* Status badge styles using CSS variables */
        .badge-upcoming,
        .badge-today,
        .badge-past {

            font-weight: 500;
        }

        /* Status badge styles using CSS variables - colors only */
        .badge-upcoming {
            background-color: var(--primary);
        }

        .badge-today {
            background-color: var(--success);
        }

        .badge-past {
            background-color: var(--gray-500);
        }

        /* Appointment status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            font-size: var(--font-size-xs);
            font-weight: 500;
            text-transform: capitalize;
        }

        /* Appointment status badges - colors only */
        .status-badge.completed {

            color: var(--success-dark);

        }

        .status-badge.scheduled {

            color: var(--info-dark);

        }
        
        .status-badge.cancelled,
        .status-badge.cancelled_pending {

            color: var(--danger-dark);

        }

        .status-badge.no-show {

            color: var(--warning-dark);

        }

        .status-badge.pending {

            color: var(--primary-dark);

        }

        .status-badge.confirmed {

            color: var(--success-dark);
        }

        .status-badge.check-in {

            color: var(--primary-blue-dark);

        }

        .status-badge.rescheduled,
        .status-badge.rescheduled_pending {

            color: var(--warning-dark);

        }

        /* Appointment type badges */
        .appointment-type {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            font-size: var(--font-size-xs);
            font-weight: 500;
            text-transform: capitalize;
        }

        /* Appointment type badges - colors only */
        .appointment-type.checkup {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-color: var(--primary);
        }

        .appointment-type.follow_up {
            background-color: var(--success-light);
            color: var(--success-dark);
            border-color: var(--success);
        }

        .appointment-type.consultation {
            background-color: var(--info-light);
            color: var(--info-dark);
            border-color: var(--info);
        }

        .appointment-type.treatment {
            background-color: var(--primary-blue-light);
            color: var(--primary-blue-dark);
            border-color: var(--primary-blue);
        }

        .appointment-type.emergency {
            background-color: var(--danger-light);
            color: var(--danger-dark);
            border-color: var(--danger);
        }

        .appointment-type.specialist {
            background-color: var(--info-light);
            color: var(--info-dark);
            border-color: var(--info);
        }

        .appointment-type.vaccination {
            background-color: var(--success-light);
            color: var(--success-dark);
            border-color: var(--success);
        }

        .appointment-type.laboratory_test {
            background-color: var(--warning-light);
            color: var(--warning-dark);
            border-color: var(--warning);
        }

        .appointment-type.medical_clearance {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-color: var(--primary);
        }
    </style>
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
                                                <p class="text-sm text-gray-500">
                                                    <?= $appointment->reason ?? 'General appointment' ?>
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

                                <script>
                                    function clearFilters() {
                                        document.getElementById('dateFilter').value = '';
                                        document.getElementById('typeFilter').value = '';
                                    }
                                </script>
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
                                                    'scheduled' => ['class' => 'scheduled', 'icon' => 'bx-time'],
                                                    'cancelled' => ['class' => 'cancelled', 'icon' => 'bx-x-circle'],
                                                    'cancelled_pending' => ['class' => 'cancelled', 'icon' => 'bx-time', 'label' => 'Waiting Confirmation'],
                                                    'no-show' => ['class' => 'no-show', 'icon' => 'bx-error-circle'],
                                                    'pending' => ['class' => 'pending', 'icon' => 'bx-hourglass'],
                                                    'confirmed' => ['class' => 'confirmed', 'icon' => 'bx-calendar-check'],
                                                    'check-in' => ['class' => 'check-in', 'icon' => 'bx-log-in-circle'],
                                                    'rescheduled' => ['class' => 'rescheduled', 'icon' => 'bx-calendar-exclamation'],
                                                    'rescheduled_pending' => ['class' => 'rescheduled', 'icon' => 'bx-time', 'label' => 'Waiting Confirmation'],
                                                ];

                                                $statusInfo = $statusMapping[$appointment->status] ?? $statusMapping['scheduled'];
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
                                                    class="appointment-type border <?= $statusClass ?> px-1 py-1 rounded text-sm status">
                                                    <?= ucwords(str_replace('_', ' ', $appointment->status ?? 'Scheduled')) ?>
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
                                                    <?php if ($appointment->status == 'cancelled' && (!empty($appointment->cancellation_reason) || !empty($appointment->cancellation_details))): ?>
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
                                                    <tr class="">
                                                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                        </td>
                                                        <td class="text-sm text-gray-900 py-2">
                                                            <?= $appointment->insurance_provider ?? 'Not specified' ?>
                                                            <?= !empty($appointment->insurance_id) ? '#' . $appointment->insurance_id : '' ?>
                                                        </td>
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
                                                        <i class="bx bx-x-circle text-danger mr-2 text-md"></i>
                                                        Cancel Appointment
                                                    </button>
                                                </div>
                                                <button class="action-button secondary border border-success text-success"
                                                    onclick="confirmAppointment(<?= $appointment->id ?>)">
                                                    <i class="bx bx-check-circle mr-2 text-md"></i>
                                                    Confirm
                                                </button>
                                                <button class="action-button secondary border border-warning text-warning"
                                                    onclick="sendReminder(<?= $appointment->id ?>)">
                                                    <i class="bx bx-bell mr-2 text-md text-yellow-500"></i>
                                                    Send Reminder
                                                </button>
                                            <?php elseif ($appointment->status == 'no_show'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary border border-warning text-warning"
                                                        onclick="sendReminder(<?= $appointment->id ?>)">
                                                        <i class="bx bx-bell mr-2 text-md text-yellow-500"></i>
                                                        Send Reminder
                                                    </button>
                                                </div>
                                            <?php elseif (in_array($appointment->status, ['cancelled_by_patient', 'cancelled_by_clinic', 'cancelled_auto'])): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary"
                                                        onclick="rescheduleAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-calendar mr-2 text-md"></i>
                                                        Reschedule
                                                    </button>
                                                </div>
                                            <?php elseif ($appointment->status == 'cancellation_requested'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary"
                                                        onclick="approveCancellation(<?= $appointment->id ?>)">
                                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                                        Approve Cancellation
                                                    </button>
                                                </div>
                                                <button class="action-button secondary"
                                                    onclick="denyCancellation(<?= $appointment->id ?>)">
                                                    <i class="bx bx-x-circle mr-2 text-md"></i>
                                                    Deny Cancellation
                                                </button>
                                            <?php elseif ($appointment->status == 'reschedule_requested' || $appointment->status == 'rescheduled'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary"
                                                        onclick="rescheduleAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-calendar mr-2 text-md"></i>
                                                        Modify Schedule
                                                    </button>
                                                </div>
                                                <?php if ($appointment->status == 'reschedule_requested'): ?>
                                                    <button class="action-button secondary"
                                                        onclick="approveReschedule(<?= $appointment->id ?>)">
                                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                                        Approve Reschedule
                                                    </button>
                                                    <button class="action-button secondary"
                                                        onclick="denyReschedule(<?= $appointment->id ?>)">
                                                        <i class="bx bx-x-circle mr-2 text-md"></i>
                                                        Deny Reschedule
                                                    </button>
                                                <?php endif; ?>
                                            <?php elseif ($appointment->status == 'confirmed'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary border border-primary text-primary"
                                                        onclick="checkInPatient(<?= $appointment->id ?>)">
                                                        <i class="bx bx-log-in-circle mr-2 text-md"></i>
                                                        Check In Patient
                                                    </button>
                                                </div>
                                                <button class="action-button secondary border border-warning text-warning"
                                                    onclick="sendReminder(<?= $appointment->id ?>)">
                                                    <i class="bx bx-bell mr-2 text-md text-yellow-500"></i>
                                                    Send Reminder
                                                </button>
                                            <?php elseif ($appointment->status == 'checked_in'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary border border-primary text-primary"
                                                        onclick="startAppointment(<?= $appointment->id ?>)">
                                                        <i class="bx bx-play-circle mr-2 text-md"></i>
                                                        Start Appointment
                                                    </button>
                                                </div>
                                            <?php elseif ($appointment->status == 'in_progress'): ?>
                                                <div class="flex-1">
                                                    <button class="action-button secondary border border-success text-success"
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
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="<?= BASE_URL ?>/js/reception.js"></script>
    <script>
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
    </script>
</body>

</html>