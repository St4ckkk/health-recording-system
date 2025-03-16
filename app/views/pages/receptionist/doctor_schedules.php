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
            background: linear-gradient(to right, rgba(55, 48, 163, 0.9), rgba(79, 70, 229, 0.7));
            z-index: 1;
        }

        .image-header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 2;
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

        /* Doctor card styles */
        .doctor-card {
            border-radius: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        .doctor-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #6b7280;
            margin-right: 1rem;
        }

        .schedule-day {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .day-mon {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .day-tue {
            background-color: #dcfce7;
            color: #15803d;
        }

        .day-wed {
            background-color: #fef3c7;
            color: #b45309;
        }

        .day-thu {
            background-color: #ffedd5;
            color: #c2410c;
        }

        .day-fri {
            background-color: #fce7f3;
            color: #be185d;
        }

        .day-sat {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .day-sun {
            background-color: #f3e8ff;
            color: #7e22ce;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-input:focus {
            border-color: #6366f1;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            appearance: none;
        }

        .form-select:focus {
            border-color: #6366f1;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-input {
            margin-right: 0.5rem;
        }

        .time-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .time-slot {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background-color: #f9fafb;
        }

        .time-slot-input {
            width: 5rem;
            padding: 0.25rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            text-align: center;
        }

        .time-slot-separator {
            margin: 0 0.25rem;
        }

        .time-slot-remove {
            margin-left: 0.5rem;
            color: #ef4444;
            cursor: pointer;
        }

        .add-time-slot {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border: 1px dashed #e5e7eb;
            border-radius: 0.375rem;
            background-color: #f9fafb;
            color: #6b7280;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .add-time-slot:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }

        .add-time-slot i {
            margin-right: 0.25rem;
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

        /* Filter section styles */
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

        /* Schedule table styles */
        .schedule-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .schedule-table th {
            background-color: #f9fafb;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 500;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .schedule-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .schedule-table tr:last-child td {
            border-bottom: none;
        }

        .schedule-time {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background-color: #f3f4f6;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.25rem;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/receptionist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/receptionist/components/header.php') ?>
            <div class="content-wrapper">
                <!-- Doctor List View (initially visible) -->
                <section id="doctorListView" class="p-6 view-transition visible-view">

                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Doctor Profiles</h2>
                            <p class="text-sm text-gray-500">View and manage doctor schedules</p>
                        </div>
                        <button id="addDoctorBtn" class="px-4 py-2 bg-primary text-white rounded-md flex items-center">
                            <i class="bx bx-plus mr-2"></i> Add Doctor
                        </button>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="filter-row">
                            <div class="filter-group" style="flex: 2;">
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search by doctor name or specialty..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Specialty</p>
                                <div class="relative">
                                    <select id="specialtyFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>All Specialties</option>
                                        <option>Cardiology</option>
                                        <option>Dermatology</option>
                                        <option>Neurology</option>
                                        <option>Pediatrics</option>
                                        <option>Orthopedics</option>
                                    </select>
                                </div>
                            </div>

                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Availability</p>
                                <div class="relative">
                                    <select id="availabilityFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>Any Day</option>
                                        <option>Monday</option>
                                        <option>Tuesday</option>
                                        <option>Wednesday</option>
                                        <option>Thursday</option>
                                        <option>Friday</option>
                                        <option>Saturday</option>
                                        <option>Sunday</option>
                                    </select>
                                </div>
                            </div>

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

                    <!-- Doctor Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Doctor Card 1 -->
                        <div class="doctor-card bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start mb-4">
                                    <div class="doctor-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Dr. Sarah Johnson</h3>
                                        <p class="text-primary font-medium">Cardiologist</p>
                                        <p class="text-sm text-gray-500 mt-1">15+ years experience</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                    <div>
                                        <span class="schedule-day day-mon">Mon</span>
                                        <span class="schedule-day day-wed">Wed</span>
                                        <span class="schedule-day day-fri">Fri</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="bx bx-time text-gray-400 mr-1"></i> 9:00 AM - 5:00 PM
                                    </span>
                                    <button
                                        class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                        data-doctor-id="D1001">
                                        View Schedule
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Card 2 -->
                        <div class="doctor-card bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start mb-4">
                                    <div class="doctor-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Dr. Michael Chen</h3>
                                        <p class="text-primary font-medium">Neurologist</p>
                                        <p class="text-sm text-gray-500 mt-1">10+ years experience</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                    <div>
                                        <span class="schedule-day day-tue">Tue</span>
                                        <span class="schedule-day day-thu">Thu</span>
                                        <span class="schedule-day day-sat">Sat</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="bx bx-time text-gray-400 mr-1"></i> 10:00 AM - 6:00 PM
                                    </span>
                                    <button
                                        class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                        data-doctor-id="D1002">
                                        View Schedule
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Card 3 -->
                        <div class="doctor-card bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start mb-4">
                                    <div class="doctor-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Dr. Emily Rodriguez</h3>
                                        <p class="text-primary font-medium">Pediatrician</p>
                                        <p class="text-sm text-gray-500 mt-1">8+ years experience</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                    <div>
                                        <span class="schedule-day day-mon">Mon</span>
                                        <span class="schedule-day day-tue">Tue</span>
                                        <span class="schedule-day day-wed">Wed</span>
                                        <span class="schedule-day day-thu">Thu</span>
                                        <span class="schedule-day day-fri">Fri</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="bx bx-time text-gray-400 mr-1"></i> 8:00 AM - 4:00 PM
                                    </span>
                                    <button
                                        class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                        data-doctor-id="D1003">
                                        View Schedule
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Card 4 -->
                        <div class="doctor-card bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start mb-4">
                                    <div class="doctor-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Dr. James Wilson</h3>
                                        <p class="text-primary font-medium">Orthopedic Surgeon</p>
                                        <p class="text-sm text-gray-500 mt-1">12+ years experience</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                    <div>
                                        <span class="schedule-day day-wed">Wed</span>
                                        <span class="schedule-day day-thu">Thu</span>
                                        <span class="schedule-day day-fri">Fri</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="bx bx-time text-gray-400 mr-1"></i> 9:00 AM - 3:00 PM
                                    </span>
                                    <button
                                        class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                        data-doctor-id="D1004">
                                        View Schedule
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Card 5 -->
                        <div class="doctor-card bg-white shadow-sm border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-start mb-4">
                                    <div class="doctor-avatar">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Dr. Sophia Kim</h3>
                                        <p class="text-primary font-medium">Dermatologist</p>
                                        <p class="text-sm text-gray-500 mt-1">7+ years experience</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                    <div>
                                        <span class="schedule-day day-mon">Mon</span>
                                        <span class="schedule-day day-tue">Tue</span>
                                        <span class="schedule-day day-sat">Sat</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm text-gray-500">
                                        <i class="bx bx-time text-gray-400 mr-1"></i> 10:00 AM - 6:00 PM
                                    </span>
                                    <button
                                        class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                        data-doctor-id="D1005">
                                        View Schedule
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Doctor Schedule Detail View (initially hidden) -->
                <section id="doctorScheduleView" class="p-6 view-transition hidden-view">
                    <button id="backToDoctorList" class="back-button">
                        <i class="bx bx-arrow-back"></i> Back to Doctor List
                    </button>

                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900" id="doctorScheduleTitle">Dr. Sarah Johnson's
                                Schedule</h2>
                            <p class="text-sm text-gray-500" id="doctorScheduleSubtitle">Cardiologist • 15+ years
                                experience
                            </p>
                        </div>
                        <button id="editScheduleBtn"
                            class="px-4 py-2 bg-primary text-white rounded-md flex items-center">
                            <i class="bx bx-edit mr-2"></i> Edit Schedule
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Doctor Info Card -->
                        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                            <div class="flex items-start mb-6">
                                <div class="doctor-avatar">
                                    <i class="bx bx-user"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Dr. Sarah Johnson</h3>
                                    <p class="text-primary font-medium">Cardiologist</p>
                                    <p class="text-sm text-gray-500 mt-1">15+ years experience</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Contact Information</h4>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600">
                                        <i class="bx bx-envelope text-gray-400 mr-2"></i> sarah.johnson@example.com
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <i class="bx bx-phone text-gray-400 mr-2"></i> (555) 123-4567
                                    </p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Specializations</h4>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">• Interventional Cardiology</p>
                                    <p class="text-sm text-gray-600">• Echocardiography</p>
                                    <p class="text-sm text-gray-600">• Heart Failure Management</p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Languages</h4>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">• English (Native)</p>
                                    <p class="text-sm text-gray-600">• Spanish (Fluent)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Table -->
                        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200 md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Weekly Schedule</h3>

                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Hours</th>
                                        <th>Location</th>
                                        <th>Max Appointments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-medium">Monday</td>
                                        <td>
                                            <span class="schedule-time">9:00 AM - 12:00 PM</span>
                                            <span class="schedule-time">1:00 PM - 5:00 PM</span>
                                        </td>
                                        <td>Main Clinic, Room 101</td>
                                        <td>15</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Tuesday</td>
                                        <td>Not Available</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Wednesday</td>
                                        <td>
                                            <span class="schedule-time">9:00 AM - 12:00 PM</span>
                                            <span class="schedule-time">1:00 PM - 5:00 PM</span>
                                        </td>
                                        <td>Cardiology Center, Room 305</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Thursday</td>
                                        <td>Not Available</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Friday</td>
                                        <td>
                                            <span class="schedule-time">9:00 AM - 12:00 PM</span>
                                            <span class="schedule-time">1:00 PM - 5:00 PM</span>
                                        </td>
                                        <td>Main Clinic, Room 101</td>
                                        <td>15</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Saturday</td>
                                        <td>Not Available</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium">Sunday</td>
                                        <td>Not Available</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Upcoming Appointments Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Appointments</h3>
                        <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Patient
                                        </th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Date</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Time</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Reason</th>
                                        <th class="text-left py-2 px-4 bg-gray-50 font-medium text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-3 px-4 border-b border-gray-200">John Smith</td>
                                        <td class="py-3 px-4 border-b border-gray-200">May 15, 2023</td>
                                        <td class="py-3 px-4 border-b border-gray-200">10:00 AM</td>
                                        <td class="py-3 px-4 border-b border-gray-200">Annual checkup</td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Confirmed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 border-b border-gray-200">Emma Wilson</td>
                                        <td class="py-3 px-4 border-b border-gray-200">May 15, 2023</td>
                                        <td class="py-3 px-4 border-b border-gray-200">11:30 AM</td>
                                        <td class="py-3 px-4 border-b border-gray-200">Follow-up</td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Scheduled</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 px-4 border-b border-gray-200">Robert Johnson</td>
                                        <td class="py-3 px-4 border-b border-gray-200">May 17, 2023</td>
                                        <td class="py-3 px-4 border-b border-gray-200">9:15 AM</td>
                                        <td class="py-3 px-4 border-b border-gray-200">Consultation</td>
                                        <td class="py-3 px-4 border-b border-gray-200">
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Scheduled</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Add/Edit Doctor Form View (initially hidden) -->
                <section id="doctorFormView" class="p-6 view-transition hidden-view">
                    <button id="backFromForm" class="back-button">
                        <i class="bx bx-arrow-back"></i> <span id="backButtonText">Back to Doctor List</span>
                    </button>

                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900" id="formTitle">Add New Doctor</h2>
                        <p class="text-sm text-gray-500" id="formSubtitle">Enter doctor details and schedule</p>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                        <form id="doctorForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                                    <div class="form-group">
                                        <label for="doctorName" class="form-label">Full Name</label>
                                        <input type="text" id="doctorName" class="form-input"
                                            placeholder="Dr. John Doe">
                                    </div>

                                    <div class="form-group">
                                        <label for="specialty" class="form-label">Specialty</label>
                                        <select id="specialty" class="form-select">
                                            <option value="">Select Specialty</option>
                                            <option value="cardiology">Cardiology</option>
                                            <option value="dermatology">Dermatology</option>
                                            <option value="neurology">Neurology</option>
                                            <option value="pediatrics">Pediatrics</option>
                                            <option value="orthopedics">Orthopedics</option>
                                            <option value="psychiatry">Psychiatry</option>
                                            <option value="ophthalmology">Ophthalmology</option>
                                            <option value="gynecology">Gynecology</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="experience" class="form-label">Years of Experience</label>
                                        <input type="number" id="experience" class="form-input" min="0"
                                            placeholder="10">
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-input"
                                            placeholder="doctor@example.com">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" id="phone" class="form-input" placeholder="(555) 123-4567">
                                    </div>
                                </div>

                                <!-- Schedule Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule Information</h3>

                                    <div class="form-group">
                                        <label class="form-label">Available Days</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="monday"> Monday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="tuesday"> Tuesday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="wednesday"> Wednesday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="thursday"> Thursday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="friday"> Friday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="saturday"> Saturday
                                            </label>
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="checkbox-input" name="availableDays"
                                                    value="sunday"> Sunday
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Time Slots</label>
                                        <div id="timeSlots" class="time-slots">
                                            <div class="time-slot">
                                                <input type="time" class="time-slot-input" value="09:00">
                                                <span class="time-slot-separator">to</span>
                                                <input type="time" class="time-slot-input" value="12:00">
                                                <span class="time-slot-remove">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </div>
                                            <div class="time-slot">
                                                <input type="time" class="time-slot-input" value="13:00">
                                                <span class="time-slot-separator">to</span>
                                                <input type="time" class="time-slot-input" value="17:00">
                                                <span class="time-slot-remove">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button" id="addTimeSlot" class="add-time-slot mt-2">
                                            <i class="bx bx-plus"></i> Add Time Slot
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <label for="location" class="form-label">Default Location</label>
                                        <input type="text" id="location" class="form-input"
                                            placeholder="Main Clinic, Room 101">
                                    </div>

                                    <div class="form-group">
                                        <label for="maxAppointments" class="form-label">Max Appointments Per Day</label>
                                        <input type="number" id="maxAppointments" class="form-input" min="1"
                                            placeholder="15">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="button" id="cancelForm"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                                    Save Doctor
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // View elements
            const doctorListView = document.getElementById('doctorListView');
            const doctorScheduleView = document.getElementById('doctorScheduleView');
            const doctorFormView = document.getElementById('doctorFormView');

            // Buttons
            const viewScheduleButtons = document.querySelectorAll('.view-schedule-btn');
            const backToDoctorListButton = document.getElementById('backToDoctorList');
            const addDoctorButton = document.getElementById('addDoctorBtn');
            const editScheduleButton = document.getElementById('editScheduleBtn');
            const backFromFormButton = document.getElementById('backFromForm');
            const cancelFormButton = document.getElementById('cancelForm');
            const addTimeSlotButton = document.getElementById('addTimeSlot');

            // Form elements
            const doctorForm = document.getElementById('doctorForm');
            const formTitle = document.getElementById('formTitle');
            const formSubtitle = document.getElementById('formSubtitle');
            const backButtonText = document.getElementById('backButtonText');
            const timeSlots = document.getElementById('timeSlots');

            // Function to show doctor list view
            function showDoctorListView() {
                doctorListView.classList.remove('hidden-view');
                doctorListView.classList.add('visible-view');

                doctorScheduleView.classList.remove('visible-view');
                doctorScheduleView.classList.add('hidden-view');

                doctorFormView.classList.remove('visible-view');
                doctorFormView.classList.add('hidden-view');

                window.scrollTo(0, 0);
            }

            // Function to show doctor schedule view
            function showDoctorScheduleView(doctorId) {
                doctorScheduleView.classList.remove('hidden-view');
                doctorScheduleView.classList.add('visible-view');

                doctorListView.classList.remove('visible-view');
                doctorListView.classList.add('hidden-view');

                doctorFormView.classList.remove('visible-view');
                doctorFormView.classList.add('hidden-view');

                // Here you would load the specific doctor's data based on doctorId
                console.log('Viewing schedule for doctor:', doctorId);

                window.scrollTo(0, 0);
            }

            // Function to show doctor form view
            function showDoctorFormView(isEdit = false, doctorId = null) {
                doctorFormView.classList.remove('hidden-view');
                doctorFormView.classList.add('visible-view');

                doctorListView.classList.remove('visible-view');
                doctorListView.classList.add('hidden-view');

                doctorScheduleView.classList.remove('visible-view');
                doctorScheduleView.classList.add('hidden-view');

                if (isEdit) {
                    formTitle.textContent = 'Edit Doctor Schedule';
                    formSubtitle.textContent = 'Update doctor details and schedule';
                    backButtonText.textContent = 'Back to Schedule';
                    // Here you would load the doctor's data into the form
                    console.log('Editing doctor:', doctorId);
                } else {
                    formTitle.textContent = 'Add New Doctor';
                    formSubtitle.textContent = 'Enter doctor details and schedule';
                    backButtonText.textContent = 'Back to Doctor List';
                    // Reset form
                    doctorForm.reset();
                }

                window.scrollTo(0, 0);
            }

            // Add event listeners for view schedule buttons
            viewScheduleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const doctorId = this.getAttribute('data-doctor-id');
                    showDoctorScheduleView(doctorId);
                });
            });

            // Add event listener for back to doctor list button
            backToDoctorListButton.addEventListener('click', showDoctorListView);

            // Add event listener for add doctor button
            addDoctorButton.addEventListener('click', function () {
                showDoctorFormView(false);
            });

            // Add event listener for edit schedule button
            editScheduleButton.addEventListener('click', function () {
                // Get the doctor ID from the current view
                const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
                showDoctorFormView(true, doctorId);
            });

            // Add event listener for back from form button
            backFromFormButton.addEventListener('click', function () {
                if (backButtonText.textContent === 'Back to Schedule') {
                    // Get the doctor ID from the current view
                    const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
                    showDoctorScheduleView(doctorId);
                } else {
                    showDoctorListView();
                }
            });

            // Add event listener for cancel form button
            cancelFormButton.addEventListener('click', function () {
                if (backButtonText.textContent === 'Back to Schedule') {
                    // Get the doctor ID from the current view
                    const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
                    showDoctorScheduleView(doctorId);
                } else {
                    showDoctorListView();
                }
            });

            // Add event listener for add time slot button
            addTimeSlotButton.addEventListener('click', function () {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.innerHTML = `
                    <input type="time" class="time-slot-input" value="09:00">
                    <span class="time-slot-separator">to</span>
                    <input type="time" class="time-slot-input" value="17:00">
                    <span class="time-slot-remove">
                        <i class="bx bx-x"></i>
                    </span>
                `;
                timeSlots.appendChild(timeSlot);

                // Add event listener for remove button
                const removeButton = timeSlot.querySelector('.time-slot-remove');
                removeButton.addEventListener('click', function () {
                    timeSlot.remove();
                });
            });

            // Add event listeners for existing time slot remove buttons
            document.querySelectorAll('.time-slot-remove').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('.time-slot').remove();
                });
            });

            // Add event listener for form submission
            doctorForm.addEventListener('submit', function (event) {
                event.preventDefault();

                // Here you would handle form submission, validation, and saving data
                console.log('Form submitted');

                // For demo purposes, just go back to the list view
                showDoctorListView();
            });

            // Function to clear filters
            window.clearFilters = function () {
                document.getElementById('specialtyFilter').value = 'All Specialties';
                document.getElementById('availabilityFilter').value = 'Any Day';
                document.querySelector('input[placeholder="Search by doctor name or specialty..."]').value = '';
            };
        });
    </script>
</body>

</html>