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
    const timeSlotsContainer = document.getElementById('timeSlots');
    const selectedDateElement = document.getElementById('selectedDate');
    const nextButton = document.getElementById('nextButton');

    // Form view elements
    const calendarView = document.getElementById('calendarView');
    const patientFormView = document.getElementById('patientFormView');
    const backToCalendarButton = document.getElementById('backToCalendar');
    const isGuardianCheckbox = document.getElementById('isGuardian');
    const guardianFields = document.getElementById('guardianFields');
    const patientForm = document.getElementById('patientForm');

    // Hidden form fields
    const appointmentDateField = document.getElementById('appointment_date');
    const appointmentTimeField = document.getElementById('appointment_time');

    // Selected appointment time display elements
    const selectedAppointmentTime = document.getElementById('selectedAppointmentTime');
    const appointmentTimeRange = document.getElementById('appointmentTimeRange');
    const appointmentFullDate = document.getElementById('appointmentFullDate');

    // Get the base URL from a data attribute or global variable
    const baseUrl = document.querySelector('meta[name="base-url"]')?.getAttribute('content') || window.baseUrl;

    // Get doctor data from data attributes
    const doctorId = document.getElementById('doctor_id')?.value;
    const doctorAvailableDaysElement = document.getElementById('doctor-available-days');
    const doctorAvailableDays = doctorAvailableDaysElement ? JSON.parse(doctorAvailableDaysElement.textContent) : [];

    // Convert day names to day numbers (0 = Sunday, 1 = Monday, etc.)
    const availableDayNumbers = [];
    doctorAvailableDays.forEach(day => {
        switch (day) {
            case 'Monday': availableDayNumbers.push(1); break;
            case 'Tuesday': availableDayNumbers.push(2); break;
            case 'Wednesday': availableDayNumbers.push(3); break;
            case 'Thursday': availableDayNumbers.push(4); break;
            case 'Friday': availableDayNumbers.push(5); break;
            case 'Saturday': availableDayNumbers.push(6); break;
            case 'Sunday': availableDayNumbers.push(0); break;
        }
    });

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

    // Function to handle time slot selection
    function handleTimeSlotSelection(e) {
        if (e.target.classList.contains('time-slot')) {
            // Remove selection from all time slots
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });

            // Add selection to clicked time slot
            e.target.classList.add('selected');

            // Store selected time
            selectedTime = e.target.getAttribute('data-time');

            // Set hidden form field
            appointmentTimeField.value = selectedTime;

            // Show next button
            nextButton.classList.remove('hidden');

            // Update appointment time display
            updateAppointmentTimeDisplay();
        }
    }

    // Function to update appointment time display
    function updateAppointmentTimeDisplay() {
        if (selectedDay && selectedMonth !== null && selectedYear && selectedTime) {
            const selectedDate = new Date(selectedYear, selectedMonth, selectedDay);

            // Calculate end time (30 minutes after start time instead of 15)
            const startTime = selectedTime;
            let endTime = "";

            // Parse the time string to get hours and minutes
            const [hours, minutes] = startTime.split(':');
            const hour = parseInt(hours);
            const minute = parseInt(minutes);

            // Create a new date object for end time calculation
            const endDate = new Date(selectedDate);
            endDate.setHours(hour);
            endDate.setMinutes(minute + 30); // Changed from 15 to 30 minutes

            // Format the end time
            endTime = endDate.toTimeString().substring(0, 5);

            // Format the full date
            const formattedDate = selectedDate.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });

            // Format times for display
            const displayStartTime = formatTimeForDisplay(startTime);
            const displayEndTime = formatTimeForDisplay(endTime);

            // Update the display
            appointmentTimeRange.textContent = `${displayStartTime} - ${displayEndTime}`;
            appointmentFullDate.textContent = formattedDate;
            selectedAppointmentTime.classList.remove('hidden');
        }
    }

    // Helper function to format time for display (HH:MM to 12-hour format)
    function formatTimeForDisplay(timeString) {
        const [hours, minutes] = timeString.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minutes} ${ampm}`;
    }

    // Next button click - Show patient form
    nextButton.addEventListener('click', function () {
        if (selectedDay && selectedMonth !== null && selectedYear && selectedTime) {
            // Hide calendar view and show form view
            calendarView.classList.add('hidden');
            patientFormView.classList.remove('hidden');

            // Set appointment date in the form
            // FIX: Use local date formatting instead of ISO to prevent timezone issues
            const year = selectedYear;
            const month = String(selectedMonth + 1).padStart(2, '0');
            const day = String(selectedDay).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            appointmentDateField.value = formattedDate;
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

    // Calculate age from date of birth
    function calculateAge() {
        const dobInput = document.getElementById('dateOfBirth');
        const ageInput = document.getElementById('age');

        if (dobInput.value) {
            const dob = new Date(dobInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            ageInput.value = age;
        }
    }

    // Function to preview uploaded image
    function previewImage(input) {
        const preview = document.getElementById('profilePreview');
        const removeBtn = document.getElementById('removeImageBtn');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                preview.appendChild(removeBtn);
                removeBtn.style.display = 'flex';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            resetProfilePreview();
        }
    }

    // Function to remove profile image
    function removeProfileImage() {
        const input = document.getElementById('profileImage');
        input.value = '';
        resetProfilePreview();
    }

    // Function to reset profile preview
    function resetProfilePreview() {
        const preview = document.getElementById('profilePreview');
        const removeBtn = document.getElementById('removeImageBtn');

        preview.innerHTML = `<i class="bx bx-user text-4xl text-gray-400"></i>`;
        preview.appendChild(removeBtn);
        removeBtn.style.display = 'none';
    }

    // Add event listener for remove button
    document.getElementById('removeImageBtn').addEventListener('click', removeProfileImage);

    // Make these functions available globally
    window.calculateAge = calculateAge;
    window.previewImage = previewImage;
    window.removeProfileImage = removeProfileImage;

    // Function to fetch available time slots for a selected date
    function fetchAvailableTimeSlots(date) {
        // FIX: Use local date formatting instead of ISO to prevent timezone issues
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        // Show loading state
        timeSlotsContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                <p class="mt-2 text-gray-600">Loading available times...</p>
            </div>
        `;

        // Add console log to debug the request
        console.log(`Fetching time slots for doctor ${doctorId} on ${formattedDate}`);

        // Fetch time slots from the server using query parameters
        fetch(`${baseUrl}/appointment/get-available-time-slots?doctor_id=${doctorId}&date=${formattedDate}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Add console log to debug the response
                console.log('Time slots response:', data);

                if (data.success && data.time_slots && data.time_slots.length > 0) {
                    // Populate time slots
                    timeSlotsContainer.innerHTML = '';
                    data.time_slots.forEach(slot => {
                        // Calculate end time (30 minutes after start time)
                        const startTime = slot.time;
                        const [hours, minutes] = startTime.split(':');
                        const hour = parseInt(hours);
                        const minute = parseInt(minutes);

                        // Create a new date object for end time calculation
                        const endDate = new Date();
                        endDate.setHours(hour);
                        endDate.setMinutes(minute + 30);

                        // Format the end time
                        const endTime = endDate.toTimeString().substring(0, 5);

                        // Format times for display
                        const displayStartTime = formatTimeForDisplay(startTime);
                        const displayEndTime = formatTimeForDisplay(endTime);

                        // Create time slot button with start and end time
                        const timeSlotButton = document.createElement('button');
                        timeSlotButton.className = 'time-slot w-full p-3 text-center rounded-lg border border-gray-200 hover:bg-primary-light hover:border-primary transition-colors';
                        timeSlotButton.setAttribute('data-time', slot.time);
                        timeSlotButton.innerHTML = `
                        <span class="font-medium">${displayStartTime} - ${displayEndTime}</span>
                        <span class="block text-xs text-gray-500 mt-1">30 min</span>
                    `;
                        timeSlotButton.addEventListener('click', handleTimeSlotSelection);
                        timeSlotsContainer.appendChild(timeSlotButton);
                    });
                } else {
                    // No time slots available
                    timeSlotsContainer.innerHTML = `
                    <div class="text-center py-4 text-gray-500">
                        <i class="bx bx-time-five text-2xl mb-2"></i>
                        <p>No available time slots for this date</p>
                    </div>
                `;
                }
            })
            .catch(error => {
                console.error('Error fetching time slots:', error);
                timeSlotsContainer.innerHTML = `
                <div class="text-center py-4 text-red-500">
                    <i class="bx bx-error-circle text-2xl mb-2"></i>
                    <p>Failed to load time slots</p>
                </div>
            `;
            });
    }

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

        // Get today's date for comparison
        const today = new Date();
        const todayDate = today.getDate();
        const todayMonth = today.getMonth();
        const todayYear = today.getFullYear();

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.className = 'text-center';

            const dayButton = document.createElement('button');
            dayButton.textContent = day;

            // Check if this date is in the past
            const isPast = (year < todayYear) ||
                (year === todayYear && month < todayMonth) ||
                (year === todayYear && month === todayMonth && day < todayDate);

            // Check if this day of the week is available for the doctor
            const date = new Date(year, month, day);
            const dayOfWeek = date.getDay(); // 0 = Sunday, 1 = Monday, etc.
            const isAvailable = availableDayNumbers.includes(dayOfWeek) && !isPast;

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

                    // Fetch available time slots for this date
                    fetchAvailableTimeSlots(selectedDate);
                    console.log("Debug info:");
                    console.log("Selected date:", selectedDate);
                    console.log("Day of week:", selectedDate.getDay());
                    console.log("Day name:", ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedDate.getDay()]);
                    console.log("Available day numbers:", availableDayNumbers);
                    console.log("Is day available:", availableDayNumbers.includes(selectedDate.getDay()));

                    // Reset time slot selections
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

            // Check if this day is available (has the 'available' class)
            const isAvailable = button.classList.contains('available');

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