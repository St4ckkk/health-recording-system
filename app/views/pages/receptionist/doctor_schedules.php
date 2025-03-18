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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/doctor-schedules.css">
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
                        <?php if (!empty($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <?php
                                $availableDays = $doctor->available_days ?? [];
                                $dayAbbreviations = [
                                    'Monday' => ['abbr' => 'Mon', 'class' => 'day-mon'],
                                    'Tuesday' => ['abbr' => 'Tue', 'class' => 'day-tue'],
                                    'Wednesday' => ['abbr' => 'Wed', 'class' => 'day-wed'],
                                    'Thursday' => ['abbr' => 'Thu', 'class' => 'day-thu'],
                                    'Friday' => ['abbr' => 'Fri', 'class' => 'day-fri'],
                                    'Saturday' => ['abbr' => 'Sat', 'class' => 'day-sat'],
                                    'Sunday' => ['abbr' => 'Sun', 'class' => 'day-sun']
                                ];
                                ?>
                                <div class="doctor-card bg-white shadow-sm border border-gray-200">
                                    <div class="p-6">
                                        <div class="flex items-start mb-4">
                                            <div class="doctor-avatar">
                                                <i class="bx bx-user"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">Dr.
                                                    <?= htmlspecialchars($doctor->full_name) ?>
                                                </h3>
                                                <p class="text-primary font-medium">
                                                    <?= htmlspecialchars($doctor->specialization) ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                                            <div>
                                                <?php if (!empty($availableDays)): ?>
                                                    <?php foreach ($availableDays as $day): ?>
                                                        <span
                                                            class="schedule-day <?= $dayAbbreviations[$day]['class'] ?>"><?= $dayAbbreviations[$day]['abbr'] ?></span>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-500">Not available</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center mt-4">
                                            <span class="text-sm text-gray-500">
                                                <i class="bx bx-time text-gray-400 mr-1"></i>
                                                <?php
                                                if (!empty($doctor->work_hours_start) && !empty($doctor->work_hours_end)) {
                                                    // Format times to ensure AM/PM display
                                                    $start_time = date('g:i A', strtotime($doctor->work_hours_start));
                                                    $end_time = date('g:i A', strtotime($doctor->work_hours_end));
                                                    echo htmlspecialchars($start_time) . ' - ' . htmlspecialchars($end_time);
                                                } else {
                                                    echo '9:00 AM - 5:00 PM';
                                                }
                                                ?>
                                            </span>
                                            <button
                                                class="view-schedule-btn px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast"
                                                data-doctor-id="<?= $doctor->id ?>">
                                                View Schedule
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">No doctors found. Please add a doctor to get started.</p>
                            </div>
                        <?php endif; ?>
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

    <script src="<?= BASE_URL ?>/js/doctor-schedules.js"></script>
</body>

</html>