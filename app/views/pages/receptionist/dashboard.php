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
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/receptionist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/receptionist/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="mb-3">
                        <h2 class="text-3xl font-bold text-gray-900 font-heading">Receptionist Dashboard</h2>
                        <p class="text-sm text-gray-500">Manage patient appointments and schedule</p>
                    </div>
                    <div class="flex gap-2">
                        <!-- Upcoming Appointments -->
                        <div class="card card-upcoming bg-white shadow-md rounded-lg p-4 w-full max-w-full  fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Upcoming Appointments</h3>
                            <p class="text-sm text-gray-500">Future scheduled visits</p>
                            <div class="mt-2 space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Sarah Johnson</p>
                                        <p class="text-sm text-gray-500">Annual Checkup</p>
                                    </div>
                                    <span class="badge-upcoming text-white px-3 py-1 rounded text-xs">May 15, 10:00
                                        AM</span>
                                </div>
                                <hr class="border-gray-200 my-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Michael Chen</p>
                                        <p class="text-sm text-gray-500">Dental Cleaning</p>
                                    </div>
                                    <span class="badge-upcoming text-white px-3 py-1 rounded text-xs">May 15, 10:00
                                        AM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Appointments -->
                        <div class="card card-today bg-white shadow-md rounded-lg p-4 w-full max-w-full  fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Today's Appointments</h3>
                            <p class="text-sm text-gray-500">Current day's appointments</p>
                            <div class="mt-2 space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Sarah Johnson</p>
                                        <p class="text-sm text-gray-500">Annual Checkup</p>
                                    </div>
                                    <span class="badge-today text-white px-3 py-1 rounded text-xs">Today, 10:00
                                        AM</span>
                                </div>
                                <hr class="border-gray-200 my-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Michael Chen</p>
                                        <p class="text-sm text-gray-500">Dental Cleaning</p>
                                    </div>
                                    <span class="badge-today text-white px-3 py-1 rounded text-xs">Today, 2:30 PM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Past Appointments -->
                        <div class="card card-past bg-white shadow-md rounded-lg p-4 w-full max-w-full  fade-in">
                            <h3 class="text-medium font-medium text-gray-900">Past Appointments</h3>
                            <p class="text-sm text-gray-500">Previously completed visits</p>
                            <div class="mt-2 space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Sarah Johnson</p>
                                        <p class="text-sm text-gray-500">Annual Checkup</p>
                                    </div>
                                    <span class="badge-past text-white px-3 py-1 rounded text-xs">Apr 22, 10:00
                                        AM</span>
                                </div>
                                <hr class="border-gray-200 my-2">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-900">Dr. Michael Chen</p>
                                        <p class="text-sm text-gray-500">Dental Cleaning</p>
                                    </div>
                                    <span class="badge-past text-white px-3 py-1 rounded text-xs">Mar 15, 10:00
                                        AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="p-6">
                    <div class="flex gap-6 w-full">
                        <!-- Left: Appointment List -->
                        <div class="card shadow-sm rounded-lg w-[450px]  fade-in">
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
                            <div class="appointment-list-container max-h-[430px] overflow-y-auto">
                                <!-- David Wilson -->
                                <div class="appointment-item active" data-patient="david">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-gray-900 font-medium">David Wilson</h4>
                                            <p class="text-xs  text-gray-500">Patient ID: P12349</p>
                                            <div class="flex items-center mt-1">
                                                <i class="bx bx-calendar text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">Saturday, May 20, 2023</span>
                                                <span class="mx-2 text-sm mr-1 ml-2">•</span>
                                                <i class="bx bx-time text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">01:15 PM</span>
                                            </div>
                                        </div>
                                        <span class="appointment-type checkup">Checkup</span>
                                    </div>
                                    <div>
                                        <span class="status-badge completed">
                                            <i class="bx bx-check-circle mr-1"></i>
                                            <span class="text-xs">
                                                Completed
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Sarah Brown -->
                                <div class="appointment-item" data-patient="sarah">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-gray-900 font-medium">Sarah Brown</h4>
                                            <p class="text-xs text-gray-500">Patient ID: P12350</p>
                                            <div class="flex items-center mt-1">
                                                <i class="bx bx-calendar text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">Saturday, May 20, 2023</span>
                                                <span class="mx-2 text-sm mr-1 ml-2">•</span>
                                                <i class="bx bx-time text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">01:15 PM</span>
                                            </div>
                                        </div>
                                        <span class="appointment-type follow-up">Follow-up</span>
                                    </div>
                                    <div>
                                        <span class="status-badge no-show">
                                            <i class="bx bx-error-circle mr-1"></i>
                                            <span class="text-xs">
                                                No show
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <!-- James Anderson -->
                                <div class="appointment-item" data-patient="james">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-gray-900 font-medium">James Anderson</h4>
                                            <p class="text-xs  text-gray-500">Patient ID: P12353</p>
                                            <div class="flex items-center mt-1">
                                                <i class="bx bx-calendar text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">Saturday, May 20, 2023</span>
                                                <span class="mx-2 text-sm mr-1 ml-2">•</span>
                                                <i class="bx bx-time text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">01:15 PM</span>
                                            </div>
                                        </div>
                                        <span class="appointment-type procedure">Procedure</span>
                                    </div>
                                    <div>
                                        <span class="status-badge cancelled">
                                            <i class="bx bx-x-circle mr-1"></i>
                                            <span class="text-xs">
                                                Cancelled
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Robert Johnson -->
                                <div class="appointment-item" data-patient="robert">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-gray-900 font-medium">Robert Johnson</h4>
                                            <p class="text-xs  text-gray-500">Patient ID: P12347</p>
                                            <div class="flex items-center mt-1">
                                                <i class="bx bx-calendar text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">Saturday, May 20, 2023</span>
                                                <span class="mx-2 text-sm mr-1 ml-2">•</span>
                                                <i class="bx bx-time text-gray-400 text-sm mr-1"></i>
                                                <span class="text-sm">01:15 PM</span>
                                            </div>
                                        </div>
                                        <span class="appointment-type specialist">Specialist</span>
                                    </div>
                                    <div>
                                        <span class="status-badge scheduled">
                                            <i class="bx bx-time mr-1 "></i>
                                            <span class="text-xs">
                                                Scheduled
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Appointment Details -->
                        <div id="appointmentDetails" class="card bg-white shadow-sm rounded-lg p-6 flex-1 fade-in">
                            <!-- David Wilson's details (default) -->
                            <div id="david-details" class="patient-details">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-md font-medium text-gray-900">David Wilson</h3>
                                        <p class="text-sm text-gray-400">Appointment Details</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="appointment-type checkup px-2 py-2">Checkup</span>
                                        <span
                                            class="appointment-type border border-success px-1 py-1 rounded text-sm text-success status">Completed</span>
                                    </div>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-section">
                                        <p class="detail-label font-medium">Appointment ID</p>
                                        <p class="detail-value">A1005</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Patient ID</p>
                                        <p class="detail-value">P12349</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Date</p>
                                        <p class="detail-value">Friday, May 19, 2023</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Time</p>
                                        <p class="detail-value">03:30 PM</p>
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
                                                <td class="text-sm text-gray-900 py-2">Annual physical examination</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Main Clinic, Room 101</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                                                <td class="text-sm text-gray-900 py-2">Patient has history of
                                                    hypertension</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Blue Cross #BC987654</td>
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
                                            (555) 567-8901
                                        </p>
                                        <p class="contact-info">
                                            <i class="bx bx-envelope text-gray-500 mr-2"></i>
                                            david.wilson@example.com
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-6">
                                    <div class="flex-1">
                                        <button class="action-button border border-danger text-danger">
                                            <i class="bx bx-x-circle text-danger mr-2 text-md"></i>
                                            Cancel Appointment
                                        </button>
                                    </div>
                                    <button class="action-button secondary">
                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                        Confirm
                                    </button>
                                    <button class="action-button secondary">
                                        <i class="bx bx-calendar mr-2 text-md"></i>
                                        Reschedule
                                    </button>
                                    <button class="action-button bg-gray-900">
                                        <i class="bx bx-file mr-2 text-white text-md"></i>
                                        <span class="text-white">
                                            Patient Record
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Sarah Brown's details (hidden by default) -->
                            <div id="sarah-details" class="patient-details hidden">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-md font-medium text-gray-900">Sarah Brown</h3>
                                        <p class="text-sm text-gray-400">Appointment Details</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="appointment-type follow-up px-2 py-2">Follow-up</span>
                                        <span
                                            class="appointment-type border border-warning px-1 py-1 rounded text-sm text-warning status">No
                                            show</span>
                                    </div>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-section">
                                        <p class="detail-label font-medium">Appointment ID</p>
                                        <p class="detail-value">A1006</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Patient ID</p>
                                        <p class="detail-value">P12350</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Date</p>
                                        <p class="detail-value">Saturday, May 20, 2023</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Time</p>
                                        <p class="detail-value">01:15 PM</p>
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
                                                <td class="text-sm text-gray-900 py-2">Follow-up after surgery</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Main Clinic, Room 205</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                                                <td class="text-sm text-gray-900 py-2">Patient had appendectomy 2 weeks
                                                    ago</td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Aetna #AE456789</td>
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
                                            (555) 234-5678
                                        </p>
                                        <p class="contact-info">
                                            <i class="bx bx-envelope text-gray-500 mr-2"></i>
                                            sarah.brown@example.com
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-6">
                                    <div class="flex-1">
                                        <button class="action-button border border-primary text-primary">
                                            <i class="bx bx-phone text-primary mr-2 text-md"></i>
                                            Contact Patient
                                        </button>
                                    </div>
                                    <button class="action-button secondary">
                                        <i class="bx bx-calendar mr-2 text-md"></i>
                                        Reschedule
                                    </button>
                                    <button class="action-button bg-gray-900">
                                        <i class="bx bx-file mr-2 text-white text-md"></i>
                                        <span class="text-white">
                                            Patient Record
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- James Anderson's details (hidden by default) -->
                            <div id="james-details" class="patient-details hidden">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-md font-medium text-gray-900">James Anderson</h3>
                                        <p class="text-sm text-gray-400">Appointment Details</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="appointment-type procedure px-2 py-2">Procedure</span>
                                        <span
                                            class="appointment-type border border-danger px-1 py-1 rounded text-sm text-danger status">Cancelled</span>
                                    </div>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-section">
                                        <p class="detail-label font-medium">Appointment ID</p>
                                        <p class="detail-value">A1007</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Patient ID</p>
                                        <p class="detail-value">P12353</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Date</p>
                                        <p class="detail-value">Saturday, May 20, 2023</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Time</p>
                                        <p class="detail-value">01:15 PM</p>
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
                                                <td class="text-sm text-gray-900 py-2">Colonoscopy procedure</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Surgical Center, Room 3</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                                                <td class="text-sm text-gray-900 py-2">Patient cancelled due to illness
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">United Health #UH789012</td>
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
                                            (555) 345-6789
                                        </p>
                                        <p class="contact-info">
                                            <i class="bx bx-envelope text-gray-500 mr-2"></i>
                                            james.anderson@example.com
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-6">
                                    <div class="flex-1">
                                        <button class="action-button border border-primary text-primary">
                                            <i class="bx bx-calendar text-primary mr-2 text-md"></i>
                                            Reschedule Appointment
                                        </button>
                                    </div>
                                    <button class="action-button secondary">
                                        <i class="bx bx-phone mr-2 text-md"></i>
                                        Contact Patient
                                    </button>
                                    <button class="action-button bg-gray-900">
                                        <i class="bx bx-file mr-2 text-white text-md"></i>
                                        <span class="text-white">
                                            Patient Record
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Robert Johnson's details (hidden by default) -->
                            <div id="robert-details" class="patient-details hidden">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-md font-medium text-gray-900">Robert Johnson</h3>
                                        <p class="text-sm text-gray-400">Appointment Details</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="appointment-type specialist px-2 py-2">Specialist</span>
                                        <span
                                            class="appointment-type border border-info px-1 py-1 rounded text-sm text-info status">Scheduled</span>
                                    </div>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-section">
                                        <p class="detail-label font-medium">Appointment ID</p>
                                        <p class="detail-value">A1008</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Patient ID</p>
                                        <p class="detail-value">P12347</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Date</p>
                                        <p class="detail-value">Saturday, May 20, 2023</p>
                                    </div>
                                    <div class="detail-section">
                                        <p class="detail-label">Time</p>
                                        <p class="detail-value">01:15 PM</p>
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
                                                <td class="text-sm text-gray-900 py-2">Cardiology consultation</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Specialist Wing, Room 405</td>
                                            </tr>
                                            <tr class="border-b border-gray-200">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                                                <td class="text-sm text-gray-900 py-2">Patient has reported chest pain
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                                                </td>
                                                <td class="text-sm text-gray-900 py-2">Medicare #MC123456</td>
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
                                            (555) 456-7890
                                        </p>
                                        <p class="contact-info">
                                            <i class="bx bx-envelope text-gray-500 mr-2"></i>
                                            robert.johnson@example.com
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-6">
                                    <div class="flex-1">
                                        <button class="action-button border border-danger text-danger">
                                            <i class="bx bx-x-circle text-danger mr-2 text-md"></i>
                                            Cancel Appointment
                                        </button>
                                    </div>
                                    <button class="action-button secondary">
                                        <i class="bx bx-check-circle mr-2 text-md"></i>
                                        Confirm
                                    </button>
                                    <button class="action-button secondary">
                                        <i class="bx bx-bell mr-2 text-md"></i>
                                        Send Reminder
                                    </button>
                                    <button class="action-button bg-gray-900">
                                        <i class="bx bx-file mr-2 text-white text-md"></i>
                                        <span class="text-white">
                                            Patient Record
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="<?= BASE_URL ?>/js/reception.js"></script>
</body>

</html>