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
            /* Remove the max height to prevent scrolling */
        }

        /* Remove scrollbar styling since we don't need it anymore */
        .equal-height-content::-webkit-scrollbar {
            width: 0;
            display: none;
        }

        .equal-height-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .equal-height-content::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 0;
        }

        /* Add consistent padding to both cards */
        .card {
            padding: 1.5rem !important;
            /* Override any existing padding */
        }

        /* Ensure consistent spacing between elements */
        .patient-info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 5px;
        }

        /* Add more space between timeline items */
        .timeline-item {
            position: relative;
            padding-left: 48px;
            margin-bottom: 24px;
            /* Increase margin between timeline items */
            transition: transform 0.2s ease;
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

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Height:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->height) ? $patient->height : "5'10\"" ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Weight:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->weight) ? $patient->weight : '185' ?> lbs
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">BMI:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->bmi) ? $patient->bmi : '26.5' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <h4 class="text-md font-medium mt-6 mb-3">Contact Information</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Address:</span>
                                            <span class="text-gray-900 text-sm text-right">
                                                <?= isset($patient->address) ? $patient->address : '123 Main St, Anytown, CA 12345' ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Phone:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->contact_number) ? $patient->contact_number : '(555) 123-4567' ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Email:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->email) ? $patient->email : 'john.doe@example.com' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Emergency Contact -->
                                    <h4 class="text-md font-medium mt-6 mb-3">Emergency Contact</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Name:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->emergency_contact_name) ? $patient->emergency_contact_name : 'Jane Doe' ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Relationship:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->emergency_contact_relationship) ? $patient->emergency_contact_relationship : 'Spouse' ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Phone:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->emergency_contact_number) ? $patient->emergency_contact_number : '(555) 987-6543' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Medical Information -->
                                    <h4 class="text-md font-medium mt-6 mb-3">Medical Information</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm">Insurance:</span>
                                            <span class="text-gray-900 text-sm">
                                                <?= isset($patient->insurance) ? $patient->insurance : 'Blue Cross #BC987654' ?>
                                            </span>
                                        </div>

                                        <div class="flex flex-col py-2 border-b border-gray-100">
                                            <span class="text-gray-600 text-sm mb-1">Allergies:</span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <?php
                                                $allergies = isset($patient->allergy_name) ? explode(',', $patient->allergy_name) : ['Sulfa drugs'];
                                                foreach ($allergies as $allergy):
                                                    ?>
                                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                        <?= trim($allergy) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <div class="flex flex-col py-2">
                                            <span class="text-gray-600 text-sm mb-1">Conditions:</span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <?php
                                                $conditions = isset($patient->diagnosis) ? explode(',', $patient->diagnosis) : ['Hypertension', 'Type 2 Diabetes', 'Hyperlipidemia'];
                                                foreach ($conditions as $condition):
                                                    ?>
                                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                                        <?= trim($condition) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Medical Data -->
                        <div class="md:col-span-2">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden h-full">
                                <!-- Tabs -->
                                <div class="flex border-b border-gray-200">
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="overview" id="tab-overview">Overview</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="visits" id="tab-visits">Visits</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="lab-results" id="tab-lab-results">Lab Results</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="medications" id="tab-medications">Medications</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="immunizations" id="tab-immunizations">Immunizations</button>
                                </div>

                                <div class="tab-content p-6" id="tab-content-overview">
                                    <?php include('components/tab/overview.php'); ?>
                                </div>



                                <!-- Visits Tab Content -->
                                <div class="tab-content p-6 hidden" id="tab-content-visits">
                                    <?php include('components/tab/visits.php'); ?>
                                </div>

                                <!-- Lab Results Tab Content -->
                                <div class="tab-content p-6 hidden" id="tab-content-lab-results">
                                    <?php include('components/tab/lab-results.php'); ?>
                                </div>

                                <!-- Medications Tab Content -->
                                <div class="tab-content p-6 hidden" id="tab-content-medications">
                                    <?php include('components/tab/medications.php'); ?>
                                </div>

                                <!-- Immunizations Tab Content -->
                                <div class="tab-content p-6 hidden" id="tab-content-immunizations">
                                    <?php include('components/tab/immunizations.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        document.getElementById('tab-overview').classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
                        document.getElementById('tab-content-overview').classList.remove('hidden');

                        const tabs = document.querySelectorAll('.tab-button');
                        tabs.forEach(tab => {
                            tab.addEventListener('click', function () {
                                // Remove active class from all tabs
                                tabs.forEach(t => {
                                    t.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
                                    t.classList.add('text-gray-500');
                                });

                                // Add active class to clicked tab
                                this.classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
                                this.classList.remove('text-gray-500');

                                // Hide all tab content
                                const tabContents = document.querySelectorAll('.tab-content');
                                tabContents.forEach(content => {
                                    content.classList.add('hidden');
                                });

                                // Show selected tab content
                                const tabId = this.getAttribute('data-tab');
                                document.getElementById(`tab-content-${tabId}`).classList.remove('hidden');
                            });
                        });
                    });
                </script>
</body>

</html>