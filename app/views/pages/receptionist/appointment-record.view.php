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

        /* Timeline styles - cleaned up and simplified */
        .timeline-item {
            position: relative;
            padding-left: 40px;
            margin-bottom: 4px;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 16px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            z-index: 1;
        }

        /* Timeline connector line */
        .timeline-item:before {
            content: "";
            position: absolute;
            left: 12px;
            top: 40px; /* Adjusted to start below the icon */
            bottom: -4px;
            width: 2px;
            background-color: #e5e7eb;
        }

        .timeline-item:last-child:before {
            display: none;
        }

        /* Timeline colors */
        .timeline-blue {
            border-left: 2px solid #3B82F6;
        }

        .timeline-blue .timeline-icon {
            background-color: #3B82F6;
        }

        .timeline-blue .timeline-content {
            background-color: #EBF5FF;
        }

        .timeline-green {
            border-left: 2px solid #10B981;
        }

        .timeline-green .timeline-icon {
            background-color: #10B981;
        }

        .timeline-green .timeline-content {
            background-color: #ECFDF5;
        }

        .timeline-content {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        /* Equal height columns */
        .equal-height-columns {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .equal-height-content {
            flex: 1;
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
                   
                        <div class="md:w-50">
                            <div class="card bg-white shadow-sm rounded-lg w-full p-6 fade-in equal-height-columns">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Patient Information</h2>
                                <div class="flex flex-col items-center mb-6">
                                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center text-3xl font-semibold text-blue-500 mb-2">
                                        <?= substr($patient->first_name ?? 'J', 0, 1) ?>
                                    </div>
                                </div>
                                <!-- Patient details -->
                                <div class="space-y-3 equal-height-content">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Age:</span>
                                        <span class=""><?= isset($patient->age) ? $patient->age : '45' ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Gender:</span>
                                        <span class=""><?= isset($patient->gender) ? $patient->gender : 'Male' ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Date of Birth:</span>
                                        <span class=""><?= isset($patient->date_of_birth) ? $patient->date_of_birth : '1979-03-15' ?></span>
                                    </div>        
                                    <div class="border-t pt-3 mt-3">
                                        <span class="text-gray-500">Contact:</span>
                                        <div class=" mt-1"><?= isset($patient->contact_number) ? $patient->contact_number : '(123) 456-7890' ?></div>
                                    </div>
                                    
                                    <div>
                                        <span class="text-gray-500">Email:</span>
                                        <div class=" mt-1 break-words"><?= isset($patient->email) ? $patient->email : 'john.doe@example.com' ?></div>
                                    </div>
                                    
                                    <div>
                                        <span class="text-gray-500">Address:</span>
                                        <div class="mt-1"><?= isset($patient->address) ? $patient->address : '123 Main St, Tupi, South Cotabato' ?></div>
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
                                    <?php if (!empty($appointments)): ?>
                                        <?php foreach ($appointments as $index => $appointment): ?>
                                            <!-- Timeline Item -->
                                            <div class="timeline-item">
                                                <div class="timeline-icon">
                                                    <i class="bx <?= $index === 0 ? 'bx-calendar' : 'bx-check-circle' ?>"></i>
                                                </div>
                                                <div class="timeline-content p-4 cursor-pointer hover:bg-<?= $index === 0 ? 'blue' : 'green' ?>-50 transition-colors bg-<?= $index === 0 ? 'blue' : 'green' ?>-50 rounded-lg" onclick="viewAppointmentDetails(<?= $appointment->id ?>)">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <h4 class="font-medium text-<?= $index === 0 ? 'blue' : 'green' ?>-700">
                                                                <?= htmlspecialchars($appointment->appointment_type ?? 'Regular Checkup') ?>
                                                            </h4>
                                                            <p class="text-sm text-gray-600">
                                                                Doctor: Dr. <?= htmlspecialchars($appointment->doctor_first_name . ' ' . $appointment->doctor_last_name) ?>
                                                            </p>
                                                        </div>
                                                        <span class="text-sm text-gray-500">
                                                            <?= date('Y-m-d', strtotime($appointment->appointment_date)) ?> • 
                                                            <?= date('g:i A', strtotime($appointment->appointment_time)) ?>
                                                        </span>
                                                    </div>
                                                    <?php if (!empty($appointment->notes)): ?>
                                                        <p class="text-sm text-gray-700"><?= htmlspecialchars($appointment->notes) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-8">
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
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Appointment Details</h3>
                    <button class="text-gray-400 hover:text-gray-500" onclick="closeAppointmentDetailsModal()">
                        <i class="bx bx-x text-2xl"></i>
                    </button>
                </div>
                <div id="appointmentDetailsContent">
                   
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set base URL for JavaScript use
        window.BASE_URL = '<?= BASE_URL ?>';

        // Initialize when document is ready
        document.addEventListener('DOMContentLoaded', function () {
            // Set the first timeline icon to blue
            const firstIcon = document.querySelector('.timeline-item:first-child .timeline-icon');
            if (firstIcon) {
                firstIcon.style.backgroundColor = '#3B82F6'; // Blue
            }
            
            // Set all other timeline icons to green
            const otherIcons = document.querySelectorAll('.timeline-item:not(:first-child) .timeline-icon');
            otherIcons.forEach(icon => {
                icon.style.backgroundColor = '#10B981'; // Green
            });
        });

        // View appointment details
        function viewAppointmentDetails(appointmentId) {
            // Show the modal
            const modal = document.getElementById('appointmentDetailsModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Show loading state
            document.getElementById('appointmentDetailsContent').innerHTML = `
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
                        <p class="text-center text-red-500">${data.error}</p>
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
                
                // Determine status class
                let statusClass = 'bg-gray-100 text-gray-800';
                if (appointment.status === 'completed') {
                    statusClass = 'bg-green-100 text-green-800';
                } else if (appointment.status === 'cancelled' || appointment.status === 'cancelled_by_clinic' || appointment.status === 'no-show') {
                    statusClass = 'bg-red-100 text-red-800';
                } else if (appointment.status === 'confirmed') {
                    statusClass = 'bg-blue-100 text-blue-800';
                }
                
                // Populate modal with appointment details
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Appointment Date & Time</p>
                                <p class="text-lg font-medium">${formattedDate} at ${formattedTime}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium ${statusClass}">
                                <i class="bx bx-check-circle mr-1"></i> ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1).replace('_', ' ')}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium">Dr. ${doctor ? doctor.first_name + ' ' + doctor.last_name : 'Not Assigned'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Appointment Type</p>
                            <p class="font-medium">${appointment.appointment_type || 'Regular Checkup'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">${appointment.location || 'Main Clinic'}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tracking Number</p>
                            <p class="font-medium">${appointment.tracking_number || 'N/A'}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Reason for Visit</p>
                        <p>${appointment.reason || 'Not specified'}</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p>${appointment.notes || 'No notes available'}</p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-end gap-3">
                            <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50" onclick="closeAppointmentDetailsModal()">
                                Close
                            </button>
                            <button class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                                <i class="bx bx-printer mr-2"></i>Print Details
                            </button>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <p class="text-center text-red-500">Error loading appointment details. Please try again.</p>
                `;
                console.error('Error:', error);
            });
        }

        // Close appointment details modal
        function closeAppointmentDetailsModal() {
            const modal = document.getElementById('appointmentDetailsModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
    <script src="<?= BASE_URL ?>/js/receptionist/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/appointments.js"></script>
</body>

</html>

