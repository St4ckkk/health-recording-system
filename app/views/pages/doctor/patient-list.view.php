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

        .appointments-table thead th {
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

        .appointments-table thead th {
            background-color: rgba(22, 163, 74); 
            color: white;
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
            <section id="appointmentsView" class="p-6 view-transition visible-view">
                    <!-- Header section -->
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Patients</h2>
                        <p class="text-sm text-gray-500">Manage and view patient records.</p>
                    </div>
                    <div class="filter-section">
                        <div class="filter-row">
                            <div class="filter-group" style="flex: 2;">
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search by patient name or ID..."
                                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="search bx bx-search text-gray-400"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Type Filter -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Status Filter</p>
                                <div class="relative">
                                    <select id="statusFilter"
                                        class="filter-input w-full border rounded-md px-3 py-2 pl-9 pr-4 appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Date Filter (moved to the right) -->
                            <div class="filter-group">
                                <p class="filter-label text-xs font-medium mb-1">Date Filter</p>
                                <div class="relative">
                                    <input type="text" id="dateFilter" placeholder="Select date"
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
                            <table class="appointments-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Last Visit</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($patients)): ?>
                                        <?php foreach ($patients as $patient): ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($patient->first_name . ' ' . $patient->last_name) ?>
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            <?= htmlspecialchars($patient->patient_reference_number) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($patient->age ?? 'N/A') ?></td>
                                                <td class="py-3 px-4 capitalize"><?= htmlspecialchars($patient->gender ?? 'N/A') ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($patient->condition ?? 'N/A') ?></td>
                                                <td class="py-3 px-4">
                                                    <span class="status-badge border <?= $patient->status === 'active' ? 'border-success text-success' : 'border-warning text-warning' ?>">
                                                        <?= htmlspecialchars($patient->status ?? 'N/A') ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?= $patient->last_visit ? date('M d, Y', strtotime($patient->last_visit)) : 'N/A' ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <button class="p-2 text-blue-600 hover:text-blue-800" 
                                                                    onclick="window.location.href='<?= BASE_URL ?>/doctor/patientView/?id=<?= $patient->id ?>'"
                                                                    data-patient-id="<?= htmlspecialchars($patient->id) ?>">
                                                                <i class="bx bx-show text-lg"></i>
                                                                <span class="tooltip-text">View Details</span>
                                                            </button>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button class="p-2 text-yellow-600 hover:text-yellow-800" 
                                                                    data-patient-id="<?= htmlspecialchars($patient->id) ?>">
                                                                <i class="bx bx-edit text-lg"></i>
                                                                <span class="tooltip-text">Edit Patient</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No patients found</td>
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[placeholder="Search by patient name or ID..."]');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');

        function filterPatients() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const dateValue = dateFilter.value;

            document.querySelectorAll('.appointments-table tbody tr').forEach(row => {
                if (row.querySelector('td[colspan]')) return;

                const nameCell = row.querySelector('td:first-child');
                const statusCell = row.querySelector('td:nth-child(5)');
                const lastVisitCell = row.querySelector('td:nth-child(6)');

                const name = nameCell.textContent.toLowerCase();
                const patientId = nameCell.querySelector('.text-gray-500').textContent.toLowerCase();
                const status = statusCell.textContent.trim().toLowerCase();
                const lastVisit = lastVisitCell.textContent.trim();

                const matchesSearch = name.includes(searchTerm) || patientId.includes(searchTerm);
                const matchesStatus = !statusValue || status.includes(statusValue);
                const matchesDate = !dateValue || lastVisit.includes(dateValue);

                row.style.display = (matchesSearch && matchesStatus && matchesDate) ? '' : 'none';
            });
        }

        // Add event listeners
        searchInput.addEventListener('input', filterPatients);
        statusFilter.addEventListener('change', filterPatients);
        dateFilter.addEventListener('change', filterPatients);

        // Clear filters function
        window.clearFilters = function() {
            searchInput.value = '';
            statusFilter.value = '';
            dateFilter.value = '';
            filterPatients();
        }

        // Initialize flatpickr
        flatpickr("#dateFilter", {
            dateFormat: "M d, Y",
            onChange: filterPatients
        });
    });
</script>
</html>