document.addEventListener('DOMContentLoaded', function () {
    // Form elements
    const trackingForm = document.getElementById('appointmentTrackingForm');
    const trackingInput = document.getElementById('trackingNumber');
    const resultsSection = document.getElementById('resultsSection');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const successMessageText = document.getElementById('successMessageText');
    const loadingIndicator = document.getElementById('loadingIndicator');

    // Action buttons
    const printButton = document.getElementById('printButton');
    const rescheduleButton = document.getElementById('rescheduleButton');
    const cancelButton = document.getElementById('cancelButton');
    const cancelTooltip = document.getElementById('cancelTooltip');

    // Modal elements
    const rescheduleModal = document.getElementById('rescheduleModal');
    const closeRescheduleModal = document.getElementById('closeRescheduleModal');
    const confirmReschedule = document.getElementById('confirmReschedule');
    const cancelConfirmModal = document.getElementById('cancelConfirmModal');
    const closeCancelModal = document.getElementById('closeCancelModal');
    const cancelCancellation = document.getElementById('cancelCancellation');
    const confirmCancellation = document.getElementById('confirmCancellation');

    // Calendar elements
    const prevMonth = document.getElementById('prevMonth');
    const nextMonth = document.getElementById('nextMonth');
    const currentMonth = document.getElementById('currentMonth');
    const timeSlotsContainer = document.getElementById('timeSlotsContainer');
    const selectedDateDisplay = document.getElementById('selectedDateDisplay');
    const timeSlots = document.getElementById('timeSlots');

    // Current appointment being viewed
    let currentAppointment = null;

    // Calendar variables
    let currentDate = new Date();
    let selectedCalendarDate = null;
    let selectedTimeSlot = null;

    // Generate available time slots for the next 30 days
    function generateAvailableTimeSlots() {
        const slots = {};
        const today = new Date();

        for (let i = 0; i < 31; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);

            // Skip weekends
            if (date.getDay() === 0 || date.getDay() === 6) continue;

            // Format date as YYYY-MM-DD
            const dateString = date.toISOString().split('T')[0];

            // Generate time slots
            const timeSlotOptions = ['9:00am', '9:30am', '10:00am', '10:30am', '11:00am', '11:30am',
                '1:00pm', '1:30pm', '2:00pm', '2:30pm', '3:00pm', '3:30pm', '4:00pm'];

            // Randomly select 3-5 time slots for each day
            const numSlots = Math.floor(Math.random() * 3) + 3;
            const selectedSlots = [];

            for (let j = 0; j < numSlots; j++) {
                const randomIndex = Math.floor(Math.random() * timeSlotOptions.length);
                selectedSlots.push(timeSlotOptions[randomIndex]);
                timeSlotOptions.splice(randomIndex, 1);
            }

            // Sort time slots
            selectedSlots.sort((a, b) => {
                const aHour = parseInt(a.split(':')[0]);
                const bHour = parseInt(b.split(':')[0]);
                const aIsPM = a.includes('pm');
                const bIsPM = b.includes('pm');

                if (aIsPM && !bIsPM) return 1;
                if (!aIsPM && bIsPM) return -1;
                return aHour - bHour;
            });

            slots[dateString] = selectedSlots;
        }

        return slots;
    }

    // Available time slots
    const availableTimeSlots = generateAvailableTimeSlots();

    // Function to show error message - moved outside the event listener
    function showError(message) {
        errorMessage.innerHTML = `<i class="bx bx-error-circle mr-2"></i> ${message}`;
        errorMessage.classList.add('visible');
    }

    // Handle form submission
    trackingForm.addEventListener('submit', function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Get the tracking number
        const trackingNumber = trackingInput.value.trim();

        if (!trackingNumber) {
            showError('Please enter a tracking number');
            return;
        }

        // Show loading indicator
        loadingIndicator.classList.add('visible');
        errorMessage.classList.remove('visible');
        successMessage.classList.remove('visible');
        resultsSection.classList.remove('visible');

        // Create form data
        const formData = new FormData();
        formData.append('tracking_number', trackingNumber);

        // Send AJAX request
        const baseUrl = document.querySelector('meta[name="base-url"]')?.content || '';

        // Log the request details for debugging
        console.log('Sending request to:', baseUrl + '/track-appointment');
        console.log('Tracking number:', trackingInput.value.trim());

        // Try using URLSearchParams instead of FormData
        const params = new URLSearchParams();
        params.append('tracking_number', trackingNumber);

        fetch(baseUrl + '/track-appointment', {
            method: 'POST',
            body: params,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            credentials: 'same-origin'
        })
            .then(response => {
                // Log response status for debugging
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                // First check if the response is ok (status in the range 200-299)
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Server error details:', text);

                        // Try to parse the error as JSON
                        try {
                            const errorJson = JSON.parse(text);
                            if (errorJson && errorJson.message) {
                                throw new Error(errorJson.message);
                            }
                        } catch (e) {
                            // If parsing fails, use a more descriptive error message
                            if (response.status === 500) {
                                throw new Error('Server error: The server encountered an internal error. Please check the server logs for more details.');
                            } else if (response.status === 404) {
                                throw new Error('Server error: The requested endpoint was not found.');
                            } else if (response.status === 403) {
                                throw new Error('Server error: You do not have permission to access this resource.');
                            } else {
                                throw new Error(`Server error: ${response.status} - ${text || 'Unknown error'}`);
                            }
                        }
                    });
                }

                // Then check if the response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    console.error('Non-JSON response:', contentType);
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        throw new Error('Server returned non-JSON response: ' + (text.substring(0, 100) + (text.length > 100 ? '...' : '')));
                    });
                }

                return response.json();
            })
            .then(data => {
                // Hide loading indicator
                loadingIndicator.classList.remove('visible');

                if (data.success) {
                    // Store current appointment
                    currentAppointment = data.appointment;

                    // Update UI with appointment details
                    updateAppointmentDetails(currentAppointment);

                    // Show results section
                    resultsSection.classList.add('visible');
                } else {
                    // Show error message
                    showError(data.message || 'No appointment found with this tracking number');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingIndicator.classList.remove('visible');

                // Show a more user-friendly error message
                const errorMessage = error.message || 'An error occurred while tracking your appointment. Please try again later.';
                showError(errorMessage);
            });
    });

    // Function to update appointment details in the UI
    function updateAppointmentDetails(appointment) {
        // Update appointment ID
        document.getElementById('appointmentId').textContent = appointment.tracking_number;

        // Update appointment date/time
        document.getElementById('appointmentDateTime').textContent = `${appointment.date} at ${appointment.time}`;

        // Update status badge
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.className = 'status-badge';

        switch (appointment.status) {
            case 'pending':
                statusBadge.classList.add('status-pending');
                statusBadge.innerHTML = '<i class="bx bx-time mr-1"></i> Pending';
                break;
            case 'scheduled':
                statusBadge.classList.add('status-scheduled');
                statusBadge.innerHTML = '<i class="bx bx-calendar mr-1"></i> Scheduled';
                break;
            case 'confirmed':
                statusBadge.classList.add('status-confirmed');
                statusBadge.innerHTML = '<i class="bx bx-check-circle mr-1"></i> Confirmed';
                break;
            case 'completed':
                statusBadge.classList.add('status-completed');
                statusBadge.innerHTML = '<i class="bx bx-check-double mr-1"></i> Completed';
                break;
            case 'cancelled':
                statusBadge.classList.add('status-cancelled');
                statusBadge.innerHTML = '<i class="bx bx-x-circle mr-1"></i> Cancelled';
                break;
            case 'no-show':
                statusBadge.classList.add('status-cancelled');
                statusBadge.innerHTML = '<i class="bx bx-time-five mr-1"></i> No Show';
                break;
            case 'rescheduled':
                statusBadge.classList.add('status-rescheduled');
                statusBadge.innerHTML = '<i class="bx bx-revision mr-1"></i> Rescheduled';
                break;
            default:
                statusBadge.classList.add('status-scheduled');
                statusBadge.innerHTML = '<i class="bx bx-calendar mr-1"></i> ' + appointment.status;
        }

        // Update doctor information
        document.getElementById('doctorName').textContent = appointment.doctor.name;
        document.getElementById('specialty').textContent = appointment.doctor.specialization;

        // Update appointment information
        document.getElementById('dateTime').textContent = `${appointment.date} at ${appointment.time}`;
        document.getElementById('timeOnly').textContent = appointment.time;
        document.getElementById('location').textContent = appointment.location || 'Main Clinic';
        document.getElementById('reason').textContent = appointment.reason;
        document.getElementById('scheduledDate').textContent = appointment.created_at;

        // Update special instructions if available
        if (appointment.special_instructions) {
            document.getElementById('specialInstructions').textContent = appointment.special_instructions;
        } else {
            document.getElementById('specialInstructions').textContent = 'No special instructions provided';
        }

        // Update timeline
        updateTimeline(appointment);

        // Update cancel button state
        updateCancelButton(appointment);

        // Update reschedule button state
        updateRescheduleButton(appointment);
    }

    // Function to update timeline based on appointment status
    function updateTimeline(appointment) {
        // Update scheduled date
        document.getElementById('scheduledDateTimeline').textContent = appointment.created_at;

        // Get timeline markers
        const confirmedMarker = document.getElementById('confirmedMarker');
        const checkInMarker = document.getElementById('checkInMarker');
        const completedMarker = document.getElementById('completedMarker');

        // Get timeline dates
        const confirmedDate = document.getElementById('confirmedDate');
        const checkInDate = document.getElementById('checkInDate');
        const completedDate = document.getElementById('completedDate');

        // Reset all markers
        confirmedMarker.className = 'timeline-marker pending';
        confirmedMarker.innerHTML = '';
        checkInMarker.className = 'timeline-marker pending';
        checkInMarker.innerHTML = '';
        completedMarker.className = 'timeline-marker pending';
        completedMarker.innerHTML = '';

        // Reset all dates
        confirmedDate.textContent = 'Pending';
        checkInDate.textContent = 'Pending';
        completedDate.textContent = 'Pending';

        // Update based on status
        switch (appointment.status) {
            case 'pending':
                // All steps are pending
                break;

            case 'scheduled':
                // Only scheduled, nothing else
                break;

            case 'confirmed':
                // Confirmed but not checked in
                confirmedMarker.className = 'timeline-marker completed';
                confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                confirmedDate.textContent = appointment.updated_at;
                checkInMarker.className = 'timeline-marker current';
                break;

            case 'check-in':
                // Patient has checked in but appointment not completed
                confirmedMarker.className = 'timeline-marker completed';
                confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                confirmedDate.textContent = appointment.confirmed_at || appointment.updated_at;

                checkInMarker.className = 'timeline-marker completed';
                checkInMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                checkInDate.textContent = appointment.checked_in_at || appointment.updated_at;

                completedMarker.className = 'timeline-marker current';
                break;

            case 'completed':
                // All steps completed
                confirmedMarker.className = 'timeline-marker completed';
                confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                confirmedDate.textContent = appointment.confirmed_at || appointment.updated_at;

                checkInMarker.className = 'timeline-marker completed';
                checkInMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                checkInDate.textContent = appointment.checked_in_at || appointment.updated_at;

                completedMarker.className = 'timeline-marker completed';
                completedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                completedDate.textContent = appointment.completed_at || appointment.updated_at;
                break;

            case 'cancelled':
                // If cancelled, show confirmation if it was confirmed before cancellation
                if (appointment.confirmed_at) {
                    confirmedMarker.className = 'timeline-marker completed';
                    confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                    confirmedDate.textContent = appointment.confirmed_at;
                }

                // If checked in before cancellation
                if (appointment.checked_in_at) {
                    checkInMarker.className = 'timeline-marker completed';
                    checkInMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                    checkInDate.textContent = appointment.checked_in_at;
                }

                // Show cancelled status in the timeline
                completedMarker.className = 'timeline-marker cancelled';
                completedMarker.innerHTML = '<i class="bx bx-x text-xs"></i>';
                completedDate.textContent = 'Cancelled';
                break;

            case 'no-show':
                // If no-show, it was confirmed but patient didn't show up
                confirmedMarker.className = 'timeline-marker completed';
                confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                confirmedDate.textContent = appointment.confirmed_at || appointment.updated_at;

                checkInMarker.className = 'timeline-marker no-show';
                checkInMarker.innerHTML = '<i class="bx bx-x text-xs"></i>';
                checkInDate.textContent = 'No Show';

                // Also mark completed as no-show
                completedMarker.className = 'timeline-marker cancelled';
                completedMarker.innerHTML = '<i class="bx bx-x text-xs"></i>';
                completedDate.textContent = 'No Show';
                break;

            case 'rescheduled':
                // If rescheduled, it was at least scheduled
                if (appointment.confirmed_at) {
                    confirmedMarker.className = 'timeline-marker completed';
                    confirmedMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                    confirmedDate.textContent = appointment.confirmed_at;
                }

                // If checked in before rescheduling
                if (appointment.checked_in_at) {
                    checkInMarker.className = 'timeline-marker completed';
                    checkInMarker.innerHTML = '<i class="bx bx-check text-xs"></i>';
                    checkInDate.textContent = appointment.checked_in_at;
                }

                // Show rescheduled status in the timeline
                completedMarker.className = 'timeline-marker rescheduled';
                completedMarker.innerHTML = '<i class="bx bx-revision text-xs"></i>';
                completedDate.textContent = 'Rescheduled';
                break;
        }
    }

    // Function to update cancel button state
    function updateCancelButton(appointment) {
        // Disable cancel button for completed, cancelled, or no-show appointments
        if (['completed', 'cancelled', 'no-show'].includes(appointment.status)) {
            cancelButton.disabled = true;
            cancelButton.classList.add('btn-disabled');
            cancelButton.classList.remove('btn-danger');
            cancelTooltip.textContent = `Cannot cancel a ${appointment.status} appointment`;
        } else {
            // Check if appointment is within cancellation window (e.g., 24 hours before)
            const appointmentDate = new Date(`${appointment.date} ${appointment.time}`);
            const now = new Date();
            const hoursUntilAppointment = (appointmentDate - now) / (1000 * 60 * 60);

            if (hoursUntilAppointment < 24) {
                cancelButton.disabled = true;
                cancelButton.classList.add('btn-disabled');
                cancelButton.classList.remove('btn-danger');
                cancelTooltip.textContent = 'Cannot cancel appointments less than 24 hours before scheduled time';
            } else {
                cancelButton.disabled = false;
                cancelButton.classList.remove('btn-disabled');
                cancelButton.classList.add('btn-danger');
                cancelTooltip.textContent = 'Cancel this appointment';
            }
        }
    }

    // Function to update reschedule button state
    function updateRescheduleButton(appointment) {
        // Disable reschedule button for completed, cancelled, or no-show appointments
        if (['completed', 'cancelled', 'no-show'].includes(appointment.status)) {
            rescheduleButton.disabled = true;
            rescheduleButton.classList.add('btn-disabled');
            rescheduleButton.classList.remove('btn-secondary');
        } else {
            // Check if appointment is within rescheduling window (e.g., 24 hours before)
            const appointmentDate = new Date(`${appointment.date} ${appointment.time}`);
            const now = new Date();
            const hoursUntilAppointment = (appointmentDate - now) / (1000 * 60 * 60);

            if (hoursUntilAppointment < 24) {
                rescheduleButton.disabled = true;
                rescheduleButton.classList.add('btn-disabled');
                rescheduleButton.classList.remove('btn-secondary');
            } else {
                rescheduleButton.disabled = false;
                rescheduleButton.classList.remove('btn-disabled');
                rescheduleButton.classList.add('btn-secondary');
            }
        }
    }

    // Handle print button click
    printButton.addEventListener('click', function () {
        window.print();
    });

    // Function to update the calendar
    function updateCalendar() {
        // Update month display
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonth.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        // Get first day of month and number of days in month
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay(); // 0 = Sunday, 1 = Monday, etc.

        // Create calendar grid
        const calendarGrid = document.querySelector('.calendar-grid');

        // Clear existing days (after the headers)
        const dayHeaders = document.querySelectorAll('.calendar-day-header');
        const children = Array.from(calendarGrid.children);
        children.forEach((child, index) => {
            if (index >= dayHeaders.length) {
                calendarGrid.removeChild(child);
            }
        });

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < startingDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendarGrid.appendChild(emptyDay);
        }

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            const dateString = date.toISOString().split('T')[0];

            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;

            // Check if this day has available slots
            const hasSlots = availableTimeSlots[dateString] && availableTimeSlots[dateString].length > 0;

            // Check if this is today
            const isToday = date.toDateString() === new Date().toDateString();

            // Check if this is the selected date
            const isSelected = selectedCalendarDate &&
                date.getDate() === selectedCalendarDate.getDate() &&
                date.getMonth() === selectedCalendarDate.getMonth() &&
                date.getFullYear() === selectedCalendarDate.getFullYear();

            // Check if this date is in the past
            const isPast = date < new Date().setHours(0, 0, 0, 0);

            // Add appropriate classes
            if (isToday) dayElement.classList.add('today');
            if (isSelected) dayElement.classList.add('selected');
            if (hasSlots && !isPast) dayElement.classList.add('has-slots');
            if (isPast) dayElement.classList.add('disabled');

            // Add click event for days with available slots that are not in the past
            if (hasSlots && !isPast) {
                dayElement.addEventListener('click', function () {
                    // Remove selected class from all days
                    document.querySelectorAll('.calendar-day.selected').forEach(el => {
                        el.classList.remove('selected');
                    });

                    // Add selected class to clicked day
                    dayElement.classList.add('selected');

                    // Store selected date
                    selectedCalendarDate = new Date(date);

                    // Update selected date display
                    const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedCalendarDate.getDay()];
                    const monthName = monthNames[selectedCalendarDate.getMonth()];
                    const dayOfMonth = selectedCalendarDate.getDate();

                    selectedDateDisplay.textContent = `${dayOfWeek}, ${monthName} ${dayOfMonth}`;

                    // Show time slots for selected date
                    showTimeSlots(dateString);
                });
            } else {
                dayElement.classList.add('disabled');
            }

            calendarGrid.appendChild(dayElement);
        }

        // Add empty cells for days after the last day of the month to complete the grid
        const totalCells = startingDay + daysInMonth;
        const remainingCells = 7 - (totalCells % 7);
        if (remainingCells < 7) {
            for (let i = 0; i < remainingCells; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day empty';
                calendarGrid.appendChild(emptyDay);
            }
        }
    }

    // Function to show time slots for selected date
    function showTimeSlots(dateString) {
        // Clear time slots
        timeSlots.innerHTML = '';

        // Get available slots for selected date
        const slots = availableTimeSlots[dateString] || [];

        if (slots.length > 0) {
            // Create time slot elements
            slots.forEach(slot => {
                const slotElement = document.createElement('div');
                slotElement.classList.add('time-slot');
                slotElement.textContent = slot;

                slotElement.addEventListener('click', function () {
                    // Remove selected class from all time slots
                    document.querySelectorAll('.time-slot.selected').forEach(el => {
                        el.classList.remove('selected');
                    });

                    // Add selected class to clicked time slot
                    slotElement.classList.add('selected');

                    // Store selected time slot
                    selectedTimeSlot = slot;

                    // Enable confirm button
                    confirmReschedule.disabled = false;
                });

                // Check if this is the selected time slot
                if (selectedTimeSlot === slot) {
                    slotElement.classList.add('selected');
                }

                timeSlots.appendChild(slotElement);
            });
        } else {
            // No available slots for this date
            timeSlots.innerHTML = '<p class="text-center text-gray-500 py-4">No available time slots for this date.</p>';
        }
    }

    // Function to open reschedule modal
    function openRescheduleModal() {
        // Initialize calendar date to current month
        currentDate = new Date();

        // Set default selected date to first available date
        const today = new Date();
        let foundAvailableDate = false;

        // Look for the first available date in the next 30 days
        for (let i = 0; i < 30; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            const dateString = date.toISOString().split('T')[0];

            if (availableTimeSlots[dateString] && availableTimeSlots[dateString].length > 0) {
                selectedCalendarDate = date;
                selectedTimeSlot = availableTimeSlots[dateString][0];
                foundAvailableDate = true;
                break;
            }
        }

        // If no available date found, use today
        if (!foundAvailableDate) {
            selectedCalendarDate = today;
            selectedTimeSlot = null;
        }

        // Show reschedule modal
        rescheduleModal.classList.add('visible');

        // Update calendar
        updateCalendar();

        // Update selected date display
        if (selectedCalendarDate) {
            const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedCalendarDate.getDay()];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const monthName = monthNames[selectedCalendarDate.getMonth()];
            const dayOfMonth = selectedCalendarDate.getDate();

            selectedDateDisplay.textContent = `${dayOfWeek}, ${monthName} ${dayOfMonth}`;

            // Show time slots for selected date
            const dateString = selectedCalendarDate.toISOString().split('T')[0];
            showTimeSlots(dateString);
        }
    }

    // Update the rescheduleButton event listener to use the new function
    rescheduleButton.addEventListener('click', openRescheduleModal);

    // Handle month navigation
    prevMonth.addEventListener('click', function () {
        // Don't allow navigating to past months
        const prevMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
        const today = new Date();
        if (prevMonthDate.getMonth() < today.getMonth() && prevMonthDate.getFullYear() <= today.getFullYear()) {
            return;
        }

        currentDate = prevMonthDate;
        updateCalendar();
    });

    nextMonth.addEventListener('click', function () {
        // Limit to 3 months in the future
        const nextMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
        const threeMonthsLater = new Date();
        threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);

        if (nextMonthDate > threeMonthsLater) {
            return;
        }

        currentDate = nextMonthDate;
        updateCalendar();
    });

    // Handle cancel button click
    cancelButton.addEventListener('click', function () {
        if (!cancelButton.disabled) {
            cancelConfirmModal.classList.add('visible');
        }
    });

    // Close reschedule modal
    closeRescheduleModal.addEventListener('click', function () {
        rescheduleModal.classList.remove('visible');
    });

    // Close cancel confirmation modal
    closeCancelModal.addEventListener('click', function () {
        cancelConfirmModal.classList.remove('visible');
    });

    cancelCancellation.addEventListener('click', function () {
        cancelConfirmModal.classList.remove('visible');
    });

    // Confirm reschedule button (from the date/time selection modal)
    confirmReschedule.addEventListener('click', function () {
        if (!selectedCalendarDate || !selectedTimeSlot) {
            return;
        }

        // Format the selected date for display
        const formattedDate = formatDate(selectedCalendarDate);

        // Update the confirmation modal with the new date and time
        document.getElementById('newAppointmentDate').textContent = formattedDate;
        document.getElementById('newAppointmentTime').textContent = selectedTimeSlot;

        // Hide the reschedule modal and show the confirmation modal
        rescheduleModal.classList.remove('visible');
        document.getElementById('rescheduleConfirmModal').classList.add('visible');
    });

    // Add event listeners for the reschedule confirmation modal
    const rescheduleConfirmModal = document.getElementById('rescheduleConfirmModal');
    const closeRescheduleConfirmModal = document.getElementById('closeRescheduleConfirmModal');
    const cancelRescheduleConfirmation = document.getElementById('cancelRescheduleConfirmation');
    const confirmRescheduleConfirmation = document.getElementById('confirmRescheduleConfirmation');

    // Close reschedule confirmation modal
    closeRescheduleConfirmModal.addEventListener('click', function () {
        rescheduleConfirmModal.classList.remove('visible');
    });

    // Cancel reschedule confirmation
    cancelRescheduleConfirmation.addEventListener('click', function () {
        rescheduleConfirmModal.classList.remove('visible');
    });

    // Confirm reschedule confirmation (final step)
    confirmRescheduleConfirmation.addEventListener('click', function () {
        // Format the selected date
        const dateString = selectedCalendarDate.toISOString().split('T')[0];
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const formattedDate = `${monthNames[selectedCalendarDate.getMonth()]} ${selectedCalendarDate.getDate()}, ${selectedCalendarDate.getFullYear()}`;

        // Create form data for the reschedule request
        const formData = new FormData();
        formData.append('tracking_number', currentAppointment.tracking_number);
        formData.append('new_date', dateString);
        formData.append('new_time', selectedTimeSlot);

        // Show loading indicator
        loadingIndicator.classList.add('visible');

        // Hide confirmation modal
        rescheduleConfirmModal.classList.remove('visible');

        // Send AJAX request to reschedule
        fetch('/reschedule-appointment', {
            method: 'POST',
            body: formData,
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
                // Hide loading indicator
                loadingIndicator.classList.remove('visible');

                if (data.success) {
                    // Show success message
                    successMessageText.textContent = `Your appointment has been rescheduled to ${formattedDate} at ${selectedTimeSlot}`;
                    successMessage.classList.add('visible');

                    // Update appointment if data is returned
                    if (data.appointment) {
                        currentAppointment = data.appointment;
                        updateAppointmentDetails(currentAppointment);
                    }
                } else {
                    // Show error message
                    showError(data.message || 'Failed to reschedule appointment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingIndicator.classList.remove('visible');
                showError('An error occurred while rescheduling your appointment. Please try again later.');
            });
    });

    // Helper function to format date
    function formatDate(date) {
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
        return `${dayOfWeek}, ${monthNames[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
    }

    // Handle the "Other reason" selection in the cancellation reason dropdown
    const cancellationReason = document.getElementById('cancellationReason');
    const otherReasonContainer = document.getElementById('otherReasonContainer');
    const otherReason = document.getElementById('otherReason');
    const cancellationReasonError = document.getElementById('cancellationReasonError');

    cancellationReason.addEventListener('change', function () {
        if (this.value === 'other') {
            otherReasonContainer.classList.remove('hidden');
        } else {
            otherReasonContainer.classList.add('hidden');
        }
        // Hide error message when selection changes
        cancellationReasonError.classList.add('hidden');
    });

    // Update the confirm cancellation event listener
    confirmCancellation.addEventListener('click', function () {
        // Validate that a reason is selected
        if (!cancellationReason.value) {
            cancellationReasonError.classList.remove('hidden');
            return;
        }

        // If "other" is selected, validate that the other reason field is filled
        if (cancellationReason.value === 'other' && !otherReason.value.trim()) {
            cancellationReasonError.textContent = 'Please specify your reason for cancellation';
            cancellationReasonError.classList.remove('hidden');
            return;
        }

        // Create form data for the cancellation request
        const formData = new FormData();
        formData.append('tracking_number', currentAppointment.tracking_number);
        formData.append('reason', cancellationReason.value);

        // If "other" is selected, include the specified reason
        if (cancellationReason.value === 'other') {
            formData.append('other_reason', otherReason.value.trim());
        }

        // Show loading indicator
        loadingIndicator.classList.add('visible');

        // Hide modal
        cancelConfirmModal.classList.remove('visible');

        // Send AJAX request to cancel
        fetch('/cancel-appointment', {
            method: 'POST',
            body: formData,
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
                // Hide loading indicator
                loadingIndicator.classList.remove('visible');

                if (data.success) {
                    // Show success message
                    successMessageText.textContent = 'Your appointment has been cancelled successfully';
                    successMessage.classList.add('visible');

                    // Update appointment if data is returned
                    if (data.appointment) {
                        currentAppointment = data.appointment;
                        updateAppointmentDetails(currentAppointment);
                    } else {
                        // Hide results if no updated appointment data
                        resultsSection.classList.remove('visible');
                    }
                } else {
                    // Show error message
                    showError(data.message || 'Failed to cancel appointment. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingIndicator.classList.remove('visible');
                showError('An error occurred while cancelling your appointment. Please try again later.');
            });
    });

    // Reset the cancellation form when opening the modal
    cancelButton.addEventListener('click', function () {
        if (!cancelButton.disabled) {
            // Reset the form
            cancellationReason.value = '';
            otherReason.value = '';
            otherReasonContainer.classList.add('hidden');
            cancellationReasonError.classList.add('hidden');

            // Show the modal
            cancelConfirmModal.classList.add('visible');
        }
    });
});