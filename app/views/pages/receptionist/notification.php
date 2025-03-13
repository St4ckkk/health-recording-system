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

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <?php include('components/toast.php') ?>
                <!-- Patient App View (initially hidden) -->
                <div id="patientAppView" class="view-transition hidden-view">
                    <div class="p-6">
                        <button id="backToNotifications" class="back-button">
                            <i class="bx bx-arrow-back"></i> Back to Notifications
                        </button>
                        <?php include('components/patient_app.php') ?>
                    </div>
                </div>

                <!-- Notifications View (initially visible) -->
                <section id="notificationsView" class="p-6 view-transition visible-view">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 font-heading">Notifications</h2>
                        <p class="text-sm text-gray-500">Updates about patient appointments</p>
                    </div>
                    <div class="p-4 card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="space-y-4">
                            <!-- New Appointment Card -->
                            <div class="notification-card bg-[#f8faff] rounded-lg p-4 border border-primary-lighter">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="mt-1">
                                            <i class='bx bx-calendar text-primary text-2xl'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-primary font-semibold mb-2">Appointment Reminder</h3>
                                            <p class="notification-message text-primary text-sm">Patient John Smith has
                                                an appointment with
                                                Dr. Sarah Johnson tomorrow at 10:00 AM.</p>
                                            <div class="mt-4 flex space-x-2">
                                                <button
                                                    class="confirm-btn px-3 py-1.5 bg-white border border-primary-lighter text-primary rounded-md hover:bg-primary-light transition-colors duration-fast"
                                                    data-appointment-id="A12345" data-patient-name="John Smith">
                                                    Confirm
                                                </button>
                                                <button
                                                    class="view-patient-btn px-3 py-1.5 bg-primary text-white border border-primary rounded-md hover:bg-primary-dark transition-colors duration-fast"
                                                    data-patient-id="P12345">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 mr-2">May 14, 2023</span>
                                        <div class="w-2 h-2 rounded-full bg-gray-900"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Appointment Confirmation Card -->
                            <div class="notification-card bg-[#f8faff] rounded-lg p-4 border border-primary-lighter">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="mt-1">
                                            <i class='bx bx-calendar text-primary text-2xl'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-primary font-semibold mb-2">Appointment Confirmation</h3>
                                            <p class="notification-message text-primary text-sm">Patient Emma Wilson's
                                                appointment with Dr. Michael Chen on May 22 at 2:30 PM has been
                                                confirmed.</p>
                                            <div class="mt-4 flex space-x-2">
                                                <button
                                                    class="view-patient-btn px-3 py-1.5 bg-primary text-white border border-primary rounded-md hover:bg-primary-dark transition-colors duration-fast"
                                                    data-patient-id="P12346">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">May 3, 2023</span>
                                </div>
                            </div>

                            <!-- Read Appointment Card -->
                            <div class="notification-card bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="mt-1">
                                            <i class='bx bx-calendar text-gray-600 text-2xl'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-gray-800 font-semibold mb-2">Appointment Confirmation</h3>
                                            <p class="notification-message text-gray-700 text-sm">Patient Robert
                                                Johnson's appointment with Dr. Michael Chen on May 22 at 2:30 PM has
                                                been confirmed.</p>
                                            <div class="mt-4 flex space-x-2">
                                                <button
                                                    class="view-patient-btn px-3 py-1.5 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition-colors duration-fast"
                                                    data-patient-id="P12347">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">May 3, 2023</span>
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
            // View switching functionality
            const notificationsView = document.getElementById('notificationsView');
            const patientAppView = document.getElementById('patientAppView');
            const viewButtons = document.querySelectorAll('.view-patient-btn');
            const backButton = document.getElementById('backToNotifications');
            const confirmButtons = document.querySelectorAll('.confirm-btn');

            // Function to show patient details
            function showPatientDetails(patientId) {
                // Hide notifications view
                notificationsView.classList.remove('visible-view');
                notificationsView.classList.add('hidden-view');

                // Show patient app view
                patientAppView.classList.remove('hidden-view');
                patientAppView.classList.add('visible-view');

                // You can use patientId to load specific patient data if needed
                console.log('Viewing patient:', patientId);

                // Scroll to top
                window.scrollTo(0, 0);
            }

            // Function to go back to notifications
            function showNotifications() {
                // Hide patient app view
                patientAppView.classList.remove('visible-view');
                patientAppView.classList.add('hidden-view');

                // Show notifications view
                notificationsView.classList.remove('hidden-view');
                notificationsView.classList.add('visible-view');

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

            // Add click event to all confirm buttons
            confirmButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const appointmentId = this.getAttribute('data-appointment-id');
                    const patientName = this.getAttribute('data-patient-name');

                    console.log('Confirming appointment:', appointmentId);

                    toastSystem.success(`Appointment for ${patientName} confirmed successfully!`);
                    this.style.display = 'none';
                });
            });

            if (backButton) {
                backButton.addEventListener('click', showNotifications);
            }
        });
    </script>
</body>

</html>