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
</head>

<body class="font-body">
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
                                        <p class="<?= $patientPercentage >= 0 ? 'text-green-500' : 'text-red-500' ?> text-xs mt-1">
                                            <?= ($patientPercentage >= 0 ? '+' : '') . $patientPercentage ?>% from last month
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
                                        <p class="text-gray-500 text-xs mt-1" title="<?= htmlspecialchars($lowStockItems) ?>">
                                            <?= $lowStockCount > 0 ? (strlen($lowStockItems) > 30 ? substr($lowStockItems, 0, 30) . '...' : $lowStockItems) : 'All stocks normal' ?>
                                        </p>
                                    </div>
                                    <div class="bg-red-50 p-3 rounded-full">
                                        <i class='bx bx-capsule text-2xl text-red-500'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <section class="p-6 pt-0">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Appointments</h2>
                        <div class="flex space-x-4 overflow-x-auto pb-2">
                            <?php foreach ($recentAppointments as $index => $appointment): ?>
                                <div class="flex items-center rounded-lg min-w-[240px] rounded-lg p-3 shadow-sm border border-gray-100 fade-in">
                                    <div class="w-12 h-12 rounded-full overflow-hidden mr-3">
                                        <?php if (!empty($appointment->profile)): ?>
                                            <img src="<?= BASE_URL . '/' . $appointment->profile ?>"
                                                class="w-full h-full object-cover"
                                                alt="<?= htmlspecialchars($appointment->patient_name) ?>">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-blue-500 flex items-center justify-center text-white">
                                                <i class="bx bx-user text-xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900"><?= htmlspecialchars($appointment->patient_name) ?></h3>
                                        <p class="text-gray-400 text-sm capitalize"><?= htmlspecialchars($appointment->type) ?></p>
                                        <div class="flex items-center text-gray-400 text-xs mt-1">
                                            <i class='bx bx-time-five mr-1'></i>
                                            <span><?= $appointment->formatted_time ?> | <?= $appointment->duration ?? '30' ?> Min</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (empty($recentAppointments)): ?>
                                <div class="bg-white rounded-lg p-4 text-center text-gray-500 w-full">
                                    <p>No recent appointments</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Upcoming Appointments Section -->
                    <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($upcomingAppointments as $appointment): ?>
                            <div class="bg-white rounded-lg overflow-hidden">
                                <div class="h-48 overflow-hidden">
                                    <?php if (!empty($appointment->profile)): ?>
                                        <img src="<?= BASE_URL . '/' . $appointment->profile ?>" 
                                             alt="<?= htmlspecialchars($appointment->patient_name) ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-blue-500 flex items-center justify-center text-white">
                                            <i class="bx bx-user text-6xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-lg text-gray-900"><?= htmlspecialchars($appointment->patient_name) ?></h3>
                                    <p class="text-gray-500 text-sm mb-3">No. Register #<?= htmlspecialchars($appointment->patient_id) ?></p>
                                        
                                        <div class="text-sm text-gray-500 mb-1">Date Consult</div>
                                        <div class="text-gray-900 font-medium mb-3"><?= date('d F Y', strtotime($appointment->appointment_date)) ?> | <?= $appointment->formatted_time ?></div>
                                        
                                        <div class="text-sm text-gray-500 mb-1">Consult</div>
                                        <div class="text-gray-900">Dr. <?= htmlspecialchars($appointment->doctor_name ?? 'Physician') ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <?php if (empty($upcomingAppointments)): ?>
                                <div class="col-span-3 bg-white rounded-lg p-8 text-center text-gray-500">
                                    <i class='bx bx-calendar-x text-4xl mb-2'></i>
                                    <p>No upcoming appointments scheduled</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div> -->
                </section>
            </div>
        </main>
    </div>
    

</body>

</html>