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

                <!-- Appointments Overview (initially visible) -->
                <section id="appointmentsView" class="p-6 view-transition visible-view">
                    <!-- Header section -->
                    <div class="mb-4">
                        <h2 class="text-3xl font-bold text-gray-900 font-heading">Appointments Overview</h2>
                        <p class="text-sm text-gray-500">Summary of all scheduled appointments</p>
                    </div>
                    <div class="filter-section">
                        <div class="tab-container mb-4">
                            <button class="tab-button active">Upcoming</button>
                            <button class="tab-button">Past</button>
                            <button class="tab-button">All</button>
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
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 calendar-icon"
                                        style="padding-left: 6rem;">
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

                            <!-- Clear Filters Button - using existing onclick function -->
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

                    <!-- Table section (unchanged) -->
                    <div class="card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="p-4">
                            <table class="appointments-table">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Date & Time</th>
                                        <th>Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="patient-info ">
                                                <span class="font-medium text-md">Keyan Andy Delgado</span>
                                                <span class="patient-id text-xs text-gray-500">P12349</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-time">
                                                5/19/2023
                                                <span class="text-xs text-gray-500">3:30 PM</span>
                                            </span>
                                        </td>
                                        <td><span class="appointment-type checkup">Checkup</span></td>
                                        <td>Diabetes monitoring</td>
                                        <td><span class="status-badge completed">Completed</span></td>
                                        <td>
                                            <button class="action-button secondary view-patient-btn"
                                                data-patient-id="P12349">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="patient-info">
                                                <span class="font-medium text-md">David Wilson</span>
                                                <span class="patient-id text-xs text-gray-500">P12349</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-time">
                                                5/19/2023
                                                <span class="text-xs text-gray-500">3:30 PM</span>
                                            </span>
                                        </td>
                                        <td><span class="appointment-type follow-up">Follow-up</span></td>
                                        <td>Follow-up on lab results</td>
                                        <td><span class="status-badge no-show">No-Show</span></td>
                                        <td><button class="action-button secondary view-patient-btn"
                                                data-patient-id="P12350">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="patient-info">
                                                <span class="font-medium text-md">David Wilson</span>
                                                <span class="patient-id text-xs text-gray-500">P12349</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-time">
                                                5/19/2023
                                                <span class="text-xs text-gray-500">3:30 PM</span>
                                            </span>
                                        </td>
                                        <td><span class="appointment-type procedure">Procedure</span></td>
                                        <td>Colonoscopy</td>
                                        <td><span class="status-badge cancelled">Cancelled</span></td>
                                        <td><button class="action-button secondary view-patient-btn"
                                                data-patient-id="P12351">View</button></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="patient-info">
                                                <span class="font-medium text-md">David Wilson</span>
                                                <span class="patient-id text-xs text-gray-500">P12349</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-time">
                                                5/19/2023
                                                <span class="text-xs text-gray-500">3:30 PM</span>
                                            </span>
                                        </td>
                                        <td><span class="appointment-type specialist">Specialist</span></td>
                                        <td>Cardiology consultation</td>
                                        <td><span class="status-badge scheduled">Scheduled</span></td>
                                        <td>
                                            <button class="action-button secondary view-patient-btn"
                                                data-patient-id="P12352">View</button>
                                            <button class="action-button secondary"
                                                style="background-color: #fee2e2; color: #dc2626; border-color: #dc2626;">Cancel</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="patient-info">
                                                <span class="font-medium text-md">David Wilson</span>
                                                <span class="patient-id text-xs text-gray-500">P12349</span>
                                            </span>
                                        </td>
                                        <td class="date-time">5/20/2023<br><span class="text-xs text-gray-500">3:00
                                                AM</span></td>
                                        <td><span class="appointment-type checkup">Checkup</span></td>
                                        <td>Annual physical examination</td>
                                        <td><span class="status-badge scheduled">Scheduled</span></td>
                                        <td>
                                            <button class="action-button secondary view-patient-btn"
                                                data-patient-id="P12353">View</button>
                                            <button class="action-button secondary"
                                                style="background-color: #fee2e2; color: #dc2626; border-color: #dc2626;">Cancel</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-4">
                                <a href="#" class="text-blue-500 text-sm underline">View All 10 Appointments</a>
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
            const appointmentsView = document.getElementById('appointmentsView');
            const patientAppView = document.getElementById('patientAppView');
            const viewButtons = document.querySelectorAll('.view-patient-btn');
            const backButton = document.getElementById('backToAppointments');

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

            // Function to go back to appointments
            function showAppointments() {
                // Hide patient app view
                patientAppView.classList.remove('visible-view');
                patientAppView.classList.add('hidden-view');

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

            // Add click event to back button
            if (backButton) {
                backButton.addEventListener('click', showAppointments);
            }
        });
    </script>
</body>

</html>