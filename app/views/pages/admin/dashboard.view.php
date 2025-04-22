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
        <?php include(VIEW_ROOT . '/pages/admin/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/admin/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="image-header">
                        <img src="<?= BASE_URL ?>/images/admin-header.png" class="image-header-bg"
                            alt="Admin Dashboard">
                        <div class="image-header-overlay"></div>
                        <div class="image-header-pattern"></div>
                        <div class="image-header-content">
                            <h1 class="image-header-title">Admin Dashboard</h1>
                            <p class="image-header-subtitle">System-wide overview and management</p>
                        </div>
                    </div>

                    <!-- Staff & Doctor Overview Cards -->
                    <div class="flex gap-4 mb-6 mt-6">
                        <!-- Total Staff Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Staff</p>
                                    <h3 class="text-2xl font-semibold mt-1"><?= number_format($totalStaff ?? 0) ?></h3>
                                    <p class="text-gray-500 text-xs mt-1">Active employees</p>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-full">
                                    <i class='bx bx-user text-2xl text-blue-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a href="<?= BASE_URL ?>/admin/staff" class="text-blue-600 text-xs flex items-center">
                                    <span>Manage staff</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Total Doctors Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Total Doctors</p>
                                    <h3 class="text-2xl font-semibold mt-1"><?= number_format($totalDoctors ?? 0) ?>
                                    </h3>
                                    <p class="text-gray-500 text-xs mt-1">Medical practitioners</p>
                                </div>
                                <div class="bg-green-50 p-3 rounded-full">
                                    <i class='bx bx-plus-medical text-2xl text-green-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a href="<?= BASE_URL ?>/admin/doctors"
                                    class="text-green-600 text-xs flex items-center">
                                    <span>Manage doctors</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Billing Overview Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Billing Overview</p>
                                    <h3 class="text-2xl font-semibold text-purple-600 mt-1">
                                        PHP <?= number_format(($billingStats->total_amount ?? 0), 2) ?>
                                    </h3>
                                    <p class="text-gray-500 text-xs mt-1">
                                        <?= number_format(($billingStats->total_billings ?? 0)) ?> total billings
                                    </p>
                                </div>
                                <div class="bg-purple-50 p-3 rounded-full">
                                    <i class='bx bx-dollar text-2xl text-purple-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a href="<?= BASE_URL ?>/admin/billing"
                                    class="text-purple-600 text-xs flex items-center">
                                    <span>View billing records</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Medical Records Card -->
                        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-500 text-sm">Medical Records</p>
                                    <h3 class="text-2xl font-semibold text-orange-600 mt-1">
                                        <?= number_format(($medicalRecordsStats->total_records ?? 0)) ?>
                                    </h3>
                                    <p class="text-gray-500 text-xs mt-1">
                                        <?= number_format(($medicalRecordsStats->recent_records ?? 0)) ?> new this month
                                    </p>
                                </div>
                                <div class="bg-orange-50 p-3 rounded-full">
                                    <i class='bx bx-file text-2xl text-orange-500'></i>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <a href="<?= BASE_URL ?>/admin/medical-records"
                                    class="text-orange-600 text-xs flex items-center">
                                    <span>View medical records</span>
                                    <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </div>
                    </div>



                    <!-- Recent Activity Sections -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recent Billings -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Recent Billing Records</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Patient</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Service</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($recentBillings) && !empty($recentBillings)): ?>
                                            <?php foreach ($recentBillings as $billing): ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($billing->patient_first_name . ' ' . $billing->patient_last_name) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($billing->service_type) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        PHP <?= number_format($billing->amount, 2) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            <?php
                                                            if ($billing->status === 'paid')
                                                                echo 'bg-green-100 text-green-800';
                                                            elseif ($billing->status === 'pending')
                                                                echo 'bg-yellow-100 text-yellow-800';
                                                            else
                                                                echo 'bg-red-100 text-red-800';
                                                            ?>">
                                                            <?= ucfirst(htmlspecialchars($billing->status)) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    recent billing records</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="<?= BASE_URL ?>/admin/billing"
                                    class="text-blue-600 text-sm hover:underline">View all billing records</a>
                            </div>
                        </div>

                        <!-- Recent Medicine Logs -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Recent Medicine Logs</h2>
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
                                                Staff</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($recentMedicineLogs) && !empty($recentMedicineLogs)): ?>
                                            <?php foreach ($recentMedicineLogs as $log): ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($log->medicine_name) ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            <?php
                                                            if (strpos($log->action_type, 'dispense') !== false)
                                                                echo 'bg-red-100 text-red-800';
                                                            elseif (strpos($log->action_type, 'restock') !== false)
                                                                echo 'bg-green-100 text-green-800';
                                                            elseif (strpos($log->action_type, 'adjust') !== false)
                                                                echo 'bg-yellow-100 text-yellow-800';
                                                            else
                                                                echo 'bg-blue-100 text-blue-800';
                                                            ?>">
                                                            <?= ucfirst(htmlspecialchars($log->action_type)) ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($log->staff_name ?? 'N/A') ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= date('M d, H:i', strtotime($log->timestamp)) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    recent medicine logs</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="<?= BASE_URL ?>/admin/medicine-logs"
                                    class="text-blue-600 text-sm hover:underline">View all medicine logs</a>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Records and System Stats -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Medical Records Summary -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 lg:col-span-2">
                            <h2 class="text-lg font-semibold mb-4">Medical Records Summary</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                                            <i class='bx bx-file text-xl text-blue-600'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Total Records</p>
                                            <p class="text-lg font-semibold">
                                                <?= number_format($medicalRecordsStats->total_records ?? 0) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <i class='bx bx-calendar-check text-xl text-green-600'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">This Month</p>
                                            <p class="text-lg font-semibold">
                                                <?= number_format($medicalRecordsStats->recent_records ?? 0) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 p-2 rounded-full mr-3">
                                            <i class='bx bx-user-plus text-xl text-purple-600'></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">New Patients</p>
                                            <p class="text-lg font-semibold">
                                                <?= number_format($medicalRecordsStats->new_patients ?? 0) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Patient</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Doctor</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Diagnosis</th>
                                            <th
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php if (isset($recentMedicalRecords) && !empty($recentMedicalRecords)): ?>
                                            <?php foreach ($recentMedicalRecords as $record): ?>
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                                        <?= htmlspecialchars($record->patient_name ?? 'N/A') ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($record->doctor_name ?? 'N/A') ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= htmlspecialchars($record->diagnosis ?? 'N/A') ?>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        <?= date('M d, Y', strtotime($record->created_at)) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">No
                                                    recent medical records</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="<?= BASE_URL ?>/admin/medical-records"
                                    class="text-blue-600 text-sm hover:underline">View all medical records</a>
                            </div>
                        </div>

                        <!-- System Stats -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">System Statistics</h2>
                            <div class="space-y-4">
                                <div class="border-b border-gray-100 pb-4">
                                    <p class="text-sm text-gray-500 mb-1">Total Users</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-semibold">
                                            <?= number_format(($totalStaff ?? 0) + ($totalDoctors ?? 0)) ?>
                                        </p>
                                        <span
                                            class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">Active</span>
                                    </div>
                                </div>
                                <div class="border-b border-gray-100 pb-4">
                                    <p class="text-sm text-gray-500 mb-1">Total Transactions</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-semibold">
                                            <?= number_format($transactionStats->total_transactions ?? 0) ?>
                                        </p>
                                        <span class="text-xs text-blue-600">PHP
                                            <?= number_format($transactionStats->total_amount ?? 0, 2) ?></span>
                                    </div>
                                </div>
                                <div class="border-b border-gray-100 pb-4">
                                    <p class="text-sm text-gray-500 mb-1">Pending Payments</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-semibold">
                                            <?= number_format($billingStats->pending_count ?? 0) ?>
                                        </p>
                                        <span class="text-xs text-yellow-600">PHP
                                            <?= number_format($billingStats->pending_amount ?? 0, 2) ?></span>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">System Uptime</p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-semibold">99.9%</p>
                                        <span class="text-xs text-green-600">Operational</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="<?= BASE_URL ?>/admin/reports"
                                    class="block w-full bg-blue-600 text-white text-center py-2 rounded-md hover:bg-blue-700 transition-colors">
                                    Generate System Report
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Staff Role Distribution Chart
            const staffRoleCtx = document.getElementById('staffRoleChart').getContext('2d');
            const staffRoleChart = new Chart(staffRoleCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($staffRoleData['labels'] ?? []) ?>,
                    datasets: [{
                        data: <?= json_encode($staffRoleData['counts'] ?? []) ?>,
                        backgroundColor: <?= json_encode($staffRoleData['colors'] ?? []) ?>,
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

            // Doctor Specialization Chart
            const doctorSpecializationCtx = document.getElementById('doctorSpecializationChart').getContext('2d');
            const doctorSpecializationChart = new Chart(doctorSpecializationCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($doctorSpecializationData['labels'] ?? []) ?>,
                    datasets: [{
                        data: <?= json_encode($doctorSpecializationData['counts'] ?? []) ?>,
                        backgroundColor: <?= json_encode($doctorSpecializationData['colors'] ?? []) ?>,
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