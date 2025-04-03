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
                </section>


                </section>


            </div>
        </main>
    </div>
</body>

</html>