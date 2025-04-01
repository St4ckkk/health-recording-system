<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
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

        /* Improved Timeline styles */
        .appointment-timeline {
            position: relative;
            padding: 0.5rem 0.3rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 48px;
            margin-bottom: 16px;
            transition: transform 0.2s ease;
        }

        .timeline-item:hover {
            transform: translateX(4px);
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            z-index: 2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Timeline connector line */
        .timeline-connector {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }

        /* Timeline colors */
        .timeline-current .timeline-icon {
            background-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        }

        .timeline-current .timeline-content {
            border-left: 3px solid #3B82F6;
            background-color: #EFF6FF;
        }

        .timeline-past .timeline-icon {
            background-color: #10B981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
        }

        .timeline-past .timeline-content {
            border-left: 3px solid #10B981;
            background-color: #ECFDF5;
        }

        .timeline-content {
            border-radius: 8px;
            padding: 16px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .timeline-content:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .timeline-date {
            display: inline-block;
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .timeline-current .timeline-date {
            background-color: rgba(59, 130, 246, 0.1);
            color: #1E40AF;
        }

        .timeline-past .timeline-date {
            background-color: rgba(16, 185, 129, 0.1);
            color: #065F46;
        }

        /* Equal height columns */
        .equal-height-columns {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .equal-height-content {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            max-height: none; /* Remove the max height to prevent scrolling */
        }

        /* Remove scrollbar styling since we don't need it anymore */
        .equal-height-content::-webkit-scrollbar {
            width: 0;
            display: none;
        }

        .equal-height-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .equal-height-content::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 0;
        }
        
        /* Add consistent padding to both cards */
        .card {
            padding: 1.5rem !important; /* Override any existing padding */
        }
        
        /* Ensure consistent spacing between elements */
        .patient-info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0; 
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 5px;
        }
        
        /* Add more space between timeline items */
        .timeline-item {
            position: relative;
            padding-left: 48px;
            margin-bottom: 24px; /* Increase margin between timeline items */
            transition: transform 0.2s ease;
        }

        .equal-height-content::-webkit-scrollbar {
            width: 4px;
        }

        .equal-height-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .equal-height-content::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* Patient card improvements */
        .patient-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .patient-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .patient-info-item:last-child {
            border-bottom: none;
        }

        .patient-info-label {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .patient-info-value {
            font-weight: regular;
            text-align: right;
            font-size: 0.875rem;
        }

        /* Modal improvements */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
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
                    <!-- Back button -->
                    <div class="mb-4">
                        <a href="<?= BASE_URL ?>/receptionist/dashboard"
                            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                            <button class="back-button">
                                <i class="bx bx-arrow-back mr-2"></i> Back to Dashboard
                            </button>
                        </a>
                    </div>

                    <div>
                        <div class="">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-3xl font-bold text-gray-900"><?= $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name . ' ' . $patient->suffix ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-2/5">
                            <div class="card bg-white shadow-sm rounded-lg w-full p-6 fade-in equal-height-columns">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Patient Information</h2>
                                <div class="flex flex-col items-center mb-6">
                                    <div class="patient-avatar">
                                    <?php if (!empty($patient->profile)): ?>
                                            <img src="<?= BASE_URL . '/' . $patient->profile ?>"
                                                class="w-full h-full object-cover rounded-full"
                                                >
                                        <?php else: ?>
                                            <i class="bx bx-user text-3xl"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Patient details -->
                                <div class="space-y-1 equal-height-content">
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Age:</span>
                                        <span class="patient-info-value"><?= isset($patient->age) ? $patient->age : '45' ?></span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Gender:</span>
                                        <span class="patient-info-value capitalize"><?= isset($patient->gender) ? $patient->gender : 'Male' ?></span>
                                    </div>
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Date of Birth:</span>
                                        <span class="patient-info-value"><?= isset($patient->date_of_birth) ? $patient->date_of_birth : '1979-03-15' ?></span>
                                    </div>        
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Contact:</span>
                                        <span class="patient-info-value"><?= isset($patient->contact_number) ? $patient->contact_number : '(123) 456-7890' ?></span>
                                    </div>
                                    
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Email:</span>
                                        <span class="patient-info-value break-words"><?= isset($patient->email) ? $patient->email : 'john.doe@example.com' ?></span>
                                    </div>
                                    
                                    <div class="patient-info-item">
                                        <span class="patient-info-label">Address:</span>
                                        <span class="patient-info-value"><?= isset($patient->address) ? $patient->address : '123 Main St, Tupi, South Cotabato' ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right column - Appointment History -->
                        <div class="w-full md:flex-1">
                            <div class="card bg-white shadow-sm rounded-lg w-full p-6 fade-in equal-height-columns">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-xl font-semibold text-gray-900">Appointment History</h2>
                                </div>
                                
                                <p class="text-sm text-gray-500 mb-4">Chronological view of patient's appointment history.</p>
                                <div class="appointment-timeline equal-height-content">
                                    <div class="timeline-connector"></div>
                                    
                                    <?php if (!empty($appointments)): ?>
                                        <?php foreach ($appointments as $index => $appointment): ?>
                                            <!-- Timeline Item -->
                                            <div class="timeline-item <?= $index === 0 ? 'timeline-current' : 'timeline-past' ?>">
                                                <div class="timeline-icon">
                                                    <i class="bx <?= $index === 0 ? 'bx-calendar-check' : 'bx-check-circle' ?>"></i>
                                                </div>
                                                <div class="timeline-content cursor-pointer hover:bg-<?= $index === 0 ? 'blue' : 'green' ?>-50 transition-colors" onclick="viewAppointmentDetails(<?= $appointment->id ?>)">
                                                    <span class="timeline-date">
                                                        <?= date('M d, Y', strtotime($appointment->appointment_date)) ?>
                                                    </span>
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <h4 class="font-medium capitalize text-<?= $index === 0 ? 'blue' : 'green' ?>-700">
                                                                <?= htmlspecialchars(str_replace('_', ' ', $appointment->appointment_type ?? 'Regular Checkup')) ?>
                                                            </h4>
                                                            <p class="text-sm text-gray-600">
                                                                <i class="bx bx-user-circle mr-1"></i> Dr. <?= htmlspecialchars($appointment->doctor_first_name . ' ' . $appointment->doctor_last_name) ?>
                                                            </p>
                                                        </div>
                                                        <span class="text-sm font-medium text-<?= $index === 0 ? 'blue' : 'green' ?>-600">
                                                            <i class="bx bx-time mr-1"></i> <?= date('g:i A', strtotime($appointment->appointment_time)) ?>
                                                        </span>
                                                    </div>
                                                    <?php if (!empty($appointment->notes)): ?>
                                                        <p class="text-sm text-gray-700 mt-2 bg-gray-50 p-2 rounded-md">
                                                            <i class="bx bx-note mr-1"></i> <?= htmlspecialchars($appointment->notes) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-8">
                                            <div class="text-gray-400 mb-3">
                                                <i class="bx bx-calendar-x text-5xl"></i>
                                            </div>
                                            <p class="text-gray-500">No appointment history found for this patient.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointmentDetailsModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Appointment Details</h3>
                    <button class="text-gray-400 hover:text-gray-500" onclick="closeAppointmentDetailsModal()">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>
                <div id="appointmentDetailsContent">
                   <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set base URL for JavaScript use
        window.BASE_URL = '<?= BASE_URL ?>';

        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', function () {
            // Add animation to timeline items
            const timelineItems = document.querySelectorAll('.timeline-item');
            timelineItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100 + (index * 150));
            });
        });

        // View appointment details
        function viewAppointmentDetails(appointmentId) {
            // Show the modal with fade-in effect
            const modal = document.getElementById('appointmentDetailsModal');
            modal.style.opacity = '0';
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                modal.style.transition = 'opacity 0.3s ease';
                modal.style.opacity = '1';
            }, 10);
            
            document.body.style.overflow = 'hidden';

            // Show loading state with animation
            document.getElementById('appointmentDetailsContent').innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                </div>
                <p class="text-center text-gray-500">Loading appointment details...</p>
            `;

            // Fetch appointment details via AJAX
            fetch(`${window.BASE_URL}/receptionist/getAppointmentDetails`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `appointmentId=${appointmentId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('appointmentDetailsContent').innerHTML = `
                        <div class="text-center py-6">
                            <div class="text-red-500 mb-2">
                                <i class="bx bx-error-circle text-4xl"></i>
                            </div>
                            <p class="text-red-500">${data.error}</p>
                        </div>
                    `;
                    return;
                }
                
                const appointment = data.appointment;
                const patient = data.patient;
                const doctor = data.doctor;
                
                // Format date and time
                const appointmentDate = new Date(appointment.appointment_date);
                const formattedDate = appointmentDate.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                const appointmentTime = new Date(`${appointment.appointment_date}T${appointment.appointment_time}`);
                const formattedTime = appointmentTime.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit' 
                });
                
                // Determine status class and icon
                let statusClass = 'bg-gray-100 text-gray-800';
                let statusIcon = 'bx-time';
                
                if (appointment.status === 'completed') {
                    statusClass = 'bg-green-100 text-green-800';
                    statusIcon = 'bx-check-circle';
                } else if (appointment.status === 'cancelled' || appointment.status === 'cancelled_by_clinic' || appointment.status === 'no-show') {
                    statusClass = 'bg-red-100 text-red-800';
                    statusIcon = 'bx-x-circle';
                } else if (appointment.status === 'confirmed') {
                    statusClass = 'bg-blue-100 text-blue-800';
                    statusIcon = 'bx-calendar-check';
                }
                
                // Populate modal with appointment details
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="border-b pb-4 mb-4">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                            <div>
                                <p class="text-sm text-gray-500">Appointment Date & Time</p>
                                <p class="text-lg font-medium">${formattedDate} at ${formattedTime}</p>
                            </div>
                            <span class="status-badge ${statusClass} self-start md:self-center">
                                <i class="bx ${statusIcon} mr-1"></i> ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1).replace('_', ' ')}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium flex items-center">
                                <i class="bx bx-user-circle mr-2 text-blue-500"></i>
                                Dr. ${doctor ? doctor.first_name + ' ' + doctor.last_name : 'Not Assigned'}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-500">Appointment Type</p>
                            <p class="font-medium flex items-center">
                                <i class="bx bx-calendar mr-2 text-blue-500"></i>
                                ${appointment.appointment_type || 'Regular Checkup'}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium flex items-center">
                                <i class="bx bx-map mr-2 text-blue-500"></i>
                                ${appointment.location || 'Main Clinic'}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-500">Tracking Number</p>
                            <p class="font-medium flex items-center">
                                <i class="bx bx-hash mr-2 text-blue-500"></i>
                                ${appointment.tracking_number || 'N/A'}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4 bg-blue-50 p-4 rounded-md">
                        <p class="text-sm text-gray-500 mb-1">Reason for Visit</p>
                        <p class="flex items-start">
                            <i class="bx bx-info-circle mr-2 text-blue-500 mt-1"></i>
                            <span>${appointment.reason || 'Not specified'}</span>
                        </p>
                    </div>
                    
                    <div class="mb-6 bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-500 mb-1">Notes</p>
                        <p class="flex items-start">
                            <i class="bx bx-note mr-2 text-gray-500 mt-1"></i>
                            <span>${appointment.notes || 'No notes available'}</span>
                        </p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex flex-col sm:flex-row justify-end gap-3">
                            <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors" onclick="closeAppointmentDetailsModal()">
                                Close
                            </button>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors">
                                <i class="bx bx-printer mr-2"></i>Print Details
                            </button>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="text-center py-6">
                        <div class="text-red-500 mb-2">
                            <i class="bx bx-error-circle text-4xl"></i>
                        </div>
                        <p class="text-red-500">Error loading appointment details. Please try again.</p>
                    </div>
                `;
                console.error('Error:', error);
            });
        }

        // Close appointment details modal
        function closeAppointmentDetailsModal() {
            const modal = document.getElementById('appointmentDetailsModal');
            modal.style.transition = 'opacity 0.3s ease';
            modal.style.opacity = '0';
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('appointmentDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAppointmentDetailsModal();
            }
        });
    </script>
    <script src="<?= BASE_URL ?>/js/receptionist/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/appointments.js"></script>
</body>

</html>