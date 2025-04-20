<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
        /* View transition styles */
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
    </style>
</head>

<body class="font-body bg-gray-50">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <div class="p-6">
                    <div class="mb-6">
                        <a href="<?= BASE_URL ?>/receptionist/appointments" class="back-button">
                            <i class='bx bx-arrow-back mr-2'></i> Back to Appointments
                        </a>
                    </div>

                    <div class="flex gap-6">
                        <!-- Right Column: Detailed Information -->
                        <div class="card bg-white shadow-sm rounded-lg p-6 flex-1 fade-in">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="text-md font-medium text-gray-900">
                                        <?= htmlspecialchars($appointment->first_name . ' ' . $appointment->last_name) ?>
                                    </h3>
                                    <p class="text-sm text-gray-400">Appointment Details</p>
                                </div>
                                <div class="flex gap-2">
                                    <span
                                        class="appointment-type <?= strtolower($appointment->appointment_type) ?> px-2 py-2">
                                        <?= ucwords(str_replace('_', ' ', $appointment->appointment_type)) ?>
                                    </span>
                                    <span
                                        class="status-badge border <?= $statusClass ?> px-1 py-1 rounded text-sm status">
                                        <?= ucwords(str_replace('_', ' ', $appointment->status)) ?>
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

                            <hr class="border-gray-200 my-6 mt-5 mb-4">

                            <div class="">
                                <p class="text-sm mb-2 font-medium">Appointment Information</p>
                                <div class="ml-1">
                                    <table class="w-full border-collapse">
                                        <tr class="border-b border-gray-200">
                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Reason</td>
                                            <td class="text-sm text-gray-900 py-2">
                                                <?= htmlspecialchars($appointment->reason ?? 'General appointment') ?>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location</td>
                                            <td class="text-sm text-gray-900 py-2">
                                                <?= htmlspecialchars($appointment->location ?? 'Main Clinic') ?>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Special
                                                Instructions</td>
                                            <td class="text-sm text-gray-900 py-2">
                                                <?= htmlspecialchars($appointment->special_instructions ?? 'No instructions available') ?>
                                            </td>
                                        </tr>

                                        <?php if ($appointment->status == 'checked_in' || $appointment->status == 'in_progress' || $appointment->status == 'completed'): ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Arrival Time
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">
                                                    <?= date('h:i A', strtotime($appointment->checked_in_at)) ?>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Appointment
                                                    End</td>
                                                <td class="text-sm text-gray-900 py-2">
                                                    <?= isset($appointment->completed_at) && $appointment->completed_at ? date('h:i A', strtotime($appointment->completed_at)) : 'Not completed' ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <tr class="border-b border-gray-200">
                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance</td>
                                            <td class="text-sm text-gray-900 py-2">
                                                <?php if ($appointment->insurance_verified): ?>
                                                    <i class='bx bxs-check-circle text-success'></i>
                                                <?php else: ?>
                                                    <i class='bx bx-x-circle text-danger'></i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr class="border-b border-gray-200">
                                            <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">ID</td>
                                            <td class="text-sm text-gray-900 py-2">
                                                <?php if ($appointment->id_verified): ?>
                                                    <i class='bx bxs-check-circle text-success'></i>
                                                <?php else: ?>
                                                    <i class='bx bx-x-circle text-danger'></i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>