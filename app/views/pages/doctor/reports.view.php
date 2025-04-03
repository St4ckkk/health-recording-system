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
                    <!-- Header section -->
                    <div class="mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Reports & Analytics</h2>
                            <p class="text-sm text-gray-500">View and analyze patient visits, diagnoses, and medicine
                                usage statistics.</p>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px space-x-8" aria-label="Statistics">
                            <button class="tab-button active" data-tab="visits">
                                <i class='bx bx-line-chart mr-2'></i>
                                Patient Visits
                            </button>
                            <button class="tab-button" data-tab="diagnosis">
                                <i class='bx bx-pie-chart-alt-2 mr-2'></i>
                                Diagnosis Distribution
                            </button>
                            <button class="tab-button" data-tab="medicine">
                                <i class='bx bx-bar-chart-alt-2 mr-2'></i>
                                Medicine Usage
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="">
                        <div id="visits-tab" class="tab-content active">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Visits Over Time</h2>
                                <p class="text-sm text-gray-500 mb-4">Number of patient visits per month.</p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="visitsChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div id="diagnosis-tab" class="tab-content hidden">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Diagnosis Distribution</h2>
                                <p class="text-sm text-gray-500 mb-4">Distribution of diagnoses across all patients.</p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="diagnosisChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div id="medicine-tab" class="tab-content hidden">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Medicine Usage</h2>
                                <p class="text-sm text-gray-500 mb-4">Comparison of prescribed vs dispensed medications.
                                </p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="medicineUsageChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Tab switching functionality
                        document.addEventListener('DOMContentLoaded', function () {
                            const tabs = document.querySelectorAll('.tab-button');

                            tabs.forEach(tab => {
                                tab.addEventListener('click', () => {
                                    // Remove active class from all tabs
                                    tabs.forEach(t => t.classList.remove('active'));
                                    document.querySelectorAll('.tab-content').forEach(content => {
                                        content.classList.remove('active');
                                        content.classList.add('hidden');
                                    });

                                    // Add active class to clicked tab
                                    tab.classList.add('active');
                                    const tabContent = document.getElementById(`${tab.dataset.tab}-tab`);
                                    tabContent.classList.add('active');
                                    tabContent.classList.remove('hidden');
                                });
                            });
                        });

                        const ctx = document.getElementById('visitsChart').getContext('2d');
                        const visitStats = <?= json_encode($visitStats) ?>;

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: visitStats.labels,
                                datasets: [{
                                    label: 'visits',
                                    data: visitStats.data,
                                    borderColor: '#0EA5E9',
                                    backgroundColor: '#0EA5E9',
                                    tension: 0.4,
                                    pointRadius: 4,
                                    pointStyle: 'circle',
                                    pointBackgroundColor: 'white',
                                    pointBorderColor: '#0EA5E9',
                                    pointBorderWidth: 2,
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)',
                                            drawBorder: false,
                                            drawTicks: true
                                        },
                                        ticks: {
                                            stepSize: 25,
                                            padding: 10,
                                            color: '#666'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#666'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom',
                                        align: 'start',
                                        labels: {
                                            usePointStyle: true,
                                            pointStyle: 'circle',
                                            padding: 20,
                                            color: '#666',
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                }
                            }

                        });

                        // Add Diagnosis Distribution Chart
                        const diagnosisCtx = document.getElementById('diagnosisChart').getContext('2d');
                        const diagnosisStats = <?= json_encode($diagnosisStats) ?>;

                        // Process data for the chart
                        const labels = diagnosisStats.map(item => item.diagnosis);
                        const data = diagnosisStats.map(item => item.count);
                        const total = data.reduce((a, b) => a + b, 0);
                        const percentages = data.map(value => ((value / total) * 100).toFixed(0));

                        // Define colors for different diagnoses
                        const colors = [
                            '#0EA5E9', // Blue
                            '#10B981', // Green
                            '#F59E0B', // Yellow
                            '#EF4444', // Red
                            '#8B5CF6'  // Purple
                        ];

                        new Chart(diagnosisCtx, {
                            type: 'pie',
                            data: {
                                labels: labels.map((label, index) => `${label}: ${percentages[index]}%`),
                                datasets: [{
                                    data: data,
                                    backgroundColor: colors,
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            usePointStyle: true,
                                            padding: 20,
                                            color: '#666',
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                }
                            }
                        });

                        // Medicine Usage Chart
                        const medicineUsageCtx = document.getElementById('medicineUsageChart').getContext('2d');
                        const medicineStats = <?= json_encode($medicineUsageStats) ?>;

                        new Chart(medicineUsageCtx, {
                            type: 'bar',
                            data: {
                                labels: medicineStats.map(item => item.category),
                                datasets: [
                                    {
                                        label: 'Restock',
                                        data: medicineStats.map(item => item.prescribed_count),
                                        backgroundColor: '#0EA5E9',
                                        borderRadius: 4,
                                    },
                                    {
                                        label: 'Dispensed',
                                        data: medicineStats.map(item => item.dispensed_count),
                                        backgroundColor: '#38BDF8',
                                        borderRadius: 4,
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)',
                                            drawBorder: false
                                        },
                                        ticks: {
                                            color: '#666'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: '#666'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            usePointStyle: true,
                                            padding: 20,
                                            color: '#666',
                                            font: {
                                                size: 12
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </section>
            </div>
        </main>
    </div>
</body>

</html>