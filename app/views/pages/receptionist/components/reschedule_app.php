<div class="flex flex-col md:flex-row w-full bg-white max-w-6xl card">
    <!-- Left panel - Company info and appointment details -->
    <div class="w-full md:w-2/5 p-8 border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50">
        <div class="mb-8">

            <!-- Original appointment details -->
            <div class="mt-8 p-4 rounded-lg bg-white border border-gray-200 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Current Appointment</h3>
                <div class="flex items-start mb-3">
                    <i class="bx bx-calendar-alt text-xl mt-1 mr-3 text-primary"></i>
                    <div>   
                        <span class="block font-medium text-gray-800">Friday, May 19, 2023</span>
                        <span class="block text-gray-600">3:30 PM - 3:45 PM</span>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="bx bx-user-circle text-xl mt-1 mr-3 text-primary"></i>
                    <div>
                        <span class="block font-medium text-gray-800">Dr. Abdul</span>
                        <span class="block text-gray-600">Pulmonologist</span>
                    </div>
                </div>
            </div>


            <!-- New selected appointment time display -->
            <div id="selectedAppointmentTime"
                class="hidden mt-8 p-4 rounded-lg bg-primary-light border border-primary/10">
                <h3 class="text-md font-semibold text-gray-800 mb-2">New Appointment Time</h3>
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

    <!-- Right panel - Calendar and Confirmation -->
    <div class="w-full md:w-3/5 p-8 relative border border-gray-200">
        <!-- Step 1: Calendar View -->
        <div id="calendarView" class="block fade-in">
            <div class="flex flex-col md:flex-row md:space-x-8">
                <!-- Calendar Column -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Reschedule Appointment</h2>
                    <p class="text-gray-600 mb-6">Please select a new date and time for your appointment</p>

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

                    <!-- Confirm button - Initially hidden -->
                    <button id="nextButton" class="hidden w-full mt-6 btn-primary py-3 px-6 rounded-lg">
                        Confirm Reschedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 2: Confirmation View (Initially Hidden) -->
        <div id="patientFormView" class="hidden fade-in">
            <div class="flex items-center mb-6">
                <button id="backToCalendar"
                    class="flex items-center text-primary hover:text-primary-dark transition-colors">
                    <i class="bx bx-arrow-back mr-2"></i>
                    Back
                </button>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Confirm Rescheduling</h2>
            <p class="text-gray-600 mb-6">Please review the new appointment details</p>

            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="flex items-start mb-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-primary-light rounded-full flex items-center justify-center mr-4">
                        <i class="bx bx-calendar-alt text-xl text-primary"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">New Appointment</h3>
                        <p id="newAppointmentDate" class="text-gray-600"></p>
                        <p id="newAppointmentTime" class="text-gray-600"></p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                        <i class="bx bx-calendar-x text-xl text-gray-500"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Original Appointment</h3>
                        <p class="text-gray-600">Friday, May 19, 2023</p>
                        <p class="text-gray-600">3:30 PM - 3:45 PM</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                <h3 class="font-medium text-gray-900">Reason for Rescheduling (Optional)</h3>
                <textarea id="rescheduleReason" rows="3" class="form-input w-full"
                    placeholder="Please provide a reason for rescheduling your appointment"></textarea>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bx bx-info-circle text-amber-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800">Important Information</h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <p>Rescheduling within 24 hours of your appointment may incur a fee. Please review our
                                cancellation policy for more details.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button id="cancelReschedule"
                    class="flex-1 py-3 px-6 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button id="confirmReschedule" class="flex-1 btn-primary py-3 px-6 rounded-lg">
                    Confirm Reschedule
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .day-button {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .day-button.available {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .day-button.available:hover {
        background-color: #e5e7eb;
    }

    .day-button.selected {
        background-color: var(--primary);
        color: white;
    }

    .time-slot {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        background-color: #f9fafb;
        transition: all 0.2s;
    }

    .time-slot:hover {
        border-color: var(--primary);
        background-color: #f3f4f6;
    }

    .time-slot.selected {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Calendar state
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
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

        // Confirmation view elements
        const calendarView = document.getElementById('calendarView');
        const patientFormView = document.getElementById('patientFormView');
        const backToCalendarButton = document.getElementById('backToCalendar');
        const newAppointmentDate = document.getElementById('newAppointmentDate');
        const newAppointmentTime = document.getElementById('newAppointmentTime');
        const cancelRescheduleButton = document.getElementById('cancelReschedule');
        const confirmRescheduleButton = document.getElementById('confirmReschedule');

        // Selected appointment time display elements
        const selectedAppointmentTime = document.getElementById('selectedAppointmentTime');
        const appointmentTimeRange = document.getElementById('appointmentTimeRange');
        const appointmentFullDate = document.getElementById('appointmentFullDate');

        // Mock data for available dates
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

        // Next button click - Show confirmation view
        nextButton.addEventListener('click', function () {
            if (selectedDay && selectedMonth !== null && selectedYear && selectedTime) {
                // Hide calendar view and show confirmation view
                calendarView.classList.add('hidden');
                patientFormView.classList.remove('hidden');

                // Set appointment date and time in the confirmation
                const selectedDate = new Date(selectedYear, selectedMonth, selectedDay);
                const formattedDate = selectedDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });

                // Calculate end time
                const startTime = selectedTime;
                let endTime = "";
                const timeMatch = startTime.match(/(\d+):(\d+)([ap]m)/);
                if (timeMatch) {
                    const [_, hours, minutes, ampm] = timeMatch;
                    const hour = parseInt(hours);
                    const minute = parseInt(minutes);
                    const endDate = new Date(selectedDate);
                    if (ampm.toLowerCase() === 'pm' && hour < 12) {
                        endDate.setHours(hour + 12);
                    } else if (ampm.toLowerCase() === 'am' && hour === 12) {
                        endDate.setHours(0);
                    } else {
                        endDate.setHours(hour);
                    }
                    endDate.setMinutes(minute + 15);
                    endTime = endDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    }).toLowerCase();
                } else {
                    endTime = "15 minutes later";
                }

                // Update the confirmation fields
                newAppointmentDate.textContent = formattedDate;
                newAppointmentTime.textContent = `${startTime} - ${endTime}`;
            }
        });

        // Back button click - Return to calendar
        backToCalendarButton.addEventListener('click', function () {
            patientFormView.classList.add('hidden');
            calendarView.classList.remove('hidden');
        });

        // Cancel reschedule button
        cancelRescheduleButton.addEventListener('click', function () {
            // Just go back to calendar view
            patientFormView.classList.add('hidden');
            calendarView.classList.remove('hidden');
        });

        // Confirm reschedule button
        confirmRescheduleButton.addEventListener('click', function () {
            // Here you would typically send the rescheduling data to your server
            alert('Appointment successfully rescheduled!');

            // Redirect to appointments page (in a real app)
            window.location.href = 'appointments.php';
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
    });
</script>