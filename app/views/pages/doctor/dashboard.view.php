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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
</head>

<body class="font-body bg-gray-50">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="image-header">
                        <img src="<?= BASE_URL ?>/images/receptionist-header.png" class="image-header-bg"
                            alt="Reception Desk">
                        <div class="image-header-overlay"></div>
                        <div class="image-header-pattern"></div>
                        <div class="image-header-content">
                            <h1 class="image-header-title">Doctor Dashboard</h1>
                            <p class="image-header-subtitle">Efficiently manage patient appointments and schedules</p>
                        </div>
                    </div>
                    <div class="flex gap-4 mb-3">
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Patients</p>
                                    <h3 class="text-2xl font-semibold mt-1"><?= number_format($totalPatients) ?></h3>
                                    <p
                                        class="<?= $patientPercentage >= 0 ? 'text-green-500' : 'text-red-500' ?> text-xs mt-1">
                                        <?= ($patientPercentage >= 0 ? '+' : '') . $patientPercentage ?>% from last
                                        month
                                    </p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-full">
                                    <i class='bx bx-user text-2xl text-blue-500'></i>
                                </div>
                            </div>
                        </div>

                        <!-- Today's Appointments Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Today's Appointments</p>
                                    <h3 class="text-2xl font-semibold mt-1"><?= $todayAppointments ?></h3>
                                    <!-- <p class="text-gray-500 text-xs mt-1">
                                            <?= $urgentAppointments ?> urgent consultation<?= $urgentAppointments !== 1 ? 's' : '' ?>
                                        </p> -->
                                </div>
                                <div class="bg-green-50 p-3 rounded-full">
                                    <i class='bx bx-calendar text-2xl text-green-500'></i>
                                </div>
                            </div>
                        </div>
                        <!-- Medicine Alerts Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Medicine Alerts</p>
                                    <h3 class="text-2xl font-semibold mt-1">
                                        <?= $lowStockCount ?>
                                    </h3>
                                    <p class="text-gray-500 text-xs mt-1"
                                        title="<?= htmlspecialchars($lowStockItems) ?>">
                                        <?= $lowStockCount > 0 ? (strlen($lowStockItems) > 30 ? substr($lowStockItems, 0, 30) . '...' : $lowStockItems) : 'All stocks normal' ?>
                                    </p>
                                </div>
                                <div class="bg-red-50 p-3 rounded-full">
                                    <i class='bx bx-capsule text-2xl text-red-500'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Appointments Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Today's Appointments List -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 col-span-2 fade-in">
                            <div class="p-4 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800">Today's Appointments</h3>
                            </div>
                            <div class="p-4">
                                <?php if (empty($recentAppointments)): ?>
                                    <p class="text-gray-500 text-center py-4">No appointments scheduled for today</p>
                                <?php else: ?>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Patient</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Time</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status</th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php foreach ($recentAppointments as $appointment): ?>
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    <img class="h-10 w-10 rounded-full"
                                                                        src="<?= BASE_URL ?>/uploads/profiles/<?= $appointment->profile ?: 'default-avatar.jpg' ?>"
                                                                        alt="Patient profile">
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        <?= htmlspecialchars($appointment->patient_name) ?>
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        <?= $appointment->patient_reference_number ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">
                                                                <?= $appointment->formatted_time ?></div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                <?php
                                                                switch ($appointment->status) {
                                                                    case 'pending':
                                                                        echo 'bg-yellow-100 text-yellow-800';
                                                                        break;
                                                                    case 'checked_in':
                                                                        echo 'bg-blue-100 text-blue-800';
                                                                        break;
                                                                    case 'in_progress':
                                                                        echo 'bg-purple-100 text-purple-800';
                                                                        break;
                                                                    case 'completed':
                                                                        echo 'bg-green-100 text-green-800';
                                                                        break;
                                                                    case 'cancelled':
                                                                        echo 'bg-red-100 text-red-800';
                                                                        break;
                                                                    case 'no_show':
                                                                        echo 'bg-gray-100 text-gray-800';
                                                                        break;
                                                                    default:
                                                                        echo 'bg-gray-100 text-gray-800';
                                                                }
                                                                ?>">
                                                                <?= ucfirst(str_replace('_', ' ', $appointment->status)) ?>
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            <a href="<?= BASE_URL ?>/doctor/patient-view?id=<?= $appointment->patient_id ?>"
                                                                class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                            <a href="<?= BASE_URL ?>/doctor/check-up?id=<?= $appointment->patient_id ?>"
                                                                class="text-green-600 hover:text-green-900">Check-up</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 border-t border-gray-100 text-right">
                                <a href="<?= BASE_URL ?>/doctor/appointments"
                                    class="text-sm text-indigo-600 hover:text-indigo-900">View all appointments →</a>
                            </div>
                        </div>

                        <!-- Quick Stats Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 fade-in">
                            <div class="p-4 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800">Quick Stats</h3>
                            </div>
                            <div class="p-4">
                                <div class="space-y-4">
                                    <!-- Common Diagnoses -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Common Diagnoses</h4>
                                        <?php if (isset($diagnosisStats) && !empty($diagnosisStats)): ?>
                                            <div class="space-y-2">
                                                <?php foreach (array_slice($diagnosisStats, 0, 3) as $diagnosis): ?>
                                                    <div class="flex items-center justify-between">
                                                        <span
                                                            class="text-sm text-gray-700"><?= htmlspecialchars($diagnosis->diagnosis) ?></span>
                                                        <span
                                                            class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-1 rounded-full"><?= $diagnosis->count ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No diagnosis data available</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Common Symptoms -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Common Symptoms</h4>
                                        <?php if (isset($commonSymptoms) && !empty($commonSymptoms)): ?>
                                            <div class="space-y-2">
                                                <?php foreach (array_slice($commonSymptoms, 0, 3) as $symptom): ?>
                                                    <div class="flex items-center justify-between">
                                                        <span
                                                            class="text-sm text-gray-700"><?= htmlspecialchars($symptom->name) ?></span>
                                                        <span
                                                            class="text-xs font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full"><?= $symptom->count ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No symptom data available</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Patient Demographics -->
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Patient Demographics</h4>
                                        <?php if (isset($patientDemographics) && !empty($patientDemographics['gender_distribution'])): ?>
                                            <div class="space-y-2">
                                                <?php foreach ($patientDemographics['gender_distribution'] as $gender): ?>
                                                    <div class="flex items-center justify-between">
                                                        <span
                                                            class="text-sm text-gray-700"><?= ucfirst(htmlspecialchars($gender->gender ?: 'Not specified')) ?></span>
                                                        <span
                                                            class="text-xs font-medium bg-purple-100 text-purple-800 px-2 py-1 rounded-full"><?= $gender->count ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No demographic data available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-100 text-right">
                                <a href="<?= BASE_URL ?>/doctor/reports"
                                    class="text-sm text-indigo-600 hover:text-indigo-900">View detailed reports →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- Appointments Chart -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Trends</h3>
                            <div class="h-64">
                                <canvas id="appointmentsChart"></canvas>
                            </div>
                        </div>

                        <!-- Patient Distribution Chart -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient Age Distribution</h3>
                            <div class="h-64">
                                <canvas id="ageDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Appointments Section -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h3>
                        </div>
                        <div class="p-4">
                            <?php if (empty($upcomingAppointments)): ?>
                                <p class="text-gray-500 text-center py-4">No upcoming appointments scheduled</p>
                            <?php else: ?>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Patient</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date & Time</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Type</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach (array_slice($upcomingAppointments, 0, 5) as $appointment): ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full"
                                                                    src="<?= BASE_URL ?>/uploads/profiles/<?= $appointment->profile ?: 'default-avatar.jpg' ?>"
                                                                    alt="Patient profile">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <?= htmlspecialchars($appointment->patient_name) ?></div>
                                                                <div class="text-sm text-gray-500">
                                                                    <?= $appointment->patient_reference_number ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900"><?= $appointment->formatted_date ?>
                                                        </div>
                                                        <div class="text-sm text-gray-500"><?= $appointment->formatted_time ?>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            <?= ucfirst($appointment->appointment_type ?: 'Checkup') ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            <?php
                                                            switch ($appointment->status) {
                                                                case 'pending':
                                                                    echo 'bg-yellow-100 text-yellow-800';
                                                                    break;
                                                                case 'checked_in':
                                                                    echo 'bg-blue-100 text-blue-800';
                                                                    break;
                                                                case 'in_progress':
                                                                    echo 'bg-purple-100 text-purple-800';
                                                                    break;
                                                                case 'completed':
                                                                    echo 'bg-green-100 text-green-800';
                                                                    break;
                                                                case 'cancelled':
                                                                    echo 'bg-red-100 text-red-800';
                                                                    break;
                                                                case 'no_show':
                                                                    echo 'bg-gray-100 text-gray-800';
                                                                    break;
                                                                default:
                                                                    echo 'bg-gray-100 text-gray-800';
                                                            }
                                                            ?>">
                                                            <?= ucfirst(str_replace('_', ' ', $appointment->status)) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <a href="<?= BASE_URL ?>/doctor/patient-view?id=<?= $appointment->patient_id ?>"
                                                            class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 border-t border-gray-100 text-right">
                            <a href="<?= BASE_URL ?>/doctor/appointments"
                                class="text-sm text-indigo-600 hover:text-indigo-900">View all appointments →</a>
                        </div>
                    </div>
                </section>

                <!-- JavaScript for Charts -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Appointment Trends Chart
                        <?php if (isset($visitStats) && !empty($visitStats['monthly'])): ?>
                            const appointmentCtx = document.getElementById('appointmentsChart').getContext('2d');
                            const appointmentLabels = <?= json_encode(array_map(function ($item) {
                                return date('M Y', strtotime($item->month . '-01'));
                            }, $visitStats['monthly'])) ?>;

                            const appointmentData = <?= json_encode(array_map(function ($item) {
                                return $item->total_visits;
                            }, $visitStats['monthly'])) ?>;

                            new Chart(appointmentCtx, {
                                type: 'line',
                                data: {
                                    labels: appointmentLabels,
                                    datasets: [{
                                        label: 'Appointments',
                                        data: appointmentData,
                                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                        borderColor: 'rgba(79, 70, 229, 1)',
                                        borderWidth: 2,
                                        tension: 0.3,
                                        fill: true
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0
                                            }
                                        }
                                    }
                                }
                            });
                        <?php endif; ?>

                        // Age Distribution Chart
                        <?php if (isset($patientDemographics) && !empty($patientDemographics['age_groups'])): ?>
                            const ageCtx = document.getElementById('ageDistributionChart').getContext('2d');
                            const ageLabels = <?= json_encode(array_map(function ($item) {
                                return $item->age_group;
                            }, $patientDemographics['age_groups'])) ?>;

                            const ageData = <?= json_encode(array_map(function ($item) {
                                return $item->count;
                            }, $patientDemographics['age_groups'])) ?>;

                            new Chart(ageCtx, {
                                type: 'bar',
                                data: {
                                    labels: ageLabels,
                                    datasets: [{
                                        label: 'Patients',
                                        data: ageData,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.7)',
                                            'rgba(54, 162, 235, 0.7)',
                                            'rgba(255, 206, 86, 0.7)',
                                            'rgba(75, 192, 192, 0.7)',
                                            'rgba(153, 102, 255, 0.7)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0
                                            }
                                        }
                                    }
                                }
                            });
                        <?php endif; ?>
                    });
                </script>
            </div>
        </main>
    </div>
</body>

</html>