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

<body class="font-body bg-gray-50">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Patient Info Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Treatment Records</h1>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Patient:</span>
                                        <span
                                            class="font-semibold"><?= $patient->first_name . ' ' . $patient->last_name ?></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">PAT ID:</span>
                                        <span class="font-semibold"><?= $patient->patient_reference_number ?></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Age:</span>
                                        <span class="font-semibold"><?= $patient->age ?? 'N/A' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-plus mr-1"></i> New Treatment
                                </button>
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-printer mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Treatments</p>
                                    <h3 class="text-2xl font-bold"><?= $stats['total'] ?></h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="bx bx-clipboard text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Active Treatments</p>
                                    <h3 class="text-2xl font-bold"><?= $stats['active'] ?></h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="bx bx-pulse text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Completed</p>
                                    <h3 class="text-2xl font-bold"><?= $stats['completed'] ?></h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">
                                    <i class="bx bx-check-circle text-teal-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Good Adherence</p>
                                    <h3 class="text-2xl font-bold"><?= $stats['goodAdherence'] ?></h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="bx bx-trending-up text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Treatment Details -->
                    <?php if ($currentTreatment): ?>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                            <h2 class="text-lg font-semibold mb-4">Treatment Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Treatment Info -->
                                <div class="md:col-span-2">
                                    <div class="border-b pb-4 mb-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-medium text-gray-900">
                                                    <?= htmlspecialchars($currentTreatment->treatment_type) ?>
                                                </h3>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Started: <?= date('M d, Y', strtotime($currentTreatment->start_date)) ?>
                                                    <?php
                                                    $daysDiff = floor((time() - strtotime($currentTreatment->start_date)) / (60 * 60 * 24));
                                                    if ($daysDiff < 0) {
                                                        echo "(Starts in " . abs($daysDiff) . " days)";
                                                    } else {
                                                        echo "(" . $daysDiff . " days ago)";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Regimen</h4>
                                            <p class="mt-1"><?= htmlspecialchars($currentTreatment->regimen_summary) ?></p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                                            <p class="mt-1">
                                                <?php
                                                if ($currentTreatment->end_date) {
                                                    $duration = ceil((strtotime($currentTreatment->end_date) - strtotime($currentTreatment->start_date)) / (60 * 60 * 24 * 30));
                                                    echo $duration . ' months (' . date('M d, Y', strtotime($currentTreatment->start_date)) . ' - ' . date('M d, Y', strtotime($currentTreatment->end_date)) . ')';
                                                } else {
                                                    echo 'Ongoing since ' . date('M d, Y', strtotime($currentTreatment->start_date));
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Prescribed By</h4>
                                            <p class="mt-1">Dr.
                                                <?= $currentTreatment->doctor_first_name . ' ' . $currentTreatment->doctor_last_name ?>
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Diagnosis</h4>
                                            <p class="mt-1"><?= htmlspecialchars($currentTreatment->diagnosis_id) ?></p>
                                            <p class="mt-1"><?= $currentTreatment->outcome ?: 'Ongoing Treatment' ?></p>
                                            <div class="flex space-x-3 mt-2">
                                                <button id="updateTreatment"
                                                    class="text-sm text-blue-600 hover:text-blue-800">
                                                    <i class="bx bx-edit"></i> Update Treatment
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Follow-up Notes</h4>
                                        <p class="text-sm text-gray-700">
                                            <?= htmlspecialchars($currentTreatment->follow_up_notes ?: 'No follow-up notes available.') ?>
                                        </p>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-2">Adherence Tracking</h4>
                                        <?php
                                        $adherencePercentage = 0;
                                        if ($currentTreatment->adherence_status === 'good') {
                                            $adherencePercentage = 95;
                                        } elseif ($currentTreatment->adherence_status === 'irregular') {
                                            $adherencePercentage = 60;
                                        } elseif ($currentTreatment->adherence_status === 'poor') {
                                            $adherencePercentage = 30;
                                        }
                                        ?>
                                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-<?= $adherencePercentage > 80 ? 'green' : ($adherencePercentage > 50 ? 'yellow' : 'red') ?>-500 rounded-full"
                                                style="width: <?= $adherencePercentage ?>%"></div>
                                        </div>
                                        <div class="flex justify-between mt-1 text-xs text-gray-500">
                                            <span>Poor</span>
                                            <span>Adherence: <?= $currentTreatment->adherence_status ?></span>
                                            <span>100%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Side Actions -->

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Treatment Timeline and Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Treatment Timeline -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 lg:col-span-1 fade-in">
                            <h2 class="text-lg font-semibold mb-4">Treatment Timeline</h2>
                            <div class="relative">
                                <div class="absolute h-full w-0.5 bg-gray-200 left-2.5 top-0"></div>

                                <?php foreach (array_slice($treatmentRecords, 0, 5) as $index => $record): ?>
                                    <div class="mb-6 relative">
                                        <div class="flex items-start">
                                            <div
                                                class="h-5 w-5 rounded-full bg-<?= $record->status === 'active' ? 'green' : ($record->status === 'completed' ? 'blue' : 'gray') ?>-500 z-10 mt-1.5">
                                            </div>
                                            <div class="ml-4">
                                                <div class="flex items-center">
                                                    <h3 class="font-medium"><?= htmlspecialchars($record->treatment_type) ?>
                                                    </h3>
                                                    <span
                                                        class="ml-2 px-2 py-0.5 bg-<?= $record->status === 'active' ? 'green' : ($record->status === 'completed' ? 'blue' : ($record->status === 'discontinued' ? 'red' : 'gray')) ?>-100 text-<?= $record->status === 'active' ? 'green' : ($record->status === 'completed' ? 'blue' : ($record->status === 'discontinued' ? 'red' : 'gray')) ?>-800 text-xs rounded-full"><?= htmlspecialchars($record->status) ?></span>
                                                </div>
                                                <p class="text-sm text-gray-500">
                                                    <?= date('M d, Y', strtotime($record->start_date)) ?>
                                                    <?= $record->end_date ? '- ' . date('M d, Y', strtotime($record->end_date)) : '' ?>
                                                </p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    <?= htmlspecialchars($record->regimen_summary) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (count($treatmentRecords) === 0): ?>
                                    <div class="text-center py-4 text-gray-500">
                                        No treatment records found.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if (count($treatmentRecords) > 5): ?>
                                <div class="mt-4 text-center">
                                    <button class="text-blue-600 text-sm hover:underline">View All History</button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Charts Section -->
                        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Adherence Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Adherence Status</h2>
                                <div class="h-64">
                                    <canvas id="adherenceChart"></canvas>
                                </div>
                            </div>

                            <!-- Treatment Types Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Types</h2>
                                <div class="h-64">
                                    <canvas id="treatmentTypesChart"></canvas>
                                </div>
                            </div>

                            <!-- Outcomes Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Outcomes</h2>
                                <div class="h-64">
                                    <canvas id="outcomesChart"></canvas>
                                </div>
                            </div>

                            <!-- Status Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Status</h2>
                                <div class="h-64">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Records Table -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Treatment Records</h2>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <input type="text" placeholder="Search records..."
                                        class="pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <i class="bx bx-search absolute left-2.5 top-2.5 text-gray-400"></i>
                                </div>
                                <select
                                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="discontinued">Discontinued</option>
                                </select>
                                <button
                                    class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-filter mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead style="background-color: rgba(22, 163, 74);">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Treatment Type</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Regimen</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Start Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            End Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Adherence</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Outcome</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (count($treatmentRecords) > 0): ?>
                                        <?php foreach ($treatmentRecords as $record): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($record->treatment_type) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($record->regimen_summary) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= date('M d, Y', strtotime($record->start_date)) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= $record->end_date ? date('M d, Y', strtotime($record->end_date)) : 'Ongoing' ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $record->adherence_status === 'good' ? 'green' : ($record->adherence_status === 'irregular' ? 'yellow' : 'red') ?>-100 text-<?= $record->adherence_status === 'good' ? 'green' : ($record->adherence_status === 'irregular' ? 'yellow' : 'red') ?>-800"><?= htmlspecialchars($record->adherence_status) ?></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($record->outcome) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?= $record->status === 'active' ? 'green' : ($record->status === 'completed' ? 'blue' : ($record->status === 'discontinued' ? 'red' : 'gray')) ?>-100 text-<?= $record->status === 'active' ? 'green' : ($record->status === 'completed' ? 'blue' : ($record->status === 'discontinued' ? 'red' : 'gray')) ?>-800"><?= htmlspecialchars($record->status) ?></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="flex space-x-2">
                                                        <button class="text-blue-600 hover:text-blue-900"
                                                            title="Edit Treatment">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="text-gray-600 hover:text-gray-900" title="View Details">
                                                            <i class="bx bx-detail"></i>
                                                        </button>
                                                        <button class="text-red-600 hover:text-red-900"
                                                            title="Delete Treatment">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">No treatment records
                                                found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span
                                    class="font-medium"><?= count($treatmentRecords) ?></span> of <span
                                    class="font-medium"><?= count($treatmentRecords) ?></span> results
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-500 hover:bg-gray-50">Previous</button>
                                <button
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-blue-600 text-white hover:bg-blue-700">1</button>
                                <button
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>


                </section>
            </div>
        </main>
    </div>

    <?php include(VIEW_ROOT . '/pages/doctor/components/modals/update-treatment.php') ?>
    <script src="<?= BASE_URL ?>/js/doctor/update-treatment.js"></script>
    <script>
        // Adherence Chart
        const adherenceCtx = document.getElementById('adherenceChart').getContext('2d');
        const adherenceChart = new Chart(adherenceCtx, {
            type: 'pie',
            data: {
                labels: ['Good', 'Irregular', 'Poor'],
                datasets: [{
                    data: [
                        <?php
                        $goodCount = 0;
                        $irregularCount = 0;
                        $poorCount = 0;

                        foreach ($treatmentRecords as $record) {
                            if ($record->adherence_status === 'good')
                                $goodCount++;
                            else if ($record->adherence_status === 'irregular')
                                $irregularCount++;
                            else if ($record->adherence_status === 'poor')
                                $poorCount++;
                        }

                        echo $goodCount . ', ' . $irregularCount . ', ' . $poorCount;
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for Good
                        'rgba(245, 158, 11, 0.8)',  // Yellow for Irregular
                        'rgba(239, 68, 68, 0.8)'    // Red for Poor
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Treatment Types Chart
        const typesCtx = document.getElementById('treatmentTypesChart').getContext('2d');
        const treatmentTypesChart = new Chart(typesCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    <?php
                    $treatmentTypes = [];
                    $typeCounts = [];

                    foreach ($treatmentRecords as $record) {
                        if (!in_array($record->treatment_type, $treatmentTypes)) {
                            $treatmentTypes[] = $record->treatment_type;
                            $typeCounts[] = 1;
                        } else {
                            $index = array_search($record->treatment_type, $treatmentTypes);
                            $typeCounts[$index]++;
                        }
                    }

                    echo "'" . implode("', '", $treatmentTypes) . "'";
                    ?>
                ],
                datasets: [{
                    data: [<?= implode(', ', $typeCounts) ?>],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(156, 163, 175, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(249, 115, 22, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Outcomes Chart
        const outcomesCtx = document.getElementById('outcomesChart').getContext('2d');
        const outcomesChart = new Chart(outcomesCtx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    $outcomes = [];
                    $outcomeCounts = [];

                    foreach ($treatmentRecords as $record) {
                        $outcome = $record->outcome ?: 'ongoing';
                        if (!in_array($outcome, $outcomes)) {
                            $outcomes[] = $outcome;
                            $outcomeCounts[] = 1;
                        } else {
                            $index = array_search($outcome, $outcomes);
                            $outcomeCounts[$index]++;
                        }
                    }

                    echo "'" . implode("', '", $outcomes) . "'";
                    ?>
                ],
                datasets: [{
                    label: 'Treatment Outcomes',
                    data: [<?= implode(', ', $outcomeCounts) ?>],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',  // Blue for Ongoing
                        'rgba(16, 185, 129, 0.8)',  // Green for Cured
                        'rgba(79, 70, 229, 0.8)',   // Indigo for Completed
                        'rgba(239, 68, 68, 0.8)',   // Red for Failed
                        'rgba(245, 158, 11, 0.8)',  // Yellow for Lost to follow-up
                        'rgba(107, 114, 128, 0.8)'  // Gray for Died
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: [
                    <?php
                    $statuses = [];
                    $statusCounts = [];

                    foreach ($treatmentRecords as $record) {
                        if (!in_array($record->status, $statuses)) {
                            $statuses[] = $record->status;
                            $statusCounts[] = 1;
                        } else {
                            $index = array_search($record->status, $statuses);
                            $statusCounts[$index]++;
                        }
                    }

                    echo "'" . implode("', '", $statuses) . "'";
                    ?>
                ],
                datasets: [{
                    data: [<?= implode(', ', $statusCounts) ?>],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for Active
                        'rgba(79, 70, 229, 0.8)',   // Indigo for Completed
                        'rgba(239, 68, 68, 0.8)'    // Red for Discontinued
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>

</html>