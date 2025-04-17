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
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Medication Prescription Record</h1>
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

                    <!-- Prescription Header -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold mb-2">Prescription #<?= htmlspecialchars($prescription->prescription_code) ?></h2>
                                <p class="text-gray-500">Issued: <?= date('F j, Y', strtotime($prescription->created_at)) ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold mb-1">Dr. <?= htmlspecialchars($prescription->doctor_first_name . ' ' . $prescription->doctor_last_name) ?></p>
                                <p class="text-gray-500"><?= htmlspecialchars($prescription->doctor_specialization) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="bx bx-capsule text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Medications</p>
                                    <h3 class="text-xl font-bold"><?= $stats['medications'] ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                    <i class="bx bx-file-blank text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Prescriptions</p>
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
                                    <p class="text-sm text-gray-500">Recent (30 days)</p>
                                    <h3 class="text-xl font-bold"><?= $stats['recent'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vitals and Diagnosis -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Vitals -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <h2 class="text-xl font-semibold">Vitals at Time of Prescription</h2>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <?php if (!empty($prescription->temperature)): ?>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-500 mb-1">Temperature</p>
                                    <p class="font-medium"><?= htmlspecialchars($prescription->temperature) ?> °C</p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($prescription->blood_pressure)): ?>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-500 mb-1">Blood Pressure</p>
                                    <p class="font-medium"><?= htmlspecialchars($prescription->blood_pressure) ?> mmHg</p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($prescription->heart_rate)): ?>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-500 mb-1">Heart Rate</p>
                                    <p class="font-medium"><?= htmlspecialchars($prescription->heart_rate) ?> bpm</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Diagnosis -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <h2 class="text-xl font-semibold">Diagnosis</h2>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-md">
                                <?php if (!empty($prescription->diagnosis)): ?>
                                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($prescription->diagnosis)) ?></p>
                                <?php else: ?>
                                    <p class="text-gray-500 italic">No diagnosis recorded</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Medications -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-3">
                                <i class="bx bx-capsule text-xl"></i>
                            </div>
                            <h2 class="text-xl font-semibold">Prescribed Medications</h2>
                        </div>
                        
                        <?php if (!empty($medications)): ?>
                            <div class="space-y-4">
                                <?php foreach ($medications as $index => $medication): ?>
                                    <div class="bg-gray-50 p-4 rounded-md border-l-4 border-blue-500">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-semibold text-lg"><?= htmlspecialchars($medication->medicine_name) ?></h3>
                                                <p class="text-gray-600 mt-1"><?= htmlspecialchars($medication->dosage) ?></p>
                                            </div>
                                            <div class="bg-white px-3 py-1 rounded-full text-sm text-gray-600 border border-gray-200">
                                                <?= htmlspecialchars($medication->duration) ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($medication->special_instructions)): ?>
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <p class="text-sm text-gray-500 mb-1">Special Instructions:</p>
                                                <p class="text-gray-700"><?= nl2br(htmlspecialchars($medication->special_instructions)) ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-gray-500">No medications found in this prescription.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Additional Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Advice -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-3">
                                    <i class="bx bx-message-square-detail text-xl"></i>
                                </div>
                                <h2 class="text-xl font-semibold">Doctor's Advice</h2>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-md">
                                <?php if (!empty($prescription->advice)): ?>
                                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($prescription->advice)) ?></p>
                                <?php else: ?>
                                    <p class="text-gray-500 italic">No specific advice provided</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Follow-up -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-3">
                                    <i class="bx bx-calendar-plus text-xl"></i>
                                </div>
                                <h2 class="text-xl font-semibold">Follow-up Information</h2>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-md">
                                <?php if (!empty($prescription->follow_up_date)): ?>
                                    <div class="flex items-center">
                                        <i class="bx bx-calendar text-indigo-500 mr-2"></i>
                                        <div>
                                            <p class="text-sm text-gray-500">Follow-up Date</p>
                                            <p class="font-medium"><?= date('F j, Y', strtotime($prescription->follow_up_date)) ?></p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-gray-500 italic">No follow-up scheduled</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription History -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-3">
                                <i class="bx bx-history text-xl"></i>
                            </div>
                            <h2 class="text-xl font-semibold">Prescription History</h2>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prescription #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($prescriptionHistory as $record): ?>
                                        <tr class="<?= $record->id == $prescription->id ? 'bg-blue-50' : '' ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($record->prescription_code) ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= date('M d, Y', strtotime($record->created_at)) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Dr. <?= htmlspecialchars($record->doctor_first_name . ' ' . $record->doctor_last_name) ?></div>
                                                <div class="text-xs text-gray-500"><?= htmlspecialchars($record->doctor_specialization) ?></div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                <?= htmlspecialchars(substr($record->diagnosis, 0, 50)) ?>
                                                <?= strlen($record->diagnosis) > 50 ? '...' : '' ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?php if ($record->id != $prescription->id): ?>
                                                <a href="<?= BASE_URL ?>/doctor/prescription/view?id=<?= $record->id ?>" class="text-blue-600 hover:text-blue-900">
                                                    View Details
                                                </a>
                                                <?php else: ?>
                                                <span class="text-gray-400">Current</span>
                                                <?php endif; ?>
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