<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Blood Pressure Card -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Blood Pressure</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-red-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->blood_pressure) ? $vitals->blood_pressure : '138/88' ?>
            </span>
            <?php
            // Clinical Decision Support for Blood Pressure
            $systolic = explode('/', $vitals->blood_pressure ?? '138/88')[0];
            $diastolic = explode('/', $vitals->blood_pressure ?? '138/88')[1];

            if ($systolic >= 140 || $diastolic >= 90) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">High</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" title="Consider lifestyle modifications and medication review">
                        <i class="bx bx-info-circle"></i>
                      </div>';
            } elseif ($systolic <= 90 || $diastolic <= 60) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Low</span>';
            }
            ?>
        </div>
        <div class="mt-2 text-xs">
            <?php if (isset($vitals->bp_trend)): ?>
                <div class="flex items-center">
                    <?php if ($vitals->bp_trend === 'up'): ?>
                        <i class="bx bx-trending-up text-red-500"></i>
                        <span class="text-red-500 ml-1">Trending up from last visit</span>
                    <?php elseif ($vitals->bp_trend === 'down'): ?>
                        <i class="bx bx-trending-down text-green-500"></i>
                        <span class="text-green-500 ml-1">Improving from last visit</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked: <?= isset($vitals->bp_date) ? $vitals->blood_pressure_date : date('Y-m-d') ?>
        </p>
    </div>

    <!-- Blood Glucose Card with CDS -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Blood Glucose</h4>
        <div class="flex items-center">
            <i class="bx bx-droplet text-purple-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->glucose_level) ? $vitals->glucose_level : '126' ?> mg/dL
            </span>
            <?php
            $glucose = $vitals->glucose_level ?? 126;
            if ($glucose >= 200) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">High Risk</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" 
                     title="Consider HbA1c test and diabetes management plan">
                     <i class="bx bx-info-circle px-1"></i>
                     </div>';
            } elseif ($glucose >= 140) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Pre-diabetic</span>';
            }
            ?>
        </div>
        <?php if (isset($vitals->glucose_trend)): ?>
            <div class="mt-2 text-xs">
                <div class="flex items-center">
                    <?php if ($vitals->glucose_trend === 'up'): ?>
                        <i class="bx bx-trending-up text-red-500"></i>
                        <span class="text-red-500 ml-1">Trending up - Monitor closely</span>
                    <?php elseif ($vitals->glucose_trend === 'down'): ?>
                        <i class="bx bx-trending-down text-green-500"></i>
                        <span class="text-green-500 ml-1">Improving</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->glucose_date) ? $vitals->glucose_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <!-- Heart Rate Card with CDS -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Heart Rate</h4>
        <div class="flex items-center">
            <i class="bx bx-heart text-red-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->heart_rate) ? $vitals->heart_rate : '72' ?> bpm
            </span>
            <?php
            $heartRate = $vitals->heart_rate ?? 72;
            if ($heartRate > 100) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Tachycardia</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" 
                     title="Consider ECG and cardiac evaluation">
                     <i class="bx bx-info-circle"></i>
                     </div>';
            } elseif ($heartRate < 60) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Bradycardia</span>';
            }
            ?>
        </div>
        <?php if (isset($vitals->heart_rate_trend)): ?>
            <div class="mt-2 text-xs">
                <div class="flex items-center">
                    <?php if ($vitals->heart_rate_trend === 'irregular'): ?>
                        <i class="bx bx-error text-yellow-500"></i>
                        <span class="text-yellow-500 ml-1">Irregular pattern detected</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->heart_rate_date) ? $vitals->heart_rate_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <!-- Weight Card with CDS -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Weight</h4>
        <div class="flex items-center">
            <i class="bx bx-trending-up text-blue-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?php
                $weight = floatval($vitals->weight ?? '70');
                echo $weight . 'kg';
                ?>
            </span>
            <?php
            $height = $vitals->height ?? "5'10\"";
            $bmi = calculateBMI($weight, $height);

            if ($bmi >= 30) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Obese</span>';
            } elseif ($bmi >= 25) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Overweight</span>';
            } elseif ($bmi >= 18.5 && $bmi < 25) {
                echo '<span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Normal</span>';
            } elseif ($bmi < 18.5) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Underweight</span>';
            }
            ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">BMI: <?= number_format($bmi, 1) ?></p>
    </div>



    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Height</h4>
        <div class="flex items-center">
            <i class="bx bx-ruler text-green-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->height) ? $vitals->height : "5'10\"" ?>
            </span>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->height_date) ? $vitals->height_date : date('Y-m-d', strtotime('-3 days')) ?>
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
            Last checked:
            <?= isset($vitals->glucose_date) ? $vitals->glucose_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>


    <!-- Temperature Card -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Temperature</h4>
        <div class="flex items-center">
            <i class="bx bx-thermometer text-orange-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->temperature) ? $vitals->temperature : '37.0' ?>°C
            </span>
            <?php
            $temp = $vitals->temperature ?? 37.0;
            if ($temp >= 38.3) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Fever</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" 
                     title="Consider blood cultures and infection workup">
                     <i class="bx bx-info-circle"></i>
                     </div>';
            } elseif ($temp >= 37.8) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Low-grade Fever</span>';
            } elseif ($temp < 36.0) {
                echo '<span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Hypothermia</span>';
            }
            ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->temperature_date) ? $vitals->temperature_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <!-- Respiratory Rate Card -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">Respiratory Rate</h4>
        <div class="flex items-center">
            <i class="bx bx-wind text-blue-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->respiratory_rate) ? $vitals->respiratory_rate : '16' ?> /min
            </span>
            <?php
            $respRate = $vitals->respiratory_rate ?? 16;
            if ($respRate > 24) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Tachypnea</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" 
                     title="Consider blood gas analysis and respiratory assessment">
                     <i class="bx bx-info-circle"></i>
                     </div>';
            } elseif ($respRate < 12) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Bradypnea</span>';
            }
            ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->respiratory_rate_date) ? $vitals->respiratory_rate_date : date('Y-m-d', strtotime('-3 days')) ?>
        </p>
    </div>

    <!-- Oxygen Saturation Card -->
    <div class="border border-gray-200 rounded-lg p-4 relative">
        <h4 class="text-md font-medium mb-2">O2 Saturation</h4>
        <div class="flex items-center">
            <i class="bx bx-water text-cyan-500 mr-2"></i>
            <span class="text-2xl font-bold">
                <?= isset($vitals->oxygen_saturation) ? $vitals->oxygen_saturation : '98' ?>%
            </span>
            <?php
            $o2sat = $vitals->oxygen_saturation ?? 98;
            if ($o2sat < 90) {
                echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Severe</span>';
                echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" 
                     title="Consider immediate oxygen therapy">
                     <i class="bx bx-info-circle"></i>
                     </div>';
            } elseif ($o2sat < 95) {
                echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Low</span>';
            }
            ?>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            Last checked:
            <?= isset($vitals->oxygen_saturation_date) ? $vitals->oxygen_saturation_date : date('Y-m-d', strtotime('-3 days')) ?>
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
                            <h4 class="font-medium capitalize">
                                <?= htmlspecialchars($visit->appointment_type ?? 'Regular Checkup') ?>
                            </h4>
                            <p class="text-sm text-gray-500 capitalize">
                                Dr. <?= htmlspecialchars($visit->doctor_first_name . ' ' . $visit->doctor_last_name) ?>
                                <?php if (!empty($visit->specialization)): ?>
                                    (<?= htmlspecialchars($visit->specialization) ?>)
                                <?php endif; ?>
                            </p>

                            <p class="text-sm">
                                <?php if (!empty($visit->diagnosis)): ?>
                                    <?= htmlspecialchars($visit->diagnosis) ?>
                                <?php endif; ?>
                            </p>

                            <a href="<?= BASE_URL ?>/doctor/appointment/view/<?= $visit->id ?>"
                                class="text-blue-600 text-sm mt-2 inline-block">View Details →</a>
                        </div>
                        <div class="text-right">
                            <span
                                class="text-sm text-gray-500"><?= date('M j, Y', strtotime($visit->appointment_date)) ?></span>
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
                                <p class="text-sm"><span class="font-medium">Result:</span>
                                    <?= htmlspecialchars($lab->result) ?></p>
                                <?php if (!empty($lab->reference_range)): ?>
                                    <p class="text-sm"><span class="font-medium">Reference Range:</span>
                                        <?= htmlspecialchars($lab->reference_range) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($lab->flag)): ?>
                                    <p class="text-sm"><span class="font-medium">Flag:</span>
                                        <span
                                            class="<?= $lab->flag === 'H' ? 'text-red-500' : ($lab->flag === 'L' ? 'text-blue-500' : 'text-gray-500') ?>">
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($medications)): ?>
                    <?php foreach ($medications as $med): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($med->medication_name) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($med->dosage) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($med->frequency) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($med->purpose) ?>
                            </td>
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

