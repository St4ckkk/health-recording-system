<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Patient Dashboard' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
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
        <!-- Sidebar would go here if needed -->
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/patient/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-4 md:p-6 max-w-7xl mx-auto">
                    <!-- Dashboard Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Health Monitoring
                                    Dashboard</h1>
                                <p class="text-gray-600">Welcome back,
                                    <?= htmlspecialchars($patient_name ?? 'Patient') ?>! Track your health journey here.
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <button
                                    class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg text-sm flex items-center transition-colors">
                                    <i class="bx bx-download mr-2"></i> Export Health Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/quick-stats.php') ?>

                    <!-- Main Dashboard Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Symptom Tracker Chart -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/symptom-chart.php') ?>

                            <!-- Medication Log -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/medication-log.php') ?>

                            <!-- Symptom Log Form -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/symptom-log.php') ?>

                            <!-- Wellness Survey -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/wellness-survey.php') ?>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Notifications -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/notifications.php') ?>

                            <!-- Achievement Badges -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/achievement-badges.php') ?>

                            <!-- Consultation Request -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/consultation-request.php') ?>

                            <!-- Upcoming Appointments -->
                            <?php include(VIEW_ROOT . '/pages/patient/components/dashboard/upcoming-appointments.php') ?>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // Initialize symptom chart
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('symptomChart').getContext('2d');
            const symptomChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['May 10', 'May 11', 'May 12', 'May 13', 'May 14', 'May 15', 'May 16'],
                    datasets: [
                        {
                            label: 'Fatigue Level',
                            data: [3, 4, 3, 2, 2, 1, 1],
                            borderColor: 'rgba(79, 209, 197, 1)',
                            backgroundColor: 'rgba(79, 209, 197, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(79, 209, 197, 1)',
                            pointRadius: 4
                        },
                        {
                            label: 'Cough Severity',
                            data: [2, 2, 1, 1, 0, 0, 0],
                            borderColor: 'rgba(129, 140, 248, 1)',
                            backgroundColor: 'rgba(129, 140, 248, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(129, 140, 248, 1)',
                            pointRadius: 4
                        },
                        {
                            label: 'Temperature',
                            data: [99.1, 99.3, 98.9, 98.7, 98.6, 98.6, 98.5],
                            borderColor: 'rgba(245, 158, 11, 1)',
                            backgroundColor: 'rgba(245, 158, 11, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                            pointRadius: 4,
                            hidden: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#111827',
                            bodyColor: '#4B5563',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 10,
                            boxPadding: 4
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                color: '#9CA3AF'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#9CA3AF'
                            }
                        }
                    }
                }
            });

            // Initialize flatpickr for any date inputs
            flatpickr(".date-picker", {
                dateFormat: "Y-m-d",
                defaultDate: new Date()
            });
        });
    </script>
</body>

</html>