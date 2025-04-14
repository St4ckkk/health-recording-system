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

        /* Update table header color */
        .logs-table thead th {
            background-color: #9333ea;
            color: white;
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Update back button hover state */
        .back-button {
            border: 1px solid #9333ea;
            color: #9333ea;
        }

        .back-button:hover {
            background-color: #f3e8ff;
        }

        /* Update focus states for inputs */
        .filter-input:focus {
            border-color: #9333ea;
            --tw-ring-color: #f3e8ff;
        }

        /* Update clear filters button hover */
        button[onclick="clearFilters()"]:hover {
            background-color: #f3e8ff;
            border-color: #9333ea;
        }

        /* Update flatpickr theme */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #9333ea !important;
            border-color: #9333ea !important;
        }

        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #7e22ce !important;
            border-color: #7e22ce !important;
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

        .calendar-icon {
            display: inline-flex;
            padding-left: 5.5rem;
        }

        /* Return to inventory button */
        .return-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            background-color: var(--neutral-light);
            color: var(--neutral-dark);
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .return-btn:hover {
            background-color: var(--neutral-lighter);
        }

        .return-btn i {
            margin-right: 0.5rem;
        }

        /* Action type badge styles */
        .action-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.15rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .action-badge.dispense {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .action-badge.restock {
            background-color: #dcfce7;
            color: #15803d;
        }

        .action-badge.return {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .action-badge.adjustment {
            background-color: #fef3c7;
            color: #b45309;
        }

        /* Stock change indicator */
        .stock-change {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .stock-change.positive {
            color: #15803d;
        }

        .stock-change.negative {
            color: #b91c1c;
        }

        .stock-change.neutral {
            color: #4b5563;
        }

        .stock-change i {
            margin-right: 0.25rem;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/pharmacist/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/pharmacist/components/header.php') ?>
            <div class="content-wrapper">
                <section id="medicineLogsView" class="p-6 view-transition visible-view">
                    <!-- Header section -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Medicine Inventory Logs</h2>
                            <p class="text-sm text-gray-500">Track all medicine inventory activities.</p>
                        </div>
                        <div class="mb-3">
                            <a href="<?= BASE_URL ?>/doctor/medicinesInventory"
                                class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                                <button class="back-button">
                                    <i class="bx bx-arrow-back mr-2"></i> Back to Inventory
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="filter-section">
                        <div class="filter-row">
                            <div class="filter-group" style="flex: 2;">
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search by medicine name or patient ID..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="search bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Action Type Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Action Type</p>
                                <div class="relative">
                                    <select id="actionTypeFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Actions</option>
                                        <option value="dispense">Dispense</option>
                                        <option value="restock">Restock</option>
                                        <option value="return">Return</option>
                                        <option value="adjustment">Adjustment</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Date Range</p>
                                <div class="relative">
                                    <input type="text" id="dateRangeFilter" placeholder="Select date range"
                                        class="filter-input w-full border rounded-md px-3 py-2 pr-9 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 calendar-icon">
                                        <i class="bx bx-calendar text-gray-400"></i>
                                    </span>
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
                            <table class="logs-table w-full">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Action Type</th>
                                        <th>Quantity</th>
                                        <th>Stock Change</th>
                                        <th>Patient</th>
                                        <th>User</th>
                                        <th>Remarks</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($medicineLogs)): ?>
                                        <?php foreach ($medicineLogs as $log): ?>
                                            <?php
                                            // Calculate stock change
                                            $stockChange = $log->new_stock - $log->previous_stock;
                                            $changeClass = 'neutral';
                                            $changeIcon = 'bx-minus';

                                            if ($stockChange > 0) {
                                                $changeClass = 'positive';
                                                $changeIcon = 'bx-up-arrow-alt';
                                            } elseif ($stockChange < 0) {
                                                $changeClass = 'negative';
                                                $changeIcon = 'bx-down-arrow-alt';
                                            }
                                            ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($log->medicine_name ?? 'N/A') ?>
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            <?= htmlspecialchars($log->medicine_category ?? 'N/A') ?> -
                                                            <?= htmlspecialchars($log->medicine_form ?? 'N/A') ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="action-badge <?= $log->action_type ?>">
                                                        <?= htmlspecialchars($log->action_type) ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($log->quantity) ?></td>
                                                <td class="py-3 px-4">
                                                    <div class="stock-change <?= $changeClass ?>">
                                                        <i class="bx <?= $changeIcon ?>"></i>
                                                        <span><?= $log->previous_stock ?> → <?= $log->new_stock ?></span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?php if ($log->patient_id): ?>
                                                        <div class="flex flex-col">
                                                            <span class="font-medium text-md">
                                                                <?= htmlspecialchars($log->patient_name ?? 'N/A') ?>
                                                            </span>
                                                            <span class="text-xs text-gray-500">
                                                                <?= htmlspecialchars($log->patient_reference_number ?? 'N/A') ?>
                                                            </span>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-gray-500">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?php if (!empty($log->staff_id) && !empty($log->staff_name)): ?>
                                                        <div class="flex flex-col">
                                                            <span class="font-medium text-md">
                                                                <?= htmlspecialchars($log->staff_name) ?>
                                                            </span>
                                                            <span class="text-xs text-gray-500 capitalize">
                                                                <?= htmlspecialchars($log->staff_role ?? 'Staff') ?>
                                                            </span>
                                                        </div>
                                                    <?php elseif (!empty($log->doctor_id) && !empty($log->doctor_name)): ?>
                                                        <div class="flex flex-col">
                                                            <span class="font-medium text-md">
                                                                <?= htmlspecialchars($log->doctor_name) ?>
                                                            </span>
                                                            <span class="text-xs text-gray-500 capitalize">
                                                                <?= htmlspecialchars($log->doctor_specialization ?? 'Doctor') ?>
                                                            </span>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-gray-500">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?= !empty($log->remarks) ? htmlspecialchars($log->remarks) : '<span class="text-gray-500">No remarks</span>' ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?= date('Y-m-d H:i:s', strtotime($log->timestamp)) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center py-4">No medicine logs found</td>
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
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('input[placeholder="Search by medicine name or patient ID..."]');
        const actionTypeFilter = document.getElementById('actionTypeFilter');
        const dateRangeFilter = document.getElementById('dateRangeFilter');

        function filterLogs() {
            const searchTerm = searchInput.value.toLowerCase();
            const actionType = actionTypeFilter.value.toLowerCase();
            const dateRange = dateRangeFilter.value;

            document.querySelectorAll('.logs-table tbody tr').forEach(row => {
                if (row.querySelector('td[colspan]')) return;

                const medicineCell = row.querySelector('td:nth-child(1)');
                const actionTypeCell = row.querySelector('td:nth-child(2)');
                const patientCell = row.querySelector('td:nth-child(5)');
                const userCell = row.querySelector('td:nth-child(6)');
                const timestampCell = row.querySelector('td:nth-child(8)');

                const medicineName = medicineCell.textContent.toLowerCase();
                const actionTypeText = actionTypeCell.textContent.trim().toLowerCase();
                const patientInfo = patientCell.textContent.toLowerCase();
                const userInfo = userCell.textContent.toLowerCase();
                const timestamp = timestampCell.textContent;

                const matchesSearch = medicineName.includes(searchTerm) ||
                    patientInfo.includes(searchTerm) ||
                    userInfo.includes(searchTerm);
                const matchesActionType = !actionType || actionTypeText.includes(actionType);
                const matchesDate = !dateRange || dateRange.split(' to ').some(date => timestamp.includes(date.trim()));

                row.style.display = (matchesSearch && matchesActionType && matchesDate) ? '' : 'none';
            });
        }

        // Add event listeners
        searchInput.addEventListener('input', filterLogs);
        actionTypeFilter.addEventListener('change', filterLogs);
        dateRangeFilter.addEventListener('change', filterLogs);

        // Clear filters function
        window.clearFilters = function () {
            searchInput.value = '';
            actionTypeFilter.value = '';
            dateRangeFilter.value = '';
            filterLogs();
        }

        // Initialize flatpickr for date range
        flatpickr("#dateRangeFilter", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: filterLogs
        });
    });
</script>

</html>