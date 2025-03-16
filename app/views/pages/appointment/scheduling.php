<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .day-button {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .day-button.available {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .day-button.available:hover {
            background-color: var(--primary);
            color: white;
        }

        .day-button.selected {
            background-color: var(--primary);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
        }

        .time-slot {
            transition: all 0.2s ease;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
        }

        .time-slot:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .time-slot.selected {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .form-input {
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .avatar {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row w-full bg-white max-w-6xl card">
        <!-- Left panel - Company info -->
        <div class="w-full md:w-2/5 p-8 border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50">
            <div class="mb-8">
                <div class="w-64 h-16 mb-12">
                    <div class="logo-container text-white p-4 inline-flex items-center">
                        <div class="mr-3">
                            <div class="logo">
                                <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
                            </div>
                        </div>
                        <span class="text-2xl font-bold">Test Clinic</span>
                    </div>
                </div>

                <div class="mt-16">
                    <div class="flex items-center mb-4">
                        <div class="avatar w-16 h-16 mr-4 shrink-0">
                            <i class="bx bx-user text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Dr. Abdul</h2>
                            <h1 class="text-gray-500 text-sm">Pulmonologist</h1>
                        </div>
                    </div>
                </div>

                <!-- Add selected appointment time display -->
                <div id="selectedAppointmentTime"
                    class="hidden mt-8 p-4 rounded-lg bg-primary-light border border-primary/10">
                    <div class="flex items-start">
                        <i class="bx bx-calendar-alt text-xl mt-1 mr-3 text-primary"></i>
                        <div>
                            <span id="appointmentTimeRange" class="block font-medium text-gray-800"></span>
                            <span id="appointmentFullDate" class="block text-gray-600"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel - Calendar and Form -->
        <div class="w-full md:w-3/5 p-8 relative border border-gray-200">
            <!-- Step 1: Calendar View -->
            <div id="calendarView" class="block fade-in">
                <div class="flex flex-col md:flex-row md:space-x-8">
                    <!-- Calendar Column -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Select a Date & Time</h2>

                        <div class="flex items-center justify-between mb-6">
                            <button id="prevMonth"
                                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                <i class="bx bx-chevron-left text-2xl"></i>
                            </button>

                            <span id="currentMonthYear" class="text-lg font-medium"></span>

                            <button id="nextMonth"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-light text-primary transition-colors">
                                <i class="bx bx-chevron-right text-2xl"></i>
                            </button>
                        </div>

                        <!-- Calendar grid - Will be generated dynamically -->
                        <div class="mb-4">
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                <div class="text-center text-sm font-medium text-gray-600">SUN</div>
                                <div class="text-center text-sm font-medium text-gray-600">MON</div>
                                <div class="text-center text-sm font-medium text-gray-600">TUE</div>
                                <div class="text-center text-sm font-medium text-gray-600">WED</div>
                                <div class="text-center text-sm font-medium text-gray-600">THU</div>
                                <div class="text-center text-sm font-medium text-gray-600">FRI</div>
                                <div class="text-center text-sm font-medium text-gray-600">SAT</div>
                            </div>

                            <div id="calendarGrid" class="grid grid-cols-7 gap-2">
                                <!-- Calendar days will be generated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots Column - Initially hidden -->
                    <div id="timeSlotContainer" class="hidden md:w-64 mt-8 md:mt-16 fade-in">
                        <h3 id="selectedDate" class="text-lg font-semibold text-gray-800 mb-4"></h3>

                        <div class="space-y-2">
                            <button class="time-slot w-full p-3 text-center" data-time="2:00pm">
                                2:00pm
                            </button>
                            <button class="time-slot w-full p-3 text-center" data-time="2:30pm">
                                2:30pm
                            </button>
                            <button class="time-slot w-full p-3 text-center" data-time="3:00pm">
                                3:00pm
                            </button>
                            <button class="time-slot w-full p-3 text-center" data-time="3:30pm">
                                3:30pm
                            </button>
                            <button class="time-slot w-full p-3 text-center" data-time="4:00pm">
                                4:00pm
                            </button>
                        </div>

                        <!-- Next button - Initially hidden -->
                        <button id="nextButton" class="hidden w-full mt-6 btn-primary py-3 px-6 rounded-lg">
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Patient Information Form (Initially Hidden) -->
            <div id="patientFormView" class="hidden fade-in">
                <div class="flex items-center mb-6">
                    <button id="backToCalendar"
                        class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="bx bx-arrow-back mr-2"></i>
                        Back
                    </button>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-6">Patient Information</h2>
                <form id="patientForm" class="space-y-6">
                    <!-- Patient Name Section -->
                    <div class="space-y-4">
                        <h3 class="section-title">Patient Name</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First
                                    Name*</label>
                                <input type="text" id="firstName" name="firstName" required class="form-input w-full">
                            </div>
                            <div>
                                <label for="middleName" class="block text-sm font-medium text-gray-700 mb-1">Middle
                                    Name</label>
                                <input type="text" id="middleName" name="middleName" class="form-input w-full">
                            </div>
                            <div>
                                <label for="surname"
                                    class="block text-sm font-medium text-gray-700 mb-1">Surname*</label>
                                <input type="text" id="surname" name="surname" required class="form-input w-full">
                            </div>
                            <div>
                                <label for="suffix" class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                                <select id="suffix" name="suffix" class="form-input w-full">
                                    <option value="">None</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="space-y-4">
                        <h3 class="section-title">Appointment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="appointmentType"
                                    class="block text-sm font-medium text-gray-700 mb-1">Appointment Type*</label>
                                <select id="appointmentType" name="appointmentType" required class="form-input w-full">
                                    <option value="">Select Type</option>
                                    <option value="New Patient">New Patient</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Procedure">Procedure</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="appointmentReason"
                                    class="block text-sm font-medium text-gray-700 mb-1">Reason for Appointment*</label>
                                <textarea id="appointmentReason" name="appointmentReason" required rows="3"
                                    class="form-input w-full"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Information -->
                    <div class="space-y-4">
                        <h3 class="section-title">Patient Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                    Birth*</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" required
                                    class="form-input w-full">
                            </div>
                            <div>
                                <label for="legalSex" class="block text-sm font-medium text-gray-700 mb-1">Legal
                                    Sex*</label>
                                <select id="legalSex" name="legalSex" required class="form-input w-full">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                                <textarea id="address" name="address" required rows="3"
                                    class="form-input w-full"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Information -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="isGuardian" name="isGuardian"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="isGuardian" class="ml-2 block text-sm text-gray-700">I am not the patient
                                (booking for someone else)</label>
                        </div>

                        <div id="guardianFields" class="hidden space-y-4 fade-in">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="guardianName"
                                        class="block text-sm font-medium text-gray-700 mb-1">Guardian Name*</label>
                                    <input type="text" id="guardianName" name="guardianName" class="form-input w-full">
                                </div>
                                <div>
                                    <label for="relationship"
                                        class="block text-sm font-medium text-gray-700 mb-1">Relationship to
                                        Patient*</label>
                                    <select id="relationship" name="relationship" class="form-input w-full">
                                        <option value="">Select</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Child">Child</option>
                                        <option value="Sibling">Sibling</option>
                                        <option value="Caregiver">Caregiver</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full btn-primary py-3 px-6 rounded-lg">
                            Submit Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Calendar state
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth(); // Get current month dynamically
            let currentYear = currentDate.getFullYear(); // Get current year dynamically
            let selectedDay = null;
            let selectedMonth = null;
            let selectedYear = null;
            let selectedTime = null;

            // DOM elements
            const calendarGrid = document.getElementById('calendarGrid');
            const currentMonthYearElement = document.getElementById('currentMonthYear');
            const prevMonthButton = document.getElementById('prevMonth');
            const nextMonthButton = document.getElementById('nextMonth');
            const timeSlotContainer = document.getElementById('timeSlotContainer');
            const selectedDateElement = document.getElementById('selectedDate');
            const timeSlotButtons = document.querySelectorAll('.time-slot');
            const nextButton = document.getElementById('nextButton');

            // Form view elements
            const calendarView = document.getElementById('calendarView');
            const patientFormView = document.getElementById('patientFormView');
            const backToCalendarButton = document.getElementById('backToCalendar');
            const formDate = document.getElementById('formDate');
            const formTime = document.getElementById('formTime');
            const isGuardianCheckbox = document.getElementById('isGuardian');
            const guardianFields = document.getElementById('guardianFields');
            const patientForm = document.getElementById('patientForm');

            // Selected appointment time display elements
            const selectedAppointmentTime = document.getElementById('selectedAppointmentTime');
            const appointmentTimeRange = document.getElementById('appointmentTimeRange');
            const appointmentFullDate = document.getElementById('appointmentFullDate');

            // Mock data for available dates - adjusted to include current year/month
            // Format: { year: { month: [days] } }
            const availableDates = {};

            // Add current year if not present
            if (!availableDates[currentYear]) {
                availableDates[currentYear] = {};
            }

            // Add some sample available dates for current month and next month
            if (!availableDates[currentYear][currentMonth]) {
                // Get current day
                const today = currentDate.getDate();
                // Add some available dates starting from tomorrow
                const availableDaysThisMonth = [];
                for (let i = today + 1; i <= Math.min(today + 15, 28); i += 2) {
                    availableDaysThisMonth.push(i);
                }
                availableDates[currentYear][currentMonth] = availableDaysThisMonth;
            }

            // Add some dates for next month
            const nextMonth = currentMonth + 1 > 11 ? 0 : currentMonth + 1;
            const nextMonthYear = nextMonth === 0 ? currentYear + 1 : currentYear;

            if (!availableDates[nextMonthYear]) {
                availableDates[nextMonthYear] = {};
            }

            if (!availableDates[nextMonthYear][nextMonth]) {
                const availableDaysNextMonth = [];
                for (let i = 1; i <= 15; i += 2) {
                    availableDaysNextMonth.push(i);
                }
                availableDates[nextMonthYear][nextMonth] = availableDaysNextMonth;
            }

            // Initialize calendar
            generateCalendar(currentMonth, currentYear);

            // Make sure time slots are hidden initially
            timeSlotContainer.classList.add('hidden');

            // Event listeners for month navigation
            prevMonthButton.addEventListener('click', function () {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                generateCalendar(currentMonth, currentYear);

                // Hide time slots when changing months
                timeSlotContainer.classList.add('hidden');
                nextButton.classList.add('hidden');
            });

            nextMonthButton.addEventListener('click', function () {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                generateCalendar(currentMonth, currentYear);

                // Hide time slots when changing months
                timeSlotContainer.classList.add('hidden');
                nextButton.classList.add('hidden');
            });

            // Time slot selection handling
            timeSlotButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Remove selection from all time slots
                    timeSlotButtons.forEach(btn => {
                        btn.classList.remove('selected');
                    });

                    // Add selection to clicked time slot
                    this.classList.add('selected');

                    // Store selected time
                    selectedTime = this.getAttribute('data-time');

                    // Show next button
                    nextButton.classList.remove('hidden');

                    // Update appointment time display
                    updateAppointmentTimeDisplay();
                });
            });

            // Function to update appointment time display
            function updateAppointmentTimeDisplay() {
                if (selectedDay && selectedMonth !== null && selectedYear && selectedTime) {
                    const selectedDate = new Date(selectedYear, selectedMonth, selectedDay);

                    // Calculate end time (15 minutes after start time)
                    const startTime = selectedTime;
                    let endTime = "";

                    // Parse the time string to get hours and minutes
                    const timeMatch = startTime.match(/(\d+):(\d+)([ap]m)/);
                    if (timeMatch) {
                        const [_, hours, minutes, ampm] = timeMatch;
                        const hour = parseInt(hours);
                        const minute = parseInt(minutes);

                        // Create a new date object for end time calculation
                        const endDate = new Date(selectedDate);

                        // Set hours (convert to 24-hour format if needed)
                        if (ampm.toLowerCase() === 'pm' && hour < 12) {
                            endDate.setHours(hour + 12);
                        } else if (ampm.toLowerCase() === 'am' && hour === 12) {
                            endDate.setHours(0);
                        } else {
                            endDate.setHours(hour);
                        }

                        // Set minutes and add 15 minutes
                        endDate.setMinutes(minute + 15);

                        // Format the end time
                        endTime = endDate.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        }).toLowerCase();
                    } else {
                        // Fallback if time parsing fails
                        endTime = "15 minutes later";
                    }

                    // Format the full date
                    const formattedDate = selectedDate.toLocaleDateString('en-US', {
                        weekday: 'long',
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    // Update the display
                    appointmentTimeRange.textContent = `${startTime} - ${endTime}`;
                    appointmentFullDate.textContent = formattedDate;
                    selectedAppointmentTime.classList.remove('hidden');
                }
            }

            // Next button click - Show patient form
            nextButton.addEventListener('click', function () {
                if (selectedDay && selectedMonth !== null && selectedYear && selectedTime) {
                    // Hide calendar view and show form view
                    calendarView.classList.add('hidden');
                    patientFormView.classList.remove('hidden');

                    // Set appointment date and time in the form
                    const selectedDate = new Date(selectedYear, selectedMonth, selectedDay);
                    const formattedDate = selectedDate.toLocaleDateString('en-US', {
                        weekday: 'long',
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    // Update the form fields
                    formDate.textContent = formattedDate;
                    formTime.textContent = selectedTime;
                }
            });

            // Back button click - Return to calendar
            backToCalendarButton.addEventListener('click', function () {
                patientFormView.classList.add('hidden');
                calendarView.classList.remove('hidden');
            });

            // Guardian checkbox toggle
            isGuardianCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    guardianFields.classList.remove('hidden');
                    document.getElementById('guardianName').setAttribute('required', 'required');
                    document.getElementById('relationship').setAttribute('required', 'required');
                } else {
                    guardianFields.classList.add('hidden');
                    document.getElementById('guardianName').removeAttribute('required');
                    document.getElementById('relationship').removeAttribute('required');
                }
            });

            // Form submission
            patientForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Here you would typically send the form data to your server
                alert('Appointment submitted successfully!');

                // For demo purposes, reset the form and go back to calendar
                this.reset();
                guardianFields.classList.add('hidden');
                patientFormView.classList.add('hidden');
                calendarView.classList.remove('hidden');

                // Reset selected time
                selectedTime = null;
                selectedAppointmentTime.classList.add('hidden');
            });

            // Function to generate calendar
            function generateCalendar(month, year) {
                // Update month/year display
                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
                currentMonthYearElement.textContent = `${monthNames[month]} ${year}`;

                // Clear previous calendar
                calendarGrid.innerHTML = '';

                // Get first day of month and total days in month
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before the 1st of the month
                for (let i = 0; i < firstDay; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-10';
                    calendarGrid.appendChild(emptyCell);
                }

                // Add days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayCell = document.createElement('div');
                    dayCell.className = 'text-center';

                    const dayButton = document.createElement('button');
                    dayButton.textContent = day;

                    // Check if this date is available
                    const isAvailable = availableDates[year]?.[month]?.includes(day) || false;
                    const isSelected = selectedDay === day && selectedMonth === month && selectedYear === year;

                    // Set appropriate classes
                    dayButton.className = 'day-button';

                    if (isAvailable) {
                        dayButton.classList.add('available');
                        if (isSelected) {
                            dayButton.classList.add('selected');
                        }
                    } else {
                        dayButton.classList.add('text-gray-400');
                    }

                    // Add click event only for available dates
                    if (isAvailable) {
                        dayButton.addEventListener('click', function () {
                            // Update selected date
                            selectedDay = day;
                            selectedMonth = month;
                            selectedYear = year;

                            // Update calendar UI
                            updateCalendarSelection();

                            // Show time slots
                            timeSlotContainer.classList.remove('hidden');

                            // Update selected date text with dynamic date formatting
                            const selectedDate = new Date(year, month, day);
                            const formattedDate = selectedDate.toLocaleDateString('en-US', {
                                weekday: 'long',
                                month: 'long',
                                day: 'numeric'
                            });
                            selectedDateElement.textContent = formattedDate;

                            // Reset time slot selections
                            timeSlotButtons.forEach(btn => {
                                btn.classList.remove('selected');
                            });
                            selectedTime = null;
                            nextButton.classList.add('hidden');

                            // Hide appointment time display until a time is selected
                            selectedAppointmentTime.classList.add('hidden');
                        });
                    }

                    dayCell.appendChild(dayButton);
                    calendarGrid.appendChild(dayCell);
                }
            }

            // Function to update calendar selection UI
            function updateCalendarSelection() {
                const dayButtons = calendarGrid.querySelectorAll('.day-button');

                dayButtons.forEach(button => {
                    const day = parseInt(button.textContent);
                    const isAvailable = availableDates[currentYear]?.[currentMonth]?.includes(day) || false;
                    const isSelected = selectedDay === day && selectedMonth === currentMonth && selectedYear === currentYear;

                    // Reset classes
                    button.classList.remove('selected');

                    if (isAvailable) {
                        if (isSelected) {
                            button.classList.add('selected');
                        }
                    }
                });

                // Update appointment time display if time is already selected
                if (selectedTime) {
                    updateAppointmentTimeDisplay();
                }
            }

            // Generate initial calendar with current date
            generateCalendar(currentMonth, currentYear);

            // Don't set any initial selection - make user click on a date
        });
    </script>
</body>

</html>