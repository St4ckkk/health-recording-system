<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/app-tracking.css">
    <style>
        /* Loading indicator */
        .loading-indicator {
            display: none;
            text-align: center;
            padding: 2rem 0;
        }

        .loading-indicator.visible {
            display: block;
        }

        .search-animation {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary-light);
            position: relative;
            animation: pulse 2s infinite;
        }

        .search-animation i {
            font-size: 2.5rem;
            color: var(--primary);
            animation: hover 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(var(--primary-rgb), 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(var(--primary-rgb), 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(var(--primary-rgb), 0);
            }
        }

        @keyframes hover {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        /* New status styles for pending confirmation */
        .timeline-marker.pending-confirmation {
            background-color: #fef3c7;
            border-color: #f59e0b;
        }

        .timeline-marker.pending-confirmation i {
            color: #f59e0b;
        }

        .status-badge.status-pending-confirmation {
            background-color: #fef3c7;
            color: #d97706;
        }
    </style>

<body>
    <div class="p-5">
        <div class="w-64 h-16 mb-8">
            <div class="logo-container text-white p-4 inline-flex items-center">
                <div class="mr-2">
                    <div class="logo">
                        <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
                    </div>
                </div>
                <span class="text-2xl font-bold">Test Clinic</span>
            </div>
        </div>

        <div class="split-layout">
            <!-- Hero Section (Left Side) -->
            <div class="hero-section">
                <img src="<?= BASE_URL ?>/images/image-header.jpg" class="hero-image" alt="Medical Appointment">
                <div class="hero-content">
                    <h1 class="hero-title">Track Your Appointment</h1>
                    <p class="hero-subtitle">Enter your appointment tracking number to view your appointment details and
                        status</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-3">
                            <i class="bx bx-info-circle text-danger text-xl"></i>
                        </div>
                        <p class="text-sm opacity-80">Your tracking number can be found in your confirmation email or
                            SMS</p>
                    </div>
                </div>
                <i class="bx bx-calendar-check hero-icon"></i>
            </div>

            <!-- Content Section (Right Side) -->
            <div class="content-section">
                <!-- Tracking Form -->
                <div class="tracking-form">
                    <h2 class="tracking-form-title">Enter Your Appointment Tracking Number</h2>
                    <form id="appointmentTrackingForm">
                        <div class="tracking-input-container mb-4">
                            <i class="bx bx-search tracking-input-icon text-xl"></i>
                            <input type="text" id="trackingNumber" class="search-input tracking-input"
                                placeholder="Enter your appointment tracking number (e.g., APT-19990101-XXXXXX)"
                                required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-primary">
                                <i class="bx bx-calendar-search mr-2"></i> Track Appointment
                            </button>
                        </div>
                    </form>
                    <div id="errorMessage" class="error-message">
                        <i class="bx bx-error-circle mr-2"></i> We couldn't find an appointment with that tracking
                        number. Please check and try again.
                    </div>
                    <div id="successMessage" class="success-message">
                        <i class="bx bx-check-circle mr-2"></i> <span id="successMessageText"></span>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="loading-indicator">
                    <div class="search-animation">
                        <i class="bx bx-search-alt"></i>
                    </div>
                    <p class="mt-4 text-gray-600">Looking up your appointment...</p>
                </div>

                <!-- Results Section (initially hidden) -->
                <div id="resultsSection" class="results-section">
                    <!-- Appointment Status Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Appointment Details</h2>
                                <p class="text-sm text-gray-500">Appointment Tracking #: <span
                                        id="appointmentId">APP-12345</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-1">Scheduled for: <span
                                        id="appointmentDateTime">May 15, 2023 at 10:00 AM</span></p>
                            </div>
                            <span class="status-badge status-confirmed" id="statusBadge">
                                <i class="bx bx-check-circle mr-1"></i> Confirmed
                            </span>
                        </div>

                        <!-- Doctor Information -->
                        <div class="appointment-card-body">
                            <div class="doctor-card">
                                <div class="doctor-avatar avatar">
                                    <i class="bx bx-user text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800" id="doctorName"></h3>
                                    <p class="text-gray-600 text-sm" id="specialty"></p>
                                </div>
                            </div>

                            <!-- Appointment Information -->
                            <div class="info-grid">
                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-calendar"></i>
                                    </div>
                                    <div class="info-card-label">Date & Time</div>
                                    <div class="info-card-value" id="dateTime"></div>
                                    <div class="text-sm font-bold text-primary mt-1" id="timeOnly"></div>
                                    <div class="text-xs text-gray-600 mt-1" id="appointmentDuration">30 min appointment
                                    </div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-map"></i>
                                    </div>
                                    <div class="info-card-label">Location</div>
                                    <div class="info-card-value" id="location"></div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-clipboard"></i>
                                    </div>
                                    <div class="info-card-label"></div>
                                    <div class="info-card-value" id="reason"></div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-time"></i>
                                    </div>
                                    <div class="info-card-label"></div>
                                    <div class="info-card-value" id="scheduledDate" </div>
                                    </div>
                                </div>

                                <!-- Timeline -->
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Status</h3>
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker completed">
                                                <i class="bx bx-check text-xs"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4 class="text-sm font-medium text-gray-800">Appointment Scheduled</h4>
                                                <p class="text-xs text-gray-500" id="scheduledDateTimeline">May 10, 2023
                                                </p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-marker completed" id="confirmedMarker">
                                                <i class="bx bx-check text-xs"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4 class="text-sm font-medium text-gray-800">Appointment Confirmed</h4>
                                                <p class="text-xs text-gray-500" id="confirmedDate">May 12, 2023</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-marker current" id="checkInMarker"></div>
                                            <div class="timeline-content">
                                                <h4 class="text-sm font-medium text-gray-800">Check-in</h4>
                                                <p class="text-xs text-gray-500" id="checkInDate">Pending</p>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-marker pending" id="completedMarker"></div>
                                            <div class="timeline-content">
                                                <h4 class="text-sm font-medium text-gray-800" id="completedLabel">
                                                    Appointment Completed</h4>
                                                <p class="text-xs text-gray-500" id="completedDate">Pending</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="appointment-card-footer">
                                <div class="flex gap-2">
                                    <button class="btn-secondary" id="rescheduleButton">
                                        <i class="bx bx-calendar-edit mr-2"></i> Reschedule
                                    </button>
                                    <div class="tooltip">
                                        <button class="btn-danger" id="cancelButton">
                                            <i class="bx bx-x-circle mr-2"></i> Cancel
                                        </button>
                                        <span class="tooltip-text" id="cancelTooltip">You can only cancel within 30
                                            minutes
                                            of scheduling</span>
                                    </div>
                                </div>
                                <button class="print-btn" id="printButton">
                                    <i class="bx bx-printer"></i> Print Details
                                </button>
                            </div>
                        </div>

                        <!-- Preparation Instructions -->
                        <div class="preparation-list">
                            <h3 class="preparation-list-title">Preparation Instructions</h3>
                            <div class="preparation-item">
                                <div class="preparation-item-icon">
                                    <i class="bx bx-id-card text-xs"></i>
                                </div>
                                <div class="preparation-item-text">Bring your insurance card and photo ID</div>
                            </div>
                            <div class="preparation-item">
                                <div class="preparation-item-icon">
                                    <i class="bx bx-time text-xs"></i>
                                </div>
                                <div class="preparation-item-text">Arrive 15 minutes before your appointment time</div>
                            </div>
                            <div class="preparation-item">
                                <div class="preparation-item-icon">
                                    <i class="bx bx-capsule text-xs"></i>
                                </div>
                                <div class="preparation-item-text">Bring a list of all current medications</div>
                            </div>
                            <div class="preparation-item">
                                <div class="preparation-item-icon">
                                    <i class="bx bx-food-menu text-xs"></i>
                                </div>
                                <div class="preparation-item-text" id="specialInstructions">Fast for 8 hours before your
                                    appointment (water is allowed)</div>
                            </div>
                            <div class="preparation-item">
                                <div class="preparation-item-icon">
                                    <i class="bx bx-closet text-xs"></i>
                                </div>
                                <div class="preparation-item-text">Wear comfortable clothing</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reschedule Modal -->
        <div class="modal-overlay" id="rescheduleModal">
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">Select a Date & Time</h3>
                    <button class="modal-close" id="closeRescheduleModal">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="calendar-date-picker">
                        <!-- Calendar Section -->
                        <div class="calendar-section">
                            <div class="calendar-month-nav">
                                <button class="calendar-nav-btn" id="prevMonth">
                                    <i class="bx bx-chevron-left"></i>
                                </button>
                                <div class="calendar-month" id="currentMonth">March 2025</div>
                                <button class="calendar-nav-btn" id="nextMonth">
                                    <i class="bx bx-chevron-right"></i>
                                </button>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day-header">SUN</div>
                                <div class="calendar-day-header">MON</div>
                                <div class="calendar-day-header">TUE</div>
                                <div class="calendar-day-header">WED</div>
                                <div class="calendar-day-header">THU</div>
                                <div class="calendar-day-header">FRI</div>
                                <div class="calendar-day-header">SAT</div>
                                <!-- Calendar days will be generated by JavaScript -->
                                <div id="calendarDays" class="calendar-grid-days"></div>
                            </div>
                        </div>

                        <!-- Time Slots Section -->
                        <div class="time-section">
                            <div class="time-slots-container" id="timeSlotsContainer">
                                <h4 class="time-slots-title" id="selectedDateDisplay">Tuesday, March 18</h4>
                                <div class="time-slots-list" id="timeSlots">
                                    <!-- Time slots will be generated by JavaScript -->
                                    <div class="time-slot">2:00pm</div>
                                    <div class="time-slot">2:30pm</div>
                                    <div class="time-slot">3:00pm</div>
                                    <div class="time-slot">3:30pm</div>
                                    <div class="time-slot selected">4:00pm</div>
                                </div>
                            </div>
                            <button class="btn-next" id="confirmReschedule">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reschedule Confirmation Modal -->
        <div class="modal-overlay confirmation-modal" id="rescheduleConfirmModal">
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">Confirm Reschedule</h3>
                    <button class="modal-close" id="closeRescheduleConfirmModal">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="confirmation-icon warning">
                        <i class="bx bx-calendar-exclamation"></i>
                    </div>
                    <h4 class="confirmation-title">Are you sure you want to reschedule?</h4>
                    <p class="confirmation-message">You are about to reschedule your appointment to:</p>
                    <div class="p-4 my-3 bg-gray-50 rounded-lg text-center">
                        <p class="font-bold text-lg text-primary" id="newAppointmentDate">Tuesday, March 18, 2025</p>
                        <p class="font-medium text-gray-700" id="newAppointmentTime">4:00 PM</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Your current appointment will be cancelled and a new
                        appointment
                        will be created.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="cancelRescheduleConfirmation">No, Keep Current
                        Appointment</button>
                    <button class="btn-primary" id="confirmRescheduleConfirmation">Yes, Reschedule Appointment</button>
                </div>
            </div>
        </div>

        <!-- Cancel Confirmation Modal -->
        <div class="modal-overlay confirmation-modal" id="cancelConfirmModal">
            <div class="modal">
                <div class="modal-header">
                    <h3 class="modal-title">Cancel Appointment</h3>
                    <button class="modal-close" id="closeCancelModal">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="confirmation-icon danger">
                        <i class="bx bx-error-circle"></i>
                    </div>
                    <h4 class="confirmation-title">Are you sure you want to cancel?</h4>
                    <p class="confirmation-message">This action cannot be undone. Your appointment slot will be released
                        and
                        made available to other patients.</p>

                    <div class="mt-4">
                        <label for="cancellationReason" class="block text-sm font-medium text-gray-700 mb-2">
                            Please provide a reason for cancellation:
                        </label>
                        <select id="cancellationReason" class="search-input w-full">
                            <option value="">-- Select a reason --</option>
                            <option value="schedule_conflict">Schedule conflict</option>
                            <option value="feeling_better">Feeling better, no longer need appointment</option>
                            <option value="found_another_provider">Found another healthcare provider</option>
                            <option value="transportation_issues">Transportation issues</option>
                            <option value="financial_reasons">Financial reasons</option>
                            <option value="other">Other reason</option>
                        </select>
                        <div id="otherReasonContainer" class="mt-3 hidden">
                            <label for="otherReason" class="block text-sm font-medium text-gray-700 mb-2">
                                Please specify:
                            </label>
                            <textarea id="otherReason" class="search-input w-full" rows="3"
                                placeholder="Please provide details..."></textarea>
                        </div>
                        <p id="cancellationReasonError" class="text-red-600 text-sm mt-1 hidden">Please select a reason
                            for
                            cancellation</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" id="cancelCancellation">No, Keep Appointment</button>
                    <button class="btn-danger" id="confirmCancellation">Yes, Cancel Appointment</button>
                </div>
            </div>
        </div>



        <script src="<?= BASE_URL ?>/js/app-tracking.js"></script>
</body>

</html>