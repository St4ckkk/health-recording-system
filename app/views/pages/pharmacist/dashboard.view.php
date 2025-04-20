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
                    <div class="image-header">
                        <img src="<?= BASE_URL ?>/images/pharmacist.jpg" class="image-header-bg" alt="Pharmacy Counter">
                        <div class="image-header-overlay"></div>
                        <div class="image-header-pattern"></div>
                        <div class="image-header-content">
                            <h1 class="image-header-title">Pharmacy Dashboard</h1>
                            <p class="image-header-subtitle">Monitor medicine inventory and manage prescriptions</p>
                        </div>
                    </div>

                    <!-- Inventory Overview Cards -->
                    <div class="flex gap-4 mb-6 mt-6">
                        <!-- Total Medicines Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Medicines</p>
                                    <h3 class="text-2xl font-semibold mt-1"><?= number_format($totalMedicines) ?></h3>
                                    <p class="text-gray-500 text-xs mt-1">In inventory</p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded-full">
                                    <i class='bx bx-capsule text-2xl text-purple-500'></i>
                                </div>
                            </div>
                            <?php if (isset($inventoryValue)): ?>
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <p class="text-gray-500 text-xs">Estimated Value: <span
                                            class="font-semibold text-purple-600">PHP
                                            <?= number_format($inventoryValue->total_value, 2) ?></span>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Low Stock Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-yellow-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Low Stock Alert</p>
                                    <h3 class="text-2xl font-semibold text-yellow-600 mt-1"><?= $lowStockCount ?></h3>
                                    <div class="text-yellow-600 text-xs mt-2 max-w-[200px] truncate">
                                        <?php
                                        $lowStockArray = explode(', ', $lowStockItems);
                                        $lowStockOnly = array_filter($lowStockArray, function ($item) {
                                            return !strpos($item, 'Out of Stock');
                                        });
                                        echo implode(', ', $lowStockOnly) ?: 'No low stock items';
                                        ?>
                                    </div>
                                </div>
                                <div class="bg-yellow-50 p-3 rounded-full">
                                    <i class='bx bx-error text-2xl text-yellow-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-yellow-100">
                                <a href="<?= BASE_URL ?>/pharmacist/medicine-inventory"
                                    class="text-yellow-600 text-xs flex items-center">
                                    <span>View inventory</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Out of Stock Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-red-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Out of Stock Alert</p>
                                    <h3 class="text-2xl font-semibold text-red-600 mt-1"><?= $outOfStockCount ?></h3>
                                    <div class="text-red-600 text-xs mt-2 max-w-[200px] truncate">
                                        <?php
                                        $outOfStockArray = explode(', ', $lowStockItems);
                                        $outOfStockOnly = array_filter($outOfStockArray, function ($item) {
                                            return strpos($item, 'Out of Stock');
                                        });
                                        echo implode(', ', $outOfStockOnly) ?: 'No out of stock items';
                                        ?>
                                    </div>
                                </div>
                                <div class="bg-red-50 p-3 rounded-full">
                                    <i class='bx bx-x-circle text-2xl text-red-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-red-100">
                                <a href="<?= BASE_URL ?>/pharmacist/medicine-inventory"
                                    class="text-red-600 text-xs flex items-center">
                                    <span>Restock now</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Expiring Soon Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-orange-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Expiring Soon</p>
                                    <h3 class="text-2xl font-semibold text-orange-600 mt-1"><?= $expiringCount ?></h3>
                                    <div class="text-orange-600 text-xs mt-2 max-w-[200px] truncate">
                                        <?= $expiringItems ?: 'No medicines expiring soon' ?>
                                    </div>
                                </div>
                                <div class="bg-orange-50 p-3 rounded-full">
                                    <i class='bx bx-time text-2xl text-orange-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-orange-100">
                                <a href="<?= BASE_URL ?>/pharmacist/reports"
                                    class="text-orange-600 text-xs flex items-center">
                                    <span>View expiry report</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Category Distribution Chart -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 lg:col-span-1">
                            <h2 class="text-lg font-semibold mb-4">Medicine Categories</h2>
                            <div class="h-64">
                                <canvas id="categoryChart"></canvas>
                            </div>
                            <div class="mt-4 text-xs text-gray-500">
                                <p>Distribution of medicines by category</p>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 lg:col-span-2">
                            <h2 class="text-lg font-semibold mb-4">Recent Inventory Movements</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Medicine</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Action</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Quantity</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                By</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($recentTransactions) && !empty($recentTransactions)): ?>
                                            <?php foreach ($recentTransactions as $transaction): ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($transaction->medicine_name) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            <?php
                                                            if ($transaction->action_type === 'dispense')
                                                                echo 'bg-red-100 text-red-800';
                                                            elseif ($transaction->action_type === 'restock')
                                                                echo 'bg-green-100 text-green-800';
                                                            else
                                                                echo 'bg-blue-100 text-blue-800';
                                                            ?>">
                                                            <?= ucfirst(htmlspecialchars($transaction->action_type)) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= $transaction->quantity ?>
                                                        <span class="text-xs text-gray-400">(<?= $transaction->previous_stock ?>
                                                            → <?= $transaction->new_stock ?>)</span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($transaction->performed_by) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= date('M d, H:i', strtotime($transaction->created_at)) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    recent transactions</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="<?= BASE_URL ?>/pharmacist/medicine-logs"
                                    class="text-blue-600 text-sm hover:underline">View all transactions</a>
                            </div>
                        </div>
                    </div>

                    <!-- Dispensing Statistics and Expiring Medicines -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Dispensing Statistics -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Dispensing Statistics by Category</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Dispensed By</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total Units</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($medicineUsage) && !empty($medicineUsage)): ?>
                                            <?php foreach ($medicineUsage as $usage): ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($usage->category) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($usage->dispenser_name) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <span
                                                                class="text-sm text-gray-900 mr-2"><?= $usage->total_dispensed ?></span>
                                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-blue-600 h-2 rounded-full"
                                                                    style="width: <?= min(100, ($usage->total_dispensed / 100) * 100) ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    dispensing data available</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Expiring Medicines -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Medicines Expiring Soon</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Medicine</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Stock</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Expiry Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($expiringMedicines) && !empty($expiringMedicines)): ?>
                                            <?php foreach ($expiringMedicines as $medicine): ?>
                                                <?php
                                                $daysUntilExpiry = floor((strtotime($medicine->expiry_date) - time()) / (60 * 60 * 24));
                                                $expiryClass = $daysUntilExpiry <= 7 ? 'text-red-600' : ($daysUntilExpiry <= 14 ? 'text-orange-600' : 'text-yellow-600');
                                                ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($medicine->name) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($medicine->category) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= $medicine->stock_level ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm <?= $expiryClass ?>">
                                                        <?= date('M d, Y', strtotime($medicine->expiry_date)) ?>
                                                        <span class="text-xs">(<?= $daysUntilExpiry ?> days)</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    medicines expiring soon</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="<?= BASE_URL ?>/pharmacist/reports"
                                    class="text-blue-600 text-sm hover:underline">View full expiry report</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Category Distribution Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            const categoryChart = new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($categoryData['labels'] ?? []) ?>,
                    datasets: [{
                        data: <?= json_encode($categoryData['counts'] ?? []) ?>,
                        backgroundColor: <?= json_encode($categoryData['colors'] ?? []) ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 10
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>