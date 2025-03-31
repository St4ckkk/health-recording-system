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
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <!-- Add this back button at the top of the content section -->
                <section class="p-6">
                    <!-- Back button -->
                    <div class="mb-4">
                        <a href="<?= BASE_URL ?>/receptionist/dashboard"
                            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                            <i class="bx bx-arrow-back mr-2"></i> Back to Dashboard
                        </a>
                    </div>

                    <!-- Patient Info Header -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6 fade-in">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-semibold text-gray-900"><?= $patient->first_name ?>
                                    <?= $patient->last_name ?>
                                </h1>
                                <p class="text-gray-500">
                                    <?= $patient->patient_reference_number ?></p>
                                <div class="flex items-center mt-2">
                                    <i class="bx bx-envelope text-gray-400 mr-2"></i>
                                    <span class="text-gray-600"><?= $patient->email ?></span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <i class="bx bx-phone text-gray-400 mr-2"></i>
                                    <span class="text-gray-600"><?= $patient->contact_number ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment History -->
                    <div class="bg-white rounded-lg shadow-md p-6 fade-in">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">Appointment History</h2>
                                <p class="text-gray-500">Complete record of patient appointments</p>
                            </div>
                            <div class="flex gap-3">
                                <div class="relative">
                                    <input type="text" placeholder="Search appointments..."
                                        class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                                <div class="relative">
                                    <select id="statusFilter"
                                        class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-primary">
                                        <option value="">All Statuses</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="no-show">No Show</option>
                                    </select>
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="bx bx-filter-alt text-gray-400"></i>
                                    </span>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="bx bx-chevron-down text-gray-400"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Timeline -->
                        <div class="appointment-timeline">
                            <?php if (!empty($appointments)): ?>
                                    <?php foreach ($appointments as $index => $appointment): ?>
                                            <?php
                                            // Define status classes and icons
                                            $statusMapping = [
                                                'completed' => ['class' => 'bg-green-100 border-green-500 text-green-800', 'icon' => 'bx-check-circle text-green-500'],
                                                'cancelled' => ['class' => 'bg-red-100 border-red-500 text-red-800', 'icon' => 'bx-x-circle text-red-500'],
                                                'cancelled_by_clinic' => ['class' => 'bg-red-100 border-red-500 text-red-800', 'icon' => 'bx-x-circle text-red-500'],
                                                'cancellation_requested' => ['class' => 'bg-yellow-100 border-yellow-500 text-yellow-800', 'icon' => 'bx-time text-yellow-500'],
                                                'no-show' => ['class' => 'bg-red-100 border-red-500 text-red-800', 'icon' => 'bx-error-circle text-red-500'],
                                                'pending' => ['class' => 'bg-blue-100 border-blue-500 text-blue-800', 'icon' => 'bx-hourglass text-blue-500'],
                                                'confirmed' => ['class' => 'bg-green-100 border-green-500 text-green-800', 'icon' => 'bx-calendar-check text-green-500'],
                                                'checked-in' => ['class' => 'bg-indigo-100 border-indigo-500 text-indigo-800', 'icon' => 'bx-log-in-circle text-indigo-500'],
                                                'in_progress' => ['class' => 'bg-indigo-100 border-indigo-500 text-indigo-800', 'icon' => 'bx-hourglass text-indigo-500'],
                                                'rescheduled' => ['class' => 'bg-yellow-100 border-yellow-500 text-yellow-800', 'icon' => 'bx-calendar-exclamation text-yellow-500'],
                                            ];

                                            $statusInfo = $statusMapping[$appointment->status] ?? $statusMapping['pending'];
                                            $statusLabel = ucwords(str_replace('_', ' ', $appointment->status));

                                            // Define appointment type classes
                                            $typeClass = '';
                                            $appointmentType = $appointment->appointment_type ?? $appointment->type ?? 'checkup';
                                            switch (strtolower($appointmentType)) {
                                                case 'checkup':
                                                    $typeClass = 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 'follow_up':
                                                    $typeClass = 'bg-purple-100 text-purple-800';
                                                    break;
                                                case 'consultation':
                                                    $typeClass = 'bg-indigo-100 text-indigo-800';
                                                    break;
                                                case 'treatment':
                                                    $typeClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'emergency':
                                                    $typeClass = 'bg-red-100 text-red-800';
                                                    break;
                                                case 'specialist':
                                                    $typeClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                default:
                                                    $typeClass = 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                            ?>
                                            <div
                                                class="appointment-card border-l-4 <?= str_replace('bg-', 'border-', $statusInfo['class']) ?> bg-white p-4 rounded-r-lg shadow-sm mb-4 hover:shadow-md transition-shadow">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <span
                                                                class="text-sm font-medium text-gray-900"><?= date('l, F j, Y', strtotime($appointment->appointment_date)) ?></span>
                                                            <span class="mx-2 text-gray-300">•</span>
                                                            <span
                                                                class="text-sm text-gray-600"><?= date('h:i A', strtotime($appointment->appointment_time)) ?></span>
                                                            <span class="mx-2 text-gray-300">•</span>
                                                            <span class="text-sm font-medium">Dr. <?= $appointment->doctor_first_name ?>
                                                                <?= $appointment->doctor_last_name ?></span>
                                                        </div>
                                                        <div class="flex items-center gap-2 mb-3">
                                                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $typeClass ?>">
                                                                <?= ucwords(str_replace('_', ' ', $appointmentType)) ?>
                                                            </span>
                                                            <span
                                                                class="px-2 py-1 rounded-full text-xs font-medium <?= $statusInfo['class'] ?>">
                                                                <i class="bx <?= $statusInfo['icon'] ?> mr-1"></i>
                                                                <?= $statusLabel ?>
                                                            </span>
                                                        </div>
                                                        <p class="text-sm text-gray-600 mb-2">
                                                            <span class="font-medium">Reason:</span>
                                                            <?= $appointment->reason ?? 'General appointment' ?>
                                                        </p>
                                                        <?php if (!empty($appointment->notes)): ?>
                                                                <p class="text-sm text-gray-600">
                                                                    <span class="font-medium">Notes:</span> <?= $appointment->notes ?>
                                                                </p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <button class="action-button-sm bg-primary text-white"
                                                            onclick="viewAppointmentDetails(<?= $appointment->id ?>)">
                                                            <i class="bx bx-show mr-1"></i> View
                                                        </button>
                                                        <?php if ($appointment->status == 'pending'): ?>
                                                                <button class="action-button-sm bg-success text-white"
                                                                    onclick="confirmAppointment(<?= $appointment->id ?>)">
                                                                    <i class="bx bx-check mr-1"></i> Confirm
                                                                </button>
                                                        <?php elseif ($appointment->status == 'confirmed'): ?>
                                                                <button class="action-button-sm bg-indigo-500 text-white"
                                                                    onclick="checkInPatient(<?= $appointment->id ?>)">
                                                                    <i class="bx bx-log-in mr-1"></i> Check In
                                                                </button>
                                                        <?php elseif ($appointment->status == 'checked-in' || $appointment->status == 'in_progress'): ?>
                                                                <button class="action-button-sm bg-green-600 text-white"
                                                                    onclick="completeAppointment(<?= $appointment->id ?>)">
                                                                    <i class="bx bx-check-double mr-1"></i> Complete
                                                                </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php else: ?>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if (!empty($appointments) && count($appointments) > 10): ?>
                                <div class="flex justify-center mt-6">
                                    <nav class="flex items-center space-x-2">
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">
                                            <i class="bx bx-chevron-left"></i>
                                        </a>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 bg-primary text-white">1</a>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">2</a>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">3</a>
                                        <span class="px-3 py-1 text-gray-600">...</span>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">8</a>
                                        <a href="#"
                                            class="px-3 py-1 rounded-md border border-gray-300 text-gray-600 hover:bg-gray-50">
                                            <i class="bx bx-chevron-right"></i>
                                        </a>
                                    </nav>
                                </div>
                        <?php endif; ?>
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
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set base URL for JavaScript use
        window.BASE_URL = '<?= BASE_URL ?>';

        // Initialize date pickers
        document.addEventListener('DOMContentLoaded', function () {
            // Status filter functionality
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function () {
                    filterAppointments();
                });
            }

            // Search functionality
            const searchInput = document.querySelector('input[placeholder="Search appointments..."]');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    filterAppointments();
                });
            }
        });

        // Filter appointments based on search and status
        function filterAppointments() {
            const searchTerm = document.querySelector('input[placeholder="Search appointments..."]').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            const appointmentCards = document.querySelectorAll('.appointment-card');

            appointmentCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                const cardStatus = card.querySelector('.rounded-full:nth-child(2)').textContent.trim().toLowerCase();

                const matchesSearch = searchTerm === '' || cardText.includes(searchTerm);
                const matchesStatus = statusFilter === '' || cardStatus.includes(statusFilter);

                card.style.display = matchesSearch && matchesStatus ? 'block' : 'none';
            });
        }

        // View appointment details
        function viewAppointmentDetails(appointmentId) {
            // This would typically fetch appointment details via AJAX
            // For now, we'll just show the modal
            const modal = document.getElementById('appointmentDetailsModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // In a real implementation, you would fetch the details and populate the modal
            document.getElementById('appointmentDetailsContent').innerHTML = `
                <p class="text-center text-gray-500">Loading appointment details...</p>
            `;

            // Simulate loading data
            setTimeout(() => {
                // This would be replaced with actual data from your AJAX call
                document.getElementById('appointmentDetailsContent').innerHTML = `
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Appointment Date & Time</p>
                                <p class="text-lg font-medium">Monday, June 12, 2023 at 10:30 AM</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="bx bx-check-circle mr-1"></i> Completed
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium">Dr. Jane Smith</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Appointment Type</p>
                            <p class="font-medium">Follow-up</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">Main Clinic, Room 204</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-medium">30 minutes</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Reason for Visit</p>
                        <p>Follow-up on previous treatment and medication review</p>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p>Patient reported improvement in symptoms. Medication dosage adjusted.</p>
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
            }, 500);
        }

        // Close appointment details modal
        function closeAppointmentDetailsModal() {
            const modal = document.getElementById('appointmentDetailsModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Add CSS for action buttons
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                .action-button-sm {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.375rem 0.75rem;
                    font-size: 0.75rem;
                    border-radius: 0.375rem;
                    transition: all 0.2s;
                    white-space: nowrap;
                }
                
                .appointment-card {
                    position: relative;
                    transition: all 0.3s ease;
                }
                
                .appointment-card:hover {
                    transform: translateY(-2px);
                }
                
                .fade-in {
                    animation: fadeIn 0.5s ease-in-out;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            </style>
        `);
    </script>
    <script src="<?= BASE_URL ?>/js/receptionist/reception.js"></script>
    <script src="<?= BASE_URL ?>/js/receptionist/appointments.js"></script>
</body>

</html>