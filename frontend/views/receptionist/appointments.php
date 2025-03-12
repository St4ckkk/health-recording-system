<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist</title>
    <link rel="stylesheet" href="../../node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="../../globals.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../output.css">
    <link rel="stylesheet" href="../assets/css/reception.css">
    <link rel="stylesheet" href="../../node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="../../node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="../../node_modules/flatpickr/dist/l10n/fr.js"></script>
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
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
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
                                    <i class='bx bx-filter-alt mr-1 text-lg'></i>
                                    <span class="text-xs font-medium">
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
                                            <a href="test_patient_app.php">
                                                <button class="action-button secondary">View</button>
                                            </a>
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
                                        <td><button class="action-button secondary">View</button></td>
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
                                        <td><button class="action-button secondary">View</button></td>
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
                                            <button class="action-button secondary">View</button>
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
                                            <button class="action-button secondary">View</button>
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
    <script src="../assets/js/reception.js"></script>
</body>

</html>