<!-- Add Clinical Decision Support Summary -->
<div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200 mt-2">
    <h3 class="text-lg font-medium mb-3 text-blue-800">Clinical Insights</h3>
    <div class="space-y-2">
        <?php
        // Compile clinical insights based on vitals
        $insights = [];

        // Blood Pressure Analysis
        if (isset($vitals->blood_pressure)) {
            $systolic = explode('/', $vitals->blood_pressure)[0];
            $diastolic = explode('/', $vitals->blood_pressure)[1];
            if ($systolic >= 140 || $diastolic >= 90) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'Elevated blood pressure (' . $vitals->blood_pressure . ') - Consider lifestyle modifications, dietary sodium restriction, and medication adjustment',
                    'icon' => 'bx-shield-quarter'
                ];
            } elseif ($systolic <= 90 || $diastolic <= 60) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Low blood pressure - Consider medication review and orthostatic evaluation',
                    'icon' => 'bx-shield-quarter'
                ];
            }
        }

        // Glucose Analysis
        if (isset($vitals->glucose_level)) {
            if ($vitals->glucose_level >= 200) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'High blood glucose (' . $vitals->glucose_level . ' mg/dL) - Consider HbA1c test and diabetes management optimization',
                    'icon' => 'bx-test-tube'
                ];
            } elseif ($vitals->glucose_level >= 140) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'Pre-diabetic range glucose - Consider glucose tolerance test and lifestyle modifications',
                    'icon' => 'bx-test-tube'
                ];
            }
        }

        // Heart Rate Analysis
        if (isset($vitals->heart_rate)) {
            if ($vitals->heart_rate >= 100) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Tachycardia (' . $vitals->heart_rate . ' bpm) - ECG recommended. Evaluate for underlying causes.',
                    'icon' => 'bx-heart'
                ];
            } elseif ($vitals->heart_rate <= 60) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'Bradycardia - Review medications. Consider cardiology referral if symptomatic.',
                    'icon' => 'bx-heart'
                ];
            }
        }

        // Temperature Analysis
        if (isset($vitals->temperature)) {
            if ($vitals->temperature >= 38.3) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'High fever (' . $vitals->temperature . '°C) - Consider blood cultures and broad-spectrum antibiotics if clinically indicated',
                    'icon' => 'bx-thermometer'
                ];
            } elseif ($vitals->temperature <= 36.0) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Hypothermia - Evaluate for underlying causes and consider immediate warming measures',
                    'icon' => 'bx-thermometer'
                ];
            }
        }

        // BMI Analysis
        if (isset($bmi)) {
            if ($bmi >= 30) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'BMI indicates obesity (BMI: ' . number_format($bmi, 1) . ') - Consider referral to nutritionist and weight management program',
                    'icon' => 'bx-line-chart'
                ];
            } elseif ($bmi < 18.5) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'Underweight BMI - Evaluate for underlying conditions and consider nutritional supplementation',
                    'icon' => 'bx-line-chart'
                ];
            }
        }

        // Respiratory Rate Analysis
        if (isset($vitals->respiratory_rate)) {
            if ($vitals->respiratory_rate > 24) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Tachypnea (' . $vitals->respiratory_rate . ' /min) - Consider blood gas analysis and chest imaging',
                    'icon' => 'bx-wind'
                ];
            } elseif ($vitals->respiratory_rate < 12) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Bradypnea - Evaluate respiratory status and medication effects',
                    'icon' => 'bx-wind'
                ];
            }
        }

        // O2 Saturation Analysis
        if (isset($vitals->oxygen_saturation)) {
            if ($vitals->oxygen_saturation < 90) {
                $insights[] = [
                    'type' => 'alert',
                    'message' => 'Severe hypoxemia (SpO2: ' . $vitals->oxygen_saturation . '%) - Immediate oxygen therapy and cardiopulmonary evaluation needed',
                    'icon' => 'bx-water'
                ];
            } elseif ($vitals->oxygen_saturation < 95) {
                $insights[] = [
                    'type' => 'warning',
                    'message' => 'Mild hypoxemia - Monitor closely and consider supplemental oxygen',
                    'icon' => 'bx-water'
                ];
            }
        }

        // Display insights with enhanced styling
        foreach ($insights as $insight): ?>
            <div
                class="flex items-start space-x-3 p-2 <?= $insight['type'] === 'alert' ? 'bg-red-50' : 'bg-yellow-50' ?> rounded">
                <i
                    class="bx <?= $insight['icon'] ?> <?= $insight['type'] === 'warning' ? 'text-yellow-600' : 'text-red-600' ?> text-xl"></i>
                <p class="text-sm <?= $insight['type'] === 'warning' ? 'text-yellow-700' : 'text-red-700' ?>">
                    <?= $insight['message'] ?>
                </p>
            </div>
        <?php endforeach; ?>

        <?php if (empty($insights)): ?>
            <p class="text-sm text-gray-600">All vitals are within normal ranges. Continue current management plan.</p>
        <?php endif; ?>
    </div>
</div>