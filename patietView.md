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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
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

        /* Improved Timeline styles */
        .appointment-timeline {
            position: relative;
            padding: 0.5rem 0.3rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 48px;
            margin-bottom: 16px;
            transition: transform 0.2s ease;
        }

        .timeline-item:hover {
            transform: translateX(4px);
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Timeline connector line */
        .timeline-connector {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }

        /* Timeline colors */
        .timeline-current .timeline-icon {
            background-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        .timeline-current .timeline-content {
            border-left: 3px solid #3B82F6;
            background-color: #EFF6FF;
        }

        .timeline-past .timeline-icon {
            background-color: #10B981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        }

        .timeline-past .timeline-content {
            border-left: 3px solid #10B981;
            background-color: #ECFDF5;
        }

        .timeline-content {
            border-radius: 8px;
            padding: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .timeline-content:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .timeline-date {
            display: inline-block;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .timeline-current .timeline-date {
            background-color: rgba(59, 130, 246, 0.1);
            color: #1E40AF;
        }

        .timeline-past .timeline-date {
            background-color: rgba(16, 185, 129, 0.1);
            color: #065F46;
        }

        /* Equal height columns */
        .equal-height-columns {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .equal-height-content {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            max-height: none;
        }

        .equal-height-content::-webkit-scrollbar {
            width: 4px;
        }

        .equal-height-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .equal-height-content::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* Patient card improvements */
        .patient-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .patient-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .patient-info-item:last-child {
            border-bottom: none;
        }

        .patient-info-label {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .patient-info-value {
            font-weight: regular;
            text-align: right;
            font-size: 0.875rem;
        }

        /* Modal improvements */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Checkup form styles */
        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .vital-sign-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .vital-sign-item {
            flex: 1;
        }

        .vital-sign-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1F2937;
        }

        .vital-sign-label {
            font-size: 0.75rem;
            color: #6B7280;
        }

        .vital-sign-unit {
            font-size: 0.875rem;
            color: #6B7280;
            margin-left: 0.25rem;
        }

        .vital-sign-trend {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .trend-up {
            color: #EF4444;
        }

        .trend-down {
            color: #10B981;
        }

        .trend-stable {
            color: #6B7280;
        }

        .save-button {
            background-color: #3B82F6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .save-button:hover {
            background-color: #2563EB;
        }

        .save-draft-button {
            background-color: white;
            color: #374151;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
            cursor: pointer;
        }

        .save-draft-button:hover {
            background-color: #f3f4f6;
        }

        .vital-sign-card {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        .vital-sign-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .vital-sign-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .vital-sign-icon {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            color: white;
        }

        .icon-temperature {
            background-color: #EF4444;
        }

        .icon-heart-rate {
            background-color: #EC4899;
        }

        .icon-blood-pressure {
            background-color: #8B5CF6;
        }

        .icon-respiratory-rate {
            background-color: #3B82F6;
        }

        .icon-oxygen {
            background-color: #10B981;
        }

        .icon-weight {
            background-color: #F59E0B;
        }

        .glow-pulse {
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 5px -5px rgba(59, 130, 246, 0.5);
            }

            to {
                box-shadow: 0 0 10px 5px rgba(59, 130, 246, 0.5);
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
                <section class="p-6">
                    <!-- Back button -->
                    <div class="mb-4">
                        <a href="<?= BASE_URL ?>/doctor/patients"
                            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                            <button class="back-button">
                                <i class="bx bx-arrow-back mr-2"></i> Back to Patients List
                            </button>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Column - Patient Information -->
                        <div class="md:col-span-1">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden h-full">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold mb-4">Patient Information</h3>

                                    <!-- Patient Avatar -->
                                    <div class="flex justify-center mb-6">
                                        <div
                                            class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                                            <?php if (!empty($patient->profile)): ?>
                                                <img src="<?= BASE_URL . '/' . $patient->profile ?>"
                                                    class="w-full h-full object-cover rounded-full">
                                            <?php else: ?>
                                                <i class="bx bx-user text-3xl text-gray-400"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Patient Details -->
                                    <div class="space-y-2">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Name:</span>
                                            <span class="text-gray-900 text-sm font-medium">
                                                <?= htmlspecialchars($patient->first_name . ' ' . $patient->last_name) ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Date of birth:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= date('Y-m-d', strtotime($patient->date_of_birth ?? '1980-05-15')) ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Age:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->age) ? $patient->age : '43' ?> years
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Gender:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->gender) ? ucfirst($patient->gender) : 'Male' ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Blood Type:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->blood_type) ? $patient->blood_type : 'A+' ?>
                                            </span>
                                        </div>

                                        <!-- Last Visit Information -->
                                        <div class="mt-6">
                                            <h4 class="text-md font-medium mb-3">Last Visit</h4>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600 text-sm">Date:</span>
                                                <span class="text-gray-900 text-sm">
                                                    <?= isset($lastVisit->visit_date) ? date('M d, Y', strtotime($lastVisit->visit_date)) : 'Mar 15, 2023' ?>
                                                </span>
                                            </div>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600 text-sm">Reason:</span>
                                                <span class="text-gray-900 text-sm">
                                                    <?= isset($lastVisit->reason) ? $lastVisit->reason : 'Annual Physical' ?>
                                                </span>
                                            </div>
                                            <div class="flex justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600 text-sm">Provider:</span>
                                                <span class="text-gray-900 text-sm">
                                                    <?= isset($lastVisit->provider_name) ? $lastVisit->provider_name : 'Dr. Sarah Johnson' ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Medical Alerts -->
                                        <div class="mt-6">
                                            <h4 class="text-md font-medium mb-3">Medical Alerts</h4>
                                            <div class="space-y-2">
                                                <?php
                                                $alerts = isset($patient->medical_alerts) ? json_decode($patient->medical_alerts) : [
                                                    ['type' => 'allergy', 'severity' => 'high', 'description' => 'Sulfa drugs - Severe reaction'],
                                                    ['type' => 'condition', 'severity' => 'medium', 'description' => 'Hypertension - Monitor closely']
                                                ];

                                                foreach ($alerts as $alert):
                                                    $alertClass = '';
                                                    switch ($alert->severity ?? 'medium') {
                                                        case 'high':
                                                            $alertClass = 'bg-red-100 text-red-800 border-red-200';
                                                            $icon = 'bx-error';
                                                            break;
                                                        case 'medium':
                                                            $alertClass = 'bg-amber-100 text-amber-800 border-amber-200';
                                                            $icon = 'bx-info-circle';
                                                            break;
                                                        default:
                                                            $alertClass = 'bg-blue-100 text-blue-800 border-blue-200';
                                                            $icon = 'bx-notification';
                                                    }
                                                    ?>
                                                    <div class="p-3 rounded-md border <?= $alertClass ?>">
                                                        <div class="flex items-center">
                                                            <i class="bx <?= $icon ?> mr-2"></i>
                                                            <span
                                                                class="text-sm"><?= $alert->description ?? 'Medical alert' ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Checkup Form -->
                        <div class="md:col-span-2">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden h-full">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-lg font-semibold">Patient Checkup</h3>
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500 mr-2">Visit Date:</span>
                                            <span class="text-sm font-medium"><?= date('M d, Y') ?></span>
                                        </div>
                                    </div>

                                    <form id="checkupForm" method="post" action="<?= BASE_URL ?>/doctor/save-checkup">
                                        <input type="hidden" name="patient_id" value="<?= $patient->id ?? 1 ?>">
                                        <input type="hidden" name="visit_id" value="<?= $visitId ?? '' ?>">

                                        <!-- Vital Signs Section -->
                                        <div class="form-section">
                                            <h4 class="text-md font-medium mb-4">Vital Signs</h4>

                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                                <!-- Temperature -->
                                                <div class="vital-sign-card glow-pulse">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-temperature">
                                                            <i class="bx bx-thermometer"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 98.6°F</div>
                                                    </div>
                                                    <div class="flex items-baseline">
                                                        <input type="number" name="temperature" step="0.1"
                                                            class="form-input w-16 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="98.6">
                                                        <span class="vital-sign-unit">°F</span>
                                                    </div>
                                                    <div class="vital-sign-label">Temperature</div>
                                                </div>

                                                <!-- Heart Rate -->
                                                <div class="vital-sign-card">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-heart-rate">
                                                            <i class="bx bx-heart"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 72 bpm</div>
                                                    </div>
                                                    <div class="flex items-baseline">
                                                        <input type="number" name="heart_rate"
                                                            class="form-input w-16 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="75">
                                                        <span class="vital-sign-unit">bpm</span>
                                                    </div>
                                                    <div class="vital-sign-label">Heart Rate</div>
                                                    <div class="vital-sign-trend trend-up">
                                                        <i class="bx bx-up-arrow-alt"></i> <span>+3 from last
                                                            visit</span>
                                                    </div>
                                                </div>

                                                <!-- Blood Pressure -->
                                                <div class="vital-sign-card">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-blood-pressure">
                                                            <i class="bx bx-pulse"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 120/80</div>
                                                    </div>
                                                    <div class="flex items-baseline gap-1">
                                                        <input type="number" name="blood_pressure_systolic"
                                                            class="form-input w-12 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="125">
                                                        <span class="text-lg font-semibold">/</span>
                                                        <input type="number" name="blood_pressure_diastolic"
                                                            class="form-input w-12 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="82">
                                                        <span class="vital-sign-unit">mmHg</span>
                                                    </div>
                                                    <div class="vital-sign-label">Blood Pressure</div>
                                                    <div class="vital-sign-trend trend-up">
                                                        <i class="bx bx-up-arrow-alt"></i> <span>+5/+2 from last
                                                            visit</span>
                                                    </div>
                                                </div>

                                                <!-- Respiratory Rate -->
                                                <div class="vital-sign-card">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-respiratory-rate">
                                                            <i class="bx bx-wind"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 16 bpm</div>
                                                    </div>
                                                    <div class="flex items-baseline">
                                                        <input type="number" name="respiratory_rate"
                                                            class="form-input w-16 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="16">
                                                        <span class="vital-sign-unit">bpm</span>
                                                    </div>
                                                    <div class="vital-sign-label">Respiratory Rate</div>
                                                    <div class="vital-sign-trend trend-stable">
                                                        <i class="bx bx-minus"></i> <span>No change</span>
                                                    </div>
                                                </div>

                                                <!-- Oxygen Saturation -->
                                                <div class="vital-sign-card">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-oxygen">
                                                            <i class="bx bx-droplet"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 98%</div>
                                                    </div>
                                                    <div class="flex items-baseline">
                                                        <input type="number" name="oxygen_saturation"
                                                            class="form-input w-16 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="97">
                                                        <span class="vital-sign-unit">%</span>
                                                    </div>
                                                    <div class="vital-sign-label">Oxygen Saturation</div>
                                                    <div class="vital-sign-trend trend-down">
                                                        <i class="bx bx-down-arrow-alt"></i> <span>-1% from last
                                                            visit</span>
                                                    </div>
                                                </div>

                                                <!-- Weight -->
                                                <div class="vital-sign-card">
                                                    <div class="vital-sign-header">
                                                        <div class="vital-sign-icon icon-weight">
                                                            <i class="bx bx-line-chart"></i>
                                                        </div>
                                                        <div class="text-xs text-gray-500">Previous: 185 lbs</div>
                                                    </div>
                                                    <div class="flex items-baseline">
                                                        <input type="number" name="weight" step="0.1"
                                                            class="form-input w-16 text-lg font-semibold p-0 border-0 focus:ring-0"
                                                            value="183">
                                                        <span class="vital-sign-unit">lbs</span>
                                                    </div>
                                                    <div class="vital-sign-label">Weight</div>
                                                    <div class="vital-sign-trend trend-down">
                                                        <i class="bx bx-down-arrow-alt"></i> <span>-2 lbs from last
                                                            visit</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chief Complaint Section -->
                                        <div class="form-section">
                                            <h4 class="text-md font-medium mb-4">Chief Complaint</h4>

                                            <div class="form-group">
                                                <label for="chief_complaint" class="form-label">Primary Reason for
                                                    Visit</label>
                                                <textarea id="chief_complaint" name="chief_complaint"
                                                    class="form-textarea"
                                                    placeholder="Describe the patient's main complaint or reason for visit"><?= isset($checkup->chief_complaint) ? $checkup->chief_complaint : '' ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="complaint_duration" class="form-label">Duration of
                                                    Symptoms</label>
                                                <div class="flex gap-2">
                                                    <input type="number" id="duration_value" name="duration_value"
                                                        class="form-input w-20"
                                                        value="<?= isset($checkup->duration_value) ? $checkup->duration_value : '' ?>">
                                                    <select id="duration_unit" name="duration_unit" class="form-select">
                                                        <option value="hours" <?= (isset($checkup->duration_unit) && $checkup->duration_unit == 'hours') ? 'selected' : '' ?>>Hours
                                                        </option>
                                                        <option value="days" <?= (isset($checkup->duration_unit) && $checkup->duration_unit == 'days') ? 'selected' : '' ?>>Days
                                                        </option>
                                                        <option value="weeks" <?= (isset($checkup->duration_unit) && $checkup->duration_unit == 'weeks') ? 'selected' : '' ?>>Weeks
                                                        </option>
                                                        <option value="months" <?= (isset($checkup->duration_unit) && $checkup->duration_unit == 'months') ? 'selected' : '' ?>>
                                                            Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Symptom Severity</label>
                                                <div class="flex items-center gap-4">
                                                    <div class="flex items-center">
                                                        <input type="radio" id="severity_mild" name="symptom_severity"
                                                            value="mild" class="form-check-input"
                                                            <?= (isset($checkup->symptom_severity) && $checkup->symptom_severity == 'mild') ? 'checked' : '' ?>>
                                                        <label for="severity_mild" class="ml-2">Mild</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="radio" id="severity_moderate"
                                                            name="symptom_severity" value="moderate"
                                                            class="form-check-input"
                                                            <?= (isset($checkup->symptom_severity) && $checkup->symptom_severity == 'moderate') ? 'checked' : '' ?>>
                                                        <label for="severity_moderate" class="ml-2">Moderate</label>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <input type="radio" id="severity_severe" name="symptom_severity"
                                                            value="severe" class="form-check-input"
                                                            <?= (isset($checkup->symptom_severity) && $checkup->symptom_severity == 'severe') ? 'checked' : '' ?>>
                                                        <label for="severity_severe" class="ml-2">Severe</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Physical Examination Section -->
                                        <div class="form-section">
                                            <h4 class="text-md font-medium mb-4">Physical Examination</h4>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="general_appearance" class="form-label">General
                                                        Appearance</label>
                                                    <textarea id="general_appearance" name="general_appearance"
                                                        class="form-textarea"
                                                        placeholder="General appearance observations"><?= isset($checkup->general_appearance) ? $checkup->general_appearance : '' ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="heent" class="form-label">HEENT (Head, Eyes, Ears, Nose,
                                                        Throat)</label>
                                                    <textarea id="heent" name="heent" class="form-textarea"
                                                        placeholder="HEENT examination findings"><?= isset($checkup->heent) ? $checkup->heent : '' ?></textarea>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="cardiovascular"
                                                        class="form-label">Cardiovascular</label>
                                                    <textarea id="cardiovascular" name="cardiovascular"
                                                        class="form-textarea"
                                                        placeholder="Cardiovascular examination findings"><?= isset($checkup->cardiovascular) ? $checkup->cardiovascular : '' ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="respiratory" class="form-label">Respiratory</label>
                                                    <textarea id="respiratory" name="respiratory" class="form-textarea"
                                                        placeholder="Respiratory examination findings"><?= isset($checkup->respiratory) ? $checkup->respiratory : '' ?></textarea>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="form-group">
                                                    <label for="gastrointestinal"
                                                        class="form-label">Gastrointestinal</label>
                                                    <textarea id="gastrointestinal" name="gastrointestinal"
                                                        class="form-textarea"
                                                        placeholder="Gastrointestinal examination findings"><?= isset($checkup->gastrointestinal) ? $checkup->gastrointestinal : '' ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="musculoskeletal"
                                                        class="form-label">Musculoskeletal</label>
                                                    <textarea id="musculoskeletal" name="musculoskeletal"
                                                        class="form-textarea"
                                                        placeholder="Musculoskeletal examination findings"><?= isset($checkup->musculoskeletal) ? $checkup->musculoskeletal : '' ?></textarea>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="form-group">
                                                    <label for="neurological" class="form-label">Neurological</label>
                                                    <textarea id="neurological" name="neurological"
                                                        class="form-textarea"
                                                        placeholder="Neurological examination findings"><?= isset($checkup->neurological) ? $checkup->neurological : '' ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="skin" class="form-label">Skin</label>
                                                    <textarea id="skin" name="skin" class="form-textarea"
                                                        placeholder="Skin examination findings"><?= isset($checkup->skin) ? $checkup->skin : '' ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Assessment & Plan Section -->
                                        <div class="form-section">
                                            <h4 class="text-md font-medium mb-4">Assessment & Plan</h4>

                                            <div class="form-group mb-4">
                                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                                <textarea id="diagnosis" name="diagnosis" class="form-textarea"
                                                    placeholder="Enter diagnosis"><?= isset($checkup->diagnosis) ? $checkup->diagnosis : '' ?></textarea>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="treatment_plan" class="form-label">Treatment Plan</label>
                                                <textarea id="treatment_plan" name="treatment_plan"
                                                    class="form-textarea"
                                                    placeholder="Enter treatment plan"><?= isset($checkup->treatment_plan) ? $checkup->treatment_plan : '' ?></textarea>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="medications" class="form-label">Medications</label>
                                                <textarea id="medications" name="medications" class="form-textarea"
                                                    placeholder="Enter medications"><?= isset($checkup->medications) ? $checkup->medications : '' ?></textarea>
                                            </div>

                                            <div class="form-group mb-4">
                                                <label for="follow_up" class="form-label">Follow-up Instructions</label>
                                                <textarea id="follow_up" name="follow_up" class="form-textarea"
                                                    placeholder="Enter follow-up instructions"><?= isset($checkup->follow_up) ? $checkup->follow_up : '' ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="notes" class="form-label">Additional Notes</label>
                                                <textarea id="notes" name="notes" class="form-textarea"
                                                    placeholder="Enter any additional notes"><?= isset($checkup->notes) ? $checkup->notes : '' ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="flex justify-end gap-3 mt-6">
                                            <button type="button" class="save-draft-button">
                                                <i class="bx bx-save mr-2"></i> Save Draft
                                            </button>
                                            <button type="submit" class="save-button">
                                                <i class="bx bx-check mr-2"></i> Complete Checkup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize flatpickr for any date inputs if needed
            flatpickr('.date-picker', {
                dateFormat: 'Y-m-d',
                locale: 'en'
            });

            // Save draft functionality
            const saveDraftButton = document.querySelector('.save-draft-button');
            if (saveDraftButton) {
                saveDraftButton.addEventListener('click', function () {
                    const form = document.getElementById('checkupForm');
                    const formData = new FormData(form);
                    formData.append('draft', 'true');

                    fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Draft saved successfully!');
                            } else {
                                alert('Error saving draft: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while saving the draft.');
                        });
                });
            }

            // Highlight the temperature field with a pulsing glow effect
            setTimeout(() => {
                const temperatureCard = document.querySelector('.vital-sign-card.glow-pulse');
                if (temperatureCard) {
                    temperatureCard.classList.remove('glow-pulse');
                }
            }, 5000);
        });
    </script>
</body>

</html>