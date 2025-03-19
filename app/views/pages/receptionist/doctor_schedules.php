<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
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
                                            <?php if (!empty($doctor->profile)): ?>
                                                <div class="h-12 w-12 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                                    <img src="<?= BASE_URL ?>/<?= $doctor->profile ?>"
                                                        alt="Dr. <?= htmlspecialchars($doctor->full_name) ?>"
                                                        class="h-full w-full object-cover">
                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden flex-shrink-0">
                                                    <i class="bx bx-user text-xl"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ml-3">
                                                <h3 class="text-lg font-semibold text-gray-900">Dr.
                                                    <?= htmlspecialchars($doctor->full_name) ?>
                                                </h3>
                                                <p class="text-primary font-medium capitalize">
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
                            <h2 class="text-2xl font-bold text-gray-900" id="doctorScheduleTitle">Loading...</h2>
                        </div>
                        <button id="editScheduleBtn"
                            class="px-4 py-2 bg-primary text-white rounded-md flex items-center">
                            <i class="bx bx-edit mr-2"></i> Edit Schedule
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Doctor Info Card -->
                        <div id="doctorInfoCard" class="bg-white shadow-sm rounded-lg p-6 border border-gray-200">
                            <!-- Content will be dynamically populated -->
                            <div class="flex justify-center items-center h-40">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
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
                                <tbody id="scheduleTableBody">
                                    <!-- Schedule rows will be dynamically populated -->
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div
                                                class="animate-spin inline-block w-6 h-6 border-b-2 border-primary rounded-full">
                                            </div>
                                            <span class="ml-2">Loading schedule...</span>
                                        </td>
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
                                <tbody id="appointmentsTableBody">
                                    <!-- Appointment rows will be dynamically populated -->
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div
                                                class="animate-spin inline-block w-6 h-6 border-b-2 border-primary rounded-full">
                                            </div>
                                            <span class="ml-2">Loading appointments...</span>
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
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                                    <div class="flex flex-col md:flex-row items-start gap-6 mb-6">
                                        <div
                                            class="doctor-profile-preview h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden relative">
                                            <div class="profile-icon">
                                                <i class="bx bx-user text-3xl"></i>
                                            </div>
                                            <img id="profileImagePreview" class="hidden h-full w-full object-cover"
                                                alt="Doctor profile preview">
                                            <div
                                                class="upload-overlay absolute inset-0 bg-black bg-opacity-50 text-white text-xs flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                                Change Photo</div>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <div class="upload-btn-wrapper mb-2">
                                                <button class="upload-btn">
                                                    <i class="bx bx-upload"></i> Upload Photo
                                                </button>
                                                <input type="file" id="profileImage" name="profileImage"
                                                    accept="image/*">
                                            </div>
                                            <p class="text-xs text-gray-500">Recommended: Square image (1:1 ratio)</p>
                                            <p class="text-xs text-gray-500">Maximum size: 2MB</p>
                                            <p class="text-xs text-gray-500 mt-2">Supported formats: JPG, PNG</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label for="firstname" class="form-label">First Name*</label>
                                            <input type="text" id="firstname" name="firstname" class="form-input"
                                                placeholder="Enter first name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="lastname" class="form-label">Last Name*</label>
                                            <input type="text" id="lastname" name="lastname" class="form-input"
                                                placeholder="Enter last name" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div class="form-group">
                                            <label for="middlename" class="form-label">Middle Name</label>
                                            <input type="text" id="middlename" name="middlename" class="form-input"
                                                placeholder="Enter middle name (optional)">
                                        </div>

                                        <div class="form-group">
                                            <label for="suffix" class="form-label">Suffix</label>
                                            <input type="text" id="suffix" name="suffix" class="form-input"
                                                placeholder="MD, PhD, etc. (optional)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="specialty" class="form-label">Specialty*</label>
                                        <select id="specialty" name="specialty" class="form-select" required>
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email*</label>
                                            <input type="email" id="email" name="email" class="form-input"
                                                placeholder="doctor@example.com" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone*</label>
                                            <input type="tel" id="phone" name="phone" class="form-input"
                                                placeholder="(555) 123-4567" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Information -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule Information</h3>
                                    <div class="form-group">
                                        <label class="form-label">Work Hours*</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                            <div class="form-group">
                                                <label for="workHoursStart" class="form-label">Work Hours Start</label>
                                                <input type="time" id="workHoursStart" name="workHoursStart"
                                                    class="form-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="workHoursEnd" class="form-label">Work Hours End</label>
                                                <input type="time" id="workHoursEnd" name="workHoursEnd"
                                                    class="form-input">
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 ">General working hours for this doctor</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Available Days*</label>
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

                                    <div class="form-group time-slots-container">
                                        <label class="form-label">Time Slots*</label>
                                        <div id="timeSlots" class="time-slots">
                                            <div class="time-slot">
                                                <input type="time" class="time-slot-input" value="09:00" required>
                                                <span class="time-slot-separator">to</span>
                                                <input type="time" class="time-slot-input" value="12:00" required>
                                                <span class="time-slot-remove">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </div>
                                            <div class="time-slot">
                                                <input type="time" class="time-slot-input" value="13:00" required>
                                                <span class="time-slot-separator">to</span>
                                                <input type="time" class="time-slot-input" value="17:00" required>
                                                <span class="time-slot-remove">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button" id="addTimeSlot" class="add-time-slot mt-2">
                                            <i class="bx bx-plus"></i> Add Time Slot
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-group">
                                            <label for="location" class="form-label">Default Location*</label>
                                            <input type="text" id="location" name="location" class="form-input"
                                                placeholder="Main Clinic, Room 101" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="maxAppointments" class="form-label">Max Appointments Per
                                                Day*</label>
                                            <input type="number" id="maxAppointments" name="maxAppointments"
                                                class="form-input" min="1" placeholder="15" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="form-label">Status*</label>
                                        <select id="status" name="status" class="form-select" required>
                                            <option value="available">Available</option>
                                            <option value="not-available">Not Available</option>
                                            <option value="on_leave">On Leave</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="button" id="cancelForm"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-3 py-1 bg-primary text-white rounded-md hover:bg-primary-dark">
                                    Save Doctor
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="<?= BASE_URL ?>/js/doctor-schedules.js"></script>
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>
</body>

</html>