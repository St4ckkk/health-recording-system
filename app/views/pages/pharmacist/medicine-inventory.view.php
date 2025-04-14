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
    <style>
        .action-button i {
            margin-right: 0.25rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
        }

        /* Action buttons container to ensure consistent spacing */
        .action-buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        /* Status badge alignment - only layout properties */
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.15rem 0.5rem;
            border-radius: 0.375rem;
        }

        /* Appointment type alignment - only layout properties */
        .appointment-type {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
        }

        /* Ensure text doesn't overflow */
        .max-w-reason {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Existing styles continue below */
        .filter-section {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            padding: 1.25rem;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .filter-group {
                min-width: 100%;
            }

            .filter-actions {
                width: 100%;
                justify-content: stretch;
            }
        }

        /* Add styles for view transitions */
        .view-transition {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .hidden-view {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }

        .visible-view {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Back button styles */
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

        .action-button.secondary {
            background-color: var(--neutral-light);
            color: var(--neutral-dark);
            border: 1px solid var(--neutral-light);
        }

        .action-button.secondary:hover {
            background-color: var(--neutral-lighter);
        }

        .action-button.danger {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger);
        }

        .action-button.danger:hover {
            background-color: var(--danger-light);
        }

        /* Add styles for view, reschedule and confirm buttons */
        .action-button.view {
            background-color: transparent;
            color: var(--info-dark);
            border: 1px solid var(--info);
        }

        .action-button.view:hover {
            background-color: var(--info-light);
        }

        .action-button.reschedule {
            background-color: transparent;
            color: var(--warning-dark);
            border: 1px solid var(--warning);
        }

        .action-button.reschedule:hover {
            background-color: var(--warning-light);
        }

        .action-button.confirm {
            background-color: transparent;
            color: var(--success-dark);
            border: 1px solid var(--success);
        }

        .action-button.confirm:hover {
            background-color: var(--success-light);
        }

        /* Add delete button style */
        .action-button.delete {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger-dark);
        }

        .action-button.delete:hover {
            background-color: var(--danger-lighter);
        }

        /* Icon-only button styles */
        .action-button.icon-only {
            width: 2rem;
            height: 2rem;
            padding: 0.375rem;
            position: relative;
        }

        .action-button.icon-only i {
            margin-right: 0;
            font-size: 1rem;
        }

        /* Tooltip styles */
        .action-buttons-container {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.7rem;
            white-space: nowrap;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .medicines-table thead th {
            background-color: var(--gray-50);
            color: var(--gray-700);
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: rgba(0, 0, 0, 0.8) transparent transparent transparent;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .calendar-icon {
            display: inline-flex;
            padding-left: 5.5rem;
        }

        /* Update table header color */
        .medicines-table thead th {
            background-color: #9333ea;
            color: white;
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Update button colors while keeping styles */
        .add-medicine-btn {
            background-color: #9333ea;
        }

        .add-medicine-btn:hover {
            background-color: #7e22ce;
        }

        .view-logs-btn {
            background-color: #9333ea;
        }

        .view-logs-btn:hover {
            background-color: #7e22ce;
        }

        /* Update focus ring color for filters */
        .filter-input:focus {
            --tw-ring-color: #9333ea;
        }


        /* Add medicine button */
        .add-medicine-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            background-color: #9333ea;
            color: white;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .add-medicine-btn:hover {
            background-color: #7e22ce;
        }

        .add-medicine-btn i {
            margin-right: 0.5rem;
        }

        /* View logs button */
        .view-logs-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            background-color: #9333ea;
            color: white;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
            margin-right: 1rem;
        }

        .view-logs-btn:hover {
            background-color: #7e22ce;
        }

        .view-logs-btn i {
            margin-right: 0.5rem;
        }

        /* Dispense button */
        .dispense-btn {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dispense-btn:hover {
            background-color: var(--primary-light);
        }

        /* Stock level progress bar styles */
        .stock-level-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 120px;
        }

        .stock-level-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .stock-level-fraction {
            font-size: 0.875rem;
            color: #374151;
        }

        .stock-level-percentage {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .stock-level-bar {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }

        .stock-level-progress {
            height: 100%;
            background-color: #0ea5e9;
            border-radius: 3px;
        }

        /* Different colors based on percentage */
        .stock-level-progress.high {
            background-color: #10b981;
            /* Green for high stock (>70%) */
        }

        .stock-level-progress.medium {
            background-color: #0ea5e9;
            /* Blue for medium stock (30-70%) */
        }

        .stock-level-progress.low {
            background-color: #f59e0b;
            /* Yellow for low stock (10-30%) */
        }

        .stock-level-progress.critical {
            background-color: #ef4444;
            /* Red for critical stock (<10%) */
        }

        .stock-level-progress.empty {
            background-color: #9ca3af;
            /* Gray for empty stock (0%) */
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/pharmacist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/pharmacist/components/header.php') ?>
            <div class="content-wrapper">
                <section id="medicinesView" class="p-6 view-transition visible-view">
                    <!-- Header section -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Medicines Inventory</h2>
                            <p class="text-sm text-gray-500">Manage and track medicine stock levels.</p>
                        </div>
                        <div class="flex">
                            <button class="view-logs-btn"
                                onclick="window.location.href='<?= BASE_URL ?>/pharmacist/medicineLogs'">
                                <i class='bx bx-history'></i>
                                <span>View Dispense Logs</span>
                            </button>
                            <button class="add-medicine-btn"
                                onclick="window.location.href='<?= BASE_URL ?>/pharmacist/addMedicine'">
                                <i class='bx bx-plus'></i>
                                <span>Add Medicine</span>
                            </button>
                        </div>
                    </div>
                    <div class="filter-section">
                        <div class="filter-row">
                            <div class="filter-group" style="flex: 2;">
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search by medicine name or ID..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="search bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Category Filter</p>
                                <div class="relative">
                                    <select id="categoryFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Categories</option>
                                        <option value="analgesic">Analgesic</option>
                                        <option value="antibiotic">Antibiotic</option>
                                        <option value="antiviral">Antiviral</option>
                                        <option value="antipyretic">Antipyretic</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Status Filter</p>
                                <div class="relative">
                                    <select id="statusFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Status</option>
                                        <option value="Available">Available</option>
                                        <option value="low stock">Low Stock</option>
                                        <option value="Out of Stock">Out of Stock</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Clear Filters Button -->
                            <div>
                                <button
                                    class="flex items-center justify-center px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onclick="clearFilters()">
                                    <i class='bx bx-filter-alt mr-2 text-lg'></i>
                                    <span class="text-xs font-medium mr-2">
                                        Clear Filters
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="p-4">
                            <table class="medicines-table w-full">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Form</th>
                                        <th>Dosage</th>
                                        <th>Stock Level</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($medicines)): ?>
                                        <?php foreach ($medicines as $medicine): ?>
                                            <?php
                                            // Calculate stock percentage
                                            $current_stock = $medicine->stock_level;
                                            $max_stock = $medicine->max_stock ?? 100; // Default max stock to 100 if not set
                                            $stock_percentage = ($max_stock > 0) ? round(($current_stock / $max_stock) * 100) : 0;

                                            // Determine progress bar color class based on percentage
                                            $progress_class = 'empty';
                                            if ($stock_percentage > 0) {
                                                if ($stock_percentage > 70) {
                                                    $progress_class = 'high';
                                                } elseif ($stock_percentage > 30) {
                                                    $progress_class = 'medium';
                                                } elseif ($stock_percentage > 10) {
                                                    $progress_class = 'low';
                                                } else {
                                                    $progress_class = 'critical';
                                                }
                                            }
                                            ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($medicine->name) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 capitalize"><?= htmlspecialchars($medicine->category) ?>
                                                </td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($medicine->form) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($medicine->dosage) ?></td>
                                                <td class="py-3 px-4">
                                                    <div class="stock-level-container">
                                                        <div class="stock-level-info">
                                                            <span
                                                                class="stock-level-fraction"><?= $current_stock ?>/<?= $max_stock ?></span>
                                                            <span
                                                                class="stock-level-percentage"><?= $stock_percentage ?>%</span>
                                                        </div>
                                                        <div class="stock-level-bar">
                                                            <div class="stock-level-progress <?= $progress_class ?>"
                                                                style="width: <?= $stock_percentage ?>%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4"><?= date('Y-m-d', strtotime($medicine->expiry_date)) ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="status-badge border 
                                                        <?php
                                                        if ($medicine->status === 'Available')
                                                            echo 'border-success text-success';
                                                        elseif ($medicine->status === 'Low Stock')
                                                            echo 'border-warning text-warning';
                                                        elseif ($medicine->status === 'Out of Stock')
                                                            echo 'border-danger text-danger';
                                                        elseif ($medicine->status === 'Expired')
                                                            echo 'border-danger text-danger';
                                                        ?>">
                                                        <?= htmlspecialchars($medicine->status) ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <button class="p-2 text-yellow-600 hover:text-yellow-800"
                                                                onclick="window.location.href='<?= BASE_URL ?>/doctor/editMedicine/?id=<?= $medicine->id ?>'"
                                                                data-medicine-id="<?= htmlspecialchars($medicine->id) ?>">
                                                                <i class="bx bx-edit text-lg"></i>
                                                                <span class="tooltip-text">Edit</span>
                                                            </button>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button class="p-2 text-red-600 hover:text-red-800"
                                                                onclick="openDeleteModal(<?= $medicine->id ?>, '<?= htmlspecialchars($medicine->name, ENT_QUOTES) ?>')"
                                                                data-medicine-id="<?= htmlspecialchars($medicine->id) ?>">
                                                                <i class="bx bx-trash text-lg"></i>
                                                                <span class="tooltip-text">Delete</span>
                                                            </button>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button class="p-2 text-blue-600 hover:text-blue-800"
                                                                onclick="openDispenseModal(<?= $medicine->id ?>, '<?= htmlspecialchars($medicine->name) ?>')"
                                                                data-medicine-id="<?= htmlspecialchars($medicine->id) ?>">
                                                                <i class="bx bx-package text-lg"></i>
                                                                <span class="tooltip-text">Dispense</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center py-4">No medicines found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>


    <?php include(VIEW_ROOT . '/pages/pharmacist/components/modals/add-medicine.php') ?>

    <?php include(VIEW_ROOT . '/pages/pharmacist/components/modals/delete-medicine.php') ?>
    <script src="<?= BASE_URL ?>/js/pharmacist/inventory.js"></script>
    <script src="<?= BASE_URL ?>/js/pharmacist/addMed.js"></script>
    <script src="<?= BASE_URL ?>/js/pharmacist/deleteMed.js"></script>
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
</body>

</html>