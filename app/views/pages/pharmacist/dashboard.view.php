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
                    <!-- Replace the cards section with this updated version -->
                    <div class="flex gap-4 mb-3">
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
                        </div>

                        <!-- Low Stock Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-yellow-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Low Stock Alert</p>
                                    <h3 class="text-2xl font-semibold text-yellow-600 mt-1"><?= $lowStockCount ?></h3>
                                    <div class="text-yellow-600 text-xs mt-2 max-w-[200px]">
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
                        </div>

                        <!-- Out of Stock Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-red-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Out of Stock Alert</p>
                                    <h3 class="text-2xl font-semibold text-red-600 mt-1"><?= $outOfStockCount ?></h3>
                                    <div class="text-red-600 text-xs mt-2 max-w-[200px]">
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
                        </div>

                        <!-- Expiring Soon Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-orange-200 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Expiring Soon</p>
                                    <h3 class="text-2xl font-semibold text-orange-600 mt-1"><?= $expiringCount ?></h3>
                                    <div class="text-orange-600 text-xs mt-2 max-w-[200px]">
                                        <?php
                                        if (isset($expiringItems)) {
                                            echo strlen($expiringItems) > 30 ?
                                                substr($expiringItems, 0, 30) . '...' :
                                                $expiringItems;
                                        } else {
                                            echo 'No medicines expiring soon';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="bg-orange-50 p-3 rounded-full">
                                    <i class='bx bx-time text-2xl text-orange-500'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add a new section for medicine usage statistics -->
                    <!-- Replace the medicine usage statistics section -->
                    <div class="mt-6">
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Dispensing Statistics by Category</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Dispensed By</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Total Units</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($medicineUsage as $usage): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    <?= htmlspecialchars($usage->category) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($usage->dispenser_name) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= $usage->total_dispensed ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

</html>