<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
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
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Immunization Record</h1>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Patient:</span>
                                        <span class="font-semibold"><?= $patient->first_name . ' ' . $patient->last_name ?></span>
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
                                <a href="<?= BASE_URL ?>/doctor/patientView?id=<?= $patient->id ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-arrow-back mr-1"></i> Back to Patient
                                </a>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-printer mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Immunization Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="bx bx-injection text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Immunizations</p>
                                    <h3 class="text-xl font-bold"><?= $stats['total'] ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="bx bx-calendar-check text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Recent (6 months)</p>
                                    <h3 class="text-xl font-bold"><?= $stats['recent'] ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                    <i class="bx bx-calendar-plus text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Upcoming Due</p>
                                    <h3 class="text-xl font-bold"><?= $stats['upcoming'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Immunization Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Vaccine Information -->
                        <div class="md:col-span-2 bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <h2 class="text-xl font-semibold">Vaccine Information</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Vaccine Name</p>
                                        <p class="font-medium text-lg"><?= htmlspecialchars($currentImmunization->vaccine_name) ?></p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Manufacturer</p>
                                        <p class="font-medium"><?= htmlspecialchars($currentImmunization->manufacturer ?? 'Not specified') ?></p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Lot Number</p>
                                        <p class="font-medium"><?= htmlspecialchars($currentImmunization->lot_number ?? 'Not recorded') ?></p>
                                    </div>
                                </div>
                                <!-- <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Description</p>
                                        <p class="text-sm"><?= htmlspecialchars($currentImmunization->vaccine_description ?? 'No description available') ?></p>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- Administration Details -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <h2 class="text-xl font-semibold">Administration</h2>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Date Administered</p>
                                <p class="font-medium"><?= date('F j, Y', strtotime($currentImmunization->immunization_date)) ?></p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Administered By</p>
                                <p class="font-medium"><?= htmlspecialchars($currentImmunization->administrator ?? 'Not recorded') ?></p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Next Due Date</p>
                                <p class="font-medium">
                                    <?= $currentImmunization->next_due ? date('F j, Y', strtotime($currentImmunization->next_due)) : 'Not scheduled' ?>
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Supervising Doctor</p>
                                <p class="font-medium"><?= htmlspecialchars($currentImmunization->doctor_name ?? 'Not recorded') ?></p>
                                <?php if (!empty($currentImmunization->doctor_specialization)): ?>
                                    <p class="text-xs text-gray-500 capitalize"><?= htmlspecialchars($currentImmunization->doctor_specialization) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <!-- Immunization History -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">

                            <h2 class="text-xl font-semibold">Immunization History</h2>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Administrator</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Due</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($immunizationHistory as $record): ?>
                                        <tr class="<?= $record->id == $currentImmunization->id ? 'bg-blue-50' : '' ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($record->vaccine_name) ?></div>
                                                <?php if (!empty($record->manufacturer)): ?>
                                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($record->manufacturer) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= date('M d, Y', strtotime($record->immunization_date)) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= htmlspecialchars($record->administrator) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= $record->next_due ? date('M Y', strtotime($record->next_due)) : 'N/A' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

</html>