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

        .action-buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.15rem 0.5rem;
            border-radius: 0.375rem;
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

        .action-button.view {
            background-color: transparent;
            color: var(--info-dark);
            border: 1px solid var(--info);
        }

        .action-button.view:hover {
            background-color: var(--info-light);
        }

        .action-button.edit {
            background-color: transparent;
            color: var(--warning-dark);
            border: 1px solid var(--warning);
        }

        .action-button.edit:hover {
            background-color: var(--warning-light);
        }

        .action-button.delete {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger-dark);
        }

        .action-button.delete:hover {
            background-color: var(--danger-lighter);
        }

        /* Admin theme colors */
        .admin-primary {
            background-color: #4f46e5;
            color: white;
        }

        .admin-primary:hover {
            background-color: #4338ca;
        }

        .admin-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .admin-secondary:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/admin/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/admin/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Staff Management</h2>
                            <p class="text-sm text-gray-500">
                                Manage staff members and their roles.
                            </p>
                        </div>
                        <button
                            class="add-staff-btn px-4 py-2 admin-primary rounded-md text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                            <i class='bx bx-plus mr-1'></i> Add New Staff
                        </button>
                    </div>

                    <!-- Staff Table -->
                    <div class="card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="p-4">
                            <table class="appointments-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($staffList)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No staff members found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($staffList as $staff): ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($staff->first_name . ' ' . $staff->last_name) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="status-badge border border-indigo-500 text-indigo-800">
                                                        <?= htmlspecialchars($staff->role_name ?? 'Unknown') ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($staff->email) ?></td>
                                                <td class="py-3 px-4"><?= htmlspecialchars($staff->phone ?? 'N/A') ?></td>
                                                <td class="py-3 px-4">
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <button class="p-2 text-blue-600 hover:text-blue-800"
                                                                onclick="viewStaff(<?= $staff->id ?>)">
                                                                <i class="bx bx-show text-lg"></i>
                                                                <span class="tooltip-text">View Details</span>
                                                            </button>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button class="p-2 text-yellow-600 hover:text-yellow-800"
                                                                onclick="editStaff(<?= $staff->id ?>)">
                                                                <i class="bx bx-edit text-lg"></i>
                                                                <span class="tooltip-text">Edit Staff</span>
                                                            </button>
                                                        </div>
                                                        <div class="tooltip">
                                                            <button class="p-2 text-red-600 hover:text-red-800"
                                                                onclick="deleteStaff(<?= $staff->id ?>, '<?= htmlspecialchars($staff->first_name . ' ' . $staff->last_name) ?>')">
                                                                <i class="bx bx-trash text-lg"></i>
                                                                <span class="tooltip-text">Delete Staff</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Add Staff Modal -->
    <?php include(VIEW_ROOT . '/pages/admin/components/modals/add-staff.php') ?>
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= BASE_URL ?>/js/admin/addStaff.js"></script>
</body>

</html>

<style>
    .appointments-table thead th {
        background-color: rgb(37 99 235);
        /* Changed from rgba(22, 163, 74) to match admin theme */
        color: white;
        font-weight: 500;
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .appointments-table tbody td {
        vertical-align: middle;
    }

    .card {
        transition: all 0.3s ease;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>