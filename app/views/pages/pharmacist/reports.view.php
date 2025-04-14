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
        <?php include(VIEW_ROOT . '/pages/pharmacist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/pharmacist/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Header section -->
                    <div class="mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Pharmacy Inventory Reports</h2>
                            <p class="text-sm text-gray-500">Track medicine inventory, usage patterns, and stock levels.
                            </p>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px space-x-8" aria-label="Statistics">
                            <button class="tab-button active" data-tab="inventory">
                                <i class='bx bx-box mr-2'></i>
                                Stock Levels
                            </button>
                            <button class="tab-button" data-tab="usage">
                                <i class='bx bx-trending-up mr-2'></i>
                                Usage Trends
                            </button>
                            <button class="tab-button" data-tab="expiry">
                                <i class='bx bx-time mr-2'></i>
                                Expiry Tracking
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="mb-6">
                        <div id="inventory-tab" class="tab-content active">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Current Stock Levels</h2>
                                <p class="text-sm text-gray-500 mb-4">Overview of medicine inventory status.</p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="stockLevelsChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div id="usage-tab" class="tab-content hidden">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Monthly Usage Analysis</h2>
                                <p class="text-sm text-gray-500 mb-4">Medicine dispensing patterns over time.</p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="usageChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div id="expiry-tab" class="tab-content hidden">
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Expiry Timeline</h2>
                                <p class="text-sm text-gray-500 mb-4">Medicines grouped by expiration dates.</p>
                                <div style="height: 400px; width: 100%; position: relative;">
                                    <canvas id="expiryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Initialize all charts
                            const stockLevelsChart = new Chart(document.getElementById('stockLevelsChart').getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: <?= json_encode($stockStats->labels) ?>,
                                    datasets: [{
                                        label: 'Current Stock',
                                        data: <?= json_encode($stockStats->current) ?>,
                                        backgroundColor: '#0EA5E9',
                                        borderRadius: 4
                                    }, {
                                        label: 'Minimum Required',
                                        data: <?= json_encode($stockStats->minimum) ?>,
                                        backgroundColor: '#38BDF8',
                                        borderRadius: 4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                                        }
                                    }
                                }
                            });

                            const usageChart = new Chart(document.getElementById('usageChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: <?= json_encode($usageStats->months) ?>,
                                    datasets: [{
                                        label: 'dispense',
                                        data: <?= json_encode($usageStats->dispensed) ?>,
                                        borderColor: '#0EA5E9',
                                        tension: 0.4,
                                        fill: false
                                    }, {
                                        label: 'Restocked',
                                        data: <?= json_encode($usageStats->restocked) ?>,
                                        borderColor: '#10B981',
                                        tension: 0.4,
                                        fill: false
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });

                            const expiryChart = new Chart(document.getElementById('expiryChart').getContext('2d'), {
                                type: 'bar',
                                data: {
                                    labels: <?= json_encode($expiryStats->periods) ?>,
                                    datasets: [{
                                        label: 'Expiring Items',
                                        data: <?= json_encode($expiryStats->counts) ?>,
                                        backgroundColor: '#F59E0B',
                                        borderRadius: 4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });

                            // Tab switching functionality
                            const tabs = document.querySelectorAll('.tab-button');
                            const contents = document.querySelectorAll('.tab-content');

                            tabs.forEach(tab => {
                                tab.addEventListener('click', () => {
                                    // Remove active class from all tabs and contents
                                    tabs.forEach(t => t.classList.remove('active'));
                                    contents.forEach(c => {
                                        c.classList.remove('active');
                                        c.classList.add('hidden');
                                    });

                                    // Add active class to clicked tab and its content
                                    tab.classList.add('active');
                                    const content = document.getElementById(`${tab.dataset.tab}-tab`);
                                    content.classList.add('active');
                                    content.classList.remove('hidden');

                                    // Update charts when tab is switched
                                    switch (tab.dataset.tab) {
                                        case 'inventory':
                                            stockLevelsChart.update();
                                            break;
                                        case 'usage':
                                            usageChart.update();
                                            break;
                                        case 'expiry':
                                            expiryChart.update();
                                            break;
                                    }
                                });
                            });
                        });
                    </script>
                </section>
            </div>
        </main>
    </div>
</body>

</html>