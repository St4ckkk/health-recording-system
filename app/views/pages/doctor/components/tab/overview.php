<!-- components/patient/tab-overview.php -->
<!-- Vital Signs Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Blood Pressure Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Blood Pressure</h4>
        <div class="flex items-center">
            <i class="bx bx-heart text-red-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->blood_pressure) ? $vitals->blood_pressure : '138/88' ?>
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->bp_date) ? $vitals->bp_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>
    
    <!-- Weight Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Weight</h4>
        <div class="flex items-center">
            <i class="bx bx-trending-up text-blue-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($patient->weight) ? $patient->weight : '185' ?> lbs
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->weight_date) ? $vitals->weight_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>
    
    <!-- Blood Glucose Card -->
    <div class="border border-gray-200 rounded-lg p-4">
        <h4 class="text-md font-medium mb-2">Blood Glucose</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-purple-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->blood_glucose) ? $vitals->blood_glucose : '126' ?> mg/dL
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->glucose_date) ? $vitals->glucose_date : date('Y-m-d', strtotime('-3 days')) ?>
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
                        <h4 class="font-medium"><?= htmlspecialchars($visit->visit_type) ?></h4>
                        <p class="text-sm text-gray-500">Dr. <?= htmlspecialchars($visit->doctor_name) ?></p>
                        <?php if (!empty($visit->diagnosis)): ?>
                        <p class="text-sm mt-2"><?= htmlspecialchars($visit->diagnosis) ?></p>
                        <?php endif; ?>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View Details →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime($visit->visit_date)) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Sample data if no visits -->
        <div class="space-y-3">
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium">Annual Physical</h4>
                        <p class="text-sm text-gray-500">Dr. Sarah Johnson</p>
                        <p class="text-sm mt-2">Hypertension, well-controlled</p>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View Details →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime('-15 days')) ?></span>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium">Dental Checkup</h4>
                        <p class="text-sm text-gray-500">Dr. Michael Chen</p>
                        <p class="text-sm mt-2">Mild gingivitis</p>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View Details →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime('-2 months')) ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Recent Lab Results Section -->
<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Recent Lab Results</h3>
    <?php if (!empty($labResults)): ?>
        <div class="space-y-3">
            <?php foreach ($labResults as $lab): ?>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium"><?= htmlspecialchars($lab->test_name) ?></h4>
                        <p class="text-sm text-gray-500">Dr. <?= htmlspecialchars($lab->doctor_name) ?></p>
                        <?php if (!empty($lab->results)): ?>
                            <div class="mt-2 space-y-1">
                                <?php foreach (json_decode($lab->results) as $key => $value): ?>
                                <p class="text-sm"><?= htmlspecialchars($key) ?>: <span class="font-medium"><?= htmlspecialchars($value) ?></span></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View All Results →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime($lab->test_date)) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Sample data if no lab results -->
        <div class="space-y-3">
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium">Comprehensive Metabolic Panel</h4>
                        <p class="text-sm text-gray-500">Dr. Sarah Johnson</p>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm">Glucose: <span class="font-medium">126 mg/dL (H)</span></p>
                            <p class="text-sm">BUN: <span class="font-medium">18 mg/dL</span></p>
                        </div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View All Results →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime('-15 days')) ?></span>
                </div>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium">Lipid Panel</h4>
                        <p class="text-sm text-gray-500">Dr. Sarah Johnson</p>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm">Total Cholesterol: <span class="font-medium">210 mg/dL</span></p>
                            <p class="text-sm">Triglycerides: <span class="font-medium">150 mg/dL</span></p>
                        </div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">View All Results →</a>
                    </div>
                    <span class="text-sm text-gray-500"><?= date('Y-m-d', strtotime('-15 days')) ?></span>
                </div>
            </div>
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
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($med->name) ?></td>
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