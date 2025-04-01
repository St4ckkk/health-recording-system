<!-- components/patient/tab-overview.php -->
<!-- Vital Signs Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Blood Pressure Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Blood Pressure</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-red-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->blood_pressure) ? $vitals->blood_pressure : '138/88' ?>
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->bp_date) ? $vitals->blood_pressure_date : date('Y-m-d') ?>
        </p>
    </div>
    
    <!-- Weight Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Weight</h4>
        <div class="flex items-center">
            <i class="bx bx-trending-up text-blue-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->weight) ? $vitals->weight : '185' ?> lbs
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->weight_date) ? $vitals->weight_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>
    
    <!-- Blood Glucose Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Height</h4>
        <div class="flex items-center">
            <i class="bx bx-ruler text-green-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->height) ? $vitals->height : "5'10\"" ?>
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->height_date) ? $vitals->height_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Blood Glucose</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-purple-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->glucose_level) ? $vitals->glucose_level : '126' ?> mg/dL
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->glucose_date) ? $vitals->glucose_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Heart Rate</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-purple-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->heart_rate) ? $vitals->heart_rate : '126' ?> mg/dL
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->glucose_date) ? $vitals->glucose_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <!-- Temperature Card -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-md font-medium mb-2">Temperature</h4>
            <div class="flex items-center">
                <i class="bx bx-thermometer text-orange-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?= isset($vitals->temperature) ? $vitals->temperature : '37.0' ?>°C
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                Last checked: <?= isset($vitals->temperature_date) ? $vitals->temperature_date : date('Y-m-d', strtotime('-3 days')) ?>
            </p>
        </div>
    
        <!-- Respiratory Rate Card -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-md font-medium mb-2">Respiratory Rate</h4>
            <div class="flex items-center">
                <i class="bx bx-wind text-blue-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?= isset($vitals->respiratory_rate) ? $vitals->respiratory_rate : '16' ?> /min
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                Last checked: <?= isset($vitals->respiratory_rate_date) ? $vitals->respiratory_rate_date : date('Y-m-d', strtotime('-3 days')) ?>
            </p>
        </div>
    
        <!-- Oxygen Saturation Card -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-md font-medium mb-2">O2 Saturation</h4>
            <div class="flex items-center">
                <i class="bx bx-water text-cyan-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?= isset($vitals->oxygen_saturation) ? $vitals->oxygen_saturation : '98' ?>%
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                Last checked: <?= isset($vitals->oxygen_saturation_date) ? $vitals->oxygen_saturation_date : date('Y-m-d', strtotime('-3 days')) ?>
            </p>
        </div>
</div>

<!-- Recent Visits Section -->
<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Recent Visits</h3>
    <?php if (!empty($recentVisits)): ?>
        <div class="space-y-3">
            <?php foreach ($recentVisits as $visit): ?>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium capitalize"><?= htmlspecialchars($visit->appointment_type ?? 'Regular Checkup') ?></h4>
                        <p class="text-sm text-gray-500 capitalize">
                            Dr. <?= htmlspecialchars($visit->doctor_first_name . ' ' . $visit->doctor_last_name) ?>
                            <?php if (!empty($visit->specialization)): ?>
                                (<?= htmlspecialchars($visit->specialization) ?>)
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($visit->reason)): ?>
                            <p class="text-sm mt-2 capitalize"><?= htmlspecialchars($visit->reason) ?></p>
                        <?php endif; ?>
                        <?php if ($visit->previous_doctor_first_name): ?>
                            <p class="text-sm text-gray-500 mt-1">
                                Previous Visit: Dr. <?= htmlspecialchars($visit->previous_doctor_first_name . ' ' . $visit->previous_doctor_last_name) ?>
                                (<?= htmlspecialchars($visit->previous_doctor_specialization) ?>)
                            </p>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/doctor/appointment/view/<?= $visit->id ?>" 
                           class="text-blue-600 text-sm mt-2 inline-block">View Details →</a>
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-500"><?= date('M j, Y', strtotime($visit->appointment_date)) ?></span>
                        <?php if ($visit->last_visit): ?>
                            <p class="text-xs text-gray-400 mt-1">
                                Last Visit: <?= date('M j, Y', strtotime($visit->last_visit)) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-gray-500 py-4">
            No recent visits found.
        </div>
    <?php endif; ?>
</div>

<!-- Recent Lab Results Section -->
<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Recent Lab Results</h3>
    <?php if (!empty($labResults)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($labResults as $lab): ?>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex flex-col h-full">
                    <div>
                        <h4 class="font-medium"><?= htmlspecialchars($lab->test_name) ?></h4>
                        <p class="text-sm text-gray-500 capitalize">
                            Dr. <?= htmlspecialchars($lab->doctor_first_name . ' ' . $lab->doctor_last_name) ?>
                            <?php if (!empty($lab->doctor_specialization)): ?>
                                (<?= htmlspecialchars($lab->doctor_specialization) ?>)
                            <?php endif; ?>
                        </p>
                        <div class="mt-2">
                            <p class="text-sm"><span class="font-medium">Result:</span> <?= htmlspecialchars($lab->result) ?></p>
                            <?php if (!empty($lab->reference_range)): ?>
                                <p class="text-sm"><span class="font-medium">Reference Range:</span> <?= htmlspecialchars($lab->reference_range) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($lab->flag)): ?>
                                <p class="text-sm"><span class="font-medium">Flag:</span> 
                                    <span class="<?= $lab->flag === 'H' ? 'text-red-500' : ($lab->flag === 'L' ? 'text-blue-500' : 'text-gray-500') ?>">
                                        <?= htmlspecialchars($lab->flag) ?>
                                    </span>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($lab->notes)): ?>
                            <p class="text-sm mt-2 text-gray-600"><?= htmlspecialchars($lab->notes) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2 pt-3 flex justify-between items-center">
                        <a href="<?= BASE_URL ?>/doctor/lab-results/view/<?= $lab->id ?>" 
                           class="text-blue-600 text-sm inline-block">View Details →</a>
                        <span class="text-sm text-gray-500"><?= date('M j, Y', strtotime($lab->test_date)) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-gray-500 py-4">
            No lab results found.
        </div>
    <?php endif; ?>
</div>

<!-- Current Medications Section -->
<div>
    <h3 class="text-lg font-medium mb-4">Current Medications</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($medications)): ?>
                    <?php foreach ($medications as $med): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($med->medication_name) ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($med->dosage) ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($med->frequency) ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($med->purpose) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Sample data if no medications -->
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Lisinopril</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">10mg</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Hypertension management</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Metformin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">500mg</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Twice daily</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Diabetes management</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Atorvastatin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">20mg</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily at bedtime</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Cholesterol management</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Aspirin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">81mg</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Cardiovascular protection</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="#" class="text-blue-600 text-sm inline-block">View All Medications →</a>
    </div>
</div>