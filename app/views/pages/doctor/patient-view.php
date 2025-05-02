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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/pharmacist/patientview.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>

</head>

<body class="font-body bg-gray-50">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <?php
        require_once(__DIR__ . '/../../../helpers/CDS.php');
        ?>
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
                                    <!-- <h4 class="text-md font-medium mt-6 mb-3">Emergency Contact</h4>
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
                                    </div> -->

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
                                                if ($allergies && !empty($allergies)) {
                                                    foreach ($allergies as $allergy) {
                                                        ?>
                                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                            <?= htmlspecialchars($allergy->allergy_name) ?>
                                                        </span>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <span class="text-gray-500 text-sm">No known allergies</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="flex flex-col py-2">
                                            <span class="text-gray-600 text-sm mb-1">Conditions:</span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <?php
                                                if ($patientDiagnosis && !empty($patientDiagnosis)) {
                                                    foreach ($patientDiagnosis as $diagnosis) {
                                                        ?>
                                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                                            <?= htmlspecialchars($diagnosis->diagnosis) ?>
                                                        </span>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <span class="text-gray-500 text-sm">No diagnoses recorded</span>
                                                    <?php
                                                }
                                                ?>
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
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700 active"
                                        data-tab="overview" id="tab-overview">Overview</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="admission" id="tab-admission">Admission</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="medications" id="tab-medications">Medications</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="immunizations" id="tab-immunizations">Immunizations</button>
                                    <button class="tab-button px-6 py-3 text-gray-500 hover:text-gray-700"
                                        data-tab="treatment-records" id="tab-treatment-records">Treatment</button>
                                </div>

                                <!-- Tab Content Container -->
                                <div class="tab-content-container">
                                    <div class="tab-content p-6" id="tab-content-overview">
                                        <?php include('components/tab/overview.php'); ?>
                                    </div>

                                    <div class="tab-content p-6 hidden" id="tab-content-admission">
                                        <?php include('components/tab/admission.php'); ?>
                                    </div>

                                    <!-- Medications Tab Content -->
                                    <div class="tab-content p-6 hidden" id="tab-content-medications">
                                        <?php include('components/tab/medications.php'); ?>
                                    </div>

                                    <!-- Immunizations Tab Content -->
                                    <div class="tab-content p-6 hidden" id="tab-content-immunizations">
                                        <?php include('components/tab/immunizations.php'); ?>
                                    </div>

                                    <div class="tab-content p-6 hidden" id="tab-content-treatment-records">
                                        <?php include('components/tab/treatment-records.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Include the monitoring request modal -->
    <?php include('components/modals/monitoring-request.php'); ?>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50"></div>

    <!-- Floating Action Buttons Container -->
    <div class="fab-container">
        <!-- E-Prescriptions FAB -->
        <a href="<?= BASE_URL ?>/doctor/prescriptions?id=<?= $patient->id ?>"
            class="floating-action-button fab-prescriptions pulse">
            <div class="fab-tooltip">Generate Prescription</div>
            <i class="bx bx-file-blank"></i>
        </a>

        <!-- Checkup FAB -->
        <a href="<?= BASE_URL ?>/doctor/checkup?id=<?= $patient->id ?>"
            class="floating-action-button fab-checkup pulse shine">
            <div class="fab-tooltip">Let's Checkup</div>
            <i class="bx bx-plus-medical"></i>
        </a>

        <!-- Monitor Patient FAB -->
        <button onclick="openMonitoringRequestModal(<?= $patient->id ?>)"
            class="floating-action-button fab-monitor pulse bg-primary">
            <div class="fab-tooltip">Send Monitoring Request</div>
            <i class="bx bx-heart-circle"></i>
        </button>
    </div>

    <script>
        function showToast(type, title, message) {
            const toast = document.createElement('div');

            toast.className = `flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow`;

            toast.innerHTML = type === 'success'
                ? `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <i class="bx bx-check text-xl"></i>
                   </div>`
                : `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <i class="bx bx-x text-xl"></i>
                   </div>`;

            toast.innerHTML += `
                <div class="ml-3 text-sm font-normal">
                    <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                    <div class="mb-2 text-sm">${message}</div>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8">
                    <i class="bx bx-x text-lg"></i>
                </button>`;

            document.getElementById('toastContainer').appendChild(toast);

            toast.querySelector('button').addEventListener('click', () => toast.remove());
            setTimeout(() => toast.remove(), 5000);
        }

        function openMonitoringRequestModal(patientId) {
            const modal = document.getElementById('monitoringRequestModal');
            const modalContent = document.getElementById('monitoringRequestModalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);

            // Setup close handlers
            const closeModal = () => {
                modalContent.classList.add('scale-95', 'opacity-0');
                modalContent.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            };

            document.getElementById('closeMonitoringRequestModal').onclick = closeModal;
            document.getElementById('cancelMonitoringRequestBtn').onclick = closeModal;

            // Setup confirm handler
            document.getElementById('confirmMonitoringRequestBtn').onclick = () => {
                const data = {
                    patient_id: patientId,
                    include_symptoms: document.getElementById('include_symptoms').checked,
                    include_wellness: document.getElementById('include_wellness').checked,
                    duration: document.getElementById('monitoring_duration').value,
                    message: document.getElementById('monitoring_message').value
                };

                // Show loading state on button
                const confirmBtn = document.getElementById('confirmMonitoringRequestBtn');
                const originalBtnText = confirmBtn.innerHTML;
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Sending...';
                confirmBtn.disabled = true;

                fetch(`${document.querySelector('meta[name="base-url"]').content}/api/monitoring/send-request`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', 'Request Sent', 'Monitoring request has been sent to the patient successfully.');
                            closeModal();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showToast('error', 'Failed', data.message || 'Failed to send monitoring request.');
                            confirmBtn.innerHTML = originalBtnText;
                            confirmBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Error', 'An unexpected error occurred while sending the request.');
                        confirmBtn.innerHTML = originalBtnText;
                        confirmBtn.disabled = false;
                    });
            };
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab functionality
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            // Set the first tab as active by default
            document.getElementById('tab-overview').classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-medium');
            document.getElementById('tab-content-overview').classList.remove('hidden');

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
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show selected tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(`tab-content-${tabId}`).classList.remove('hidden');
                });
            });

            // Floating Action Button effects
            const fabButtons = document.querySelectorAll('.floating-action-button');

            fabButtons.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    this.classList.remove('pulse');
                });

                button.addEventListener('mouseleave', function () {
                    this.classList.add('pulse');
                });

                // Add click effect
                button.addEventListener('click', function () {
                    this.classList.add('scale-95');
                    setTimeout(() => {
                        this.classList.remove('scale-95');
                    }, 100);
                });
            });
        });
    </script>
</body>

</html>