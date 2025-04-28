<div class="overview-container">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Blood Pressure Card -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Blood Pressure</h4>
            <div class="flex items-center">
                <i class="bx bx-droplet text-red-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->blood_pressure)): ?>
                        <?= $vitals->blood_pressure ?>
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>

                <?php if (isset($vitals->blood_pressure)): ?>
                    <?php
                    $bp = $vitals->blood_pressure;
                    $systolic = explode('/', $bp)[0];
                    $diastolic = explode('/', $bp)[1];
                    $bpCategory = getBPCategory($systolic, $diastolic);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $bpCategory['class'] . '-100 text-' . $bpCategory['class'] . '-700 text-xs rounded-full">' . $bpCategory['category'] . '</span>';

                    if ($bpCategory['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $bpCategory['class'] . '-500 cursor-help" title="' . $bpCategory['advice'] . '">
                            <i class="bx bx-info-circle"></i>
                        </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
            <?php if (isset($vitals->bp_trend)): ?>
                <div class="mt-2 text-xs">
                    <div class="flex items-center">
                        <?php if ($vitals->bp_trend === 'up'): ?>
                            <i class="bx bx-trending-up text-red-500"></i>
                            <span class="text-red-500 ml-1">Trending up from last visit</span>
                        <?php elseif ($vitals->bp_trend === 'down'): ?>
                            <i class="bx bx-trending-down text-green-500"></i>
                            <span class="text-green-500 ml-1">Improving from last visit</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <p class="text-xs text-gray-500 mt-2">
                Last checked: <?= isset($vitals->bp_date) ? $vitals->blood_pressure_date : 'No record' ?>
            </p>
        </div>

        <!-- Blood Glucose Card with CDS -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Blood Glucose</h4>
            <div class="flex items-center">
                <i class="bx bx-droplet text-purple-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->glucose_level)): ?>
                        <?= $vitals->glucose_level ?> mg/dL
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->glucose_level)): ?>
                    <?php
                    $glucose = $vitals->glucose_level;
                    $isFasting = $vitals->glucose_fasting ?? true;
                    $glucoseCategory = getGlucoseCategory($glucose, $isFasting);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $glucoseCategory['class'] . '-100 text-' . $glucoseCategory['class'] . '-700 text-xs rounded-full">' . $glucoseCategory['category'] . '</span>';

                    if ($glucoseCategory['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $glucoseCategory['class'] . '-500 cursor-help" title="' . $glucoseCategory['advice'] . '">
                         <i class="bx bx-info-circle px-1"></i>
                         </div>';
                    }
                    ?>
                <?php endif; ?>
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
                <?= isset($vitals->glucose_fasting) && $vitals->glucose_fasting ? '<span class="text-blue-500 font-medium">Fasting</span> • ' : '' ?>
                Last checked:
                <?= isset($vitals->glucose_date) ? $vitals->glucose_date : 'No record' ?>
            </p>
        </div>

        <!-- Heart Rate Card with CDS -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Heart Rate</h4>
            <div class="flex items-center">
                <i class="bx bx-heart text-red-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->heart_rate)): ?>
                        <?= $vitals->heart_rate ?> bpm
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->heart_rate)): ?>
                    <?php
                    $heartRate = $vitals->heart_rate;
                    $patientAge = $patient->age ?? 50;
                    $hrCategory = getHeartRateCategory($heartRate, $patientAge);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $hrCategory['class'] . '-100 text-' . $hrCategory['class'] . '-700 text-xs rounded-full">' . $hrCategory['category'] . '</span>';

                    if ($hrCategory['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $hrCategory['class'] . '-500 cursor-help" title="' . $hrCategory['advice'] . '">
                         <i class="bx bx-info-circle"></i>
                         </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
            <?php if (isset($vitals->heart_rate_trend) || isset($vitals->heart_rhythm)): ?>
                <div class="mt-2 text-xs">
                    <?php if (isset($vitals->heart_rate_trend)): ?>
                        <div class="flex items-center">
                            <?php if ($vitals->heart_rate_trend === 'up'): ?>
                                <i class="bx bx-trending-up text-red-500"></i>
                                <span class="text-red-500 ml-1">Trending up - Monitor closely</span>
                            <?php elseif ($vitals->heart_rate_trend === 'down'): ?>
                                <i class="bx bx-trending-down text-green-500"></i>
                                <span class="text-green-500 ml-1">Trending down</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($vitals->heart_rhythm) && $vitals->heart_rhythm === 'irregular'): ?>
                        <div class="flex items-center mt-1">
                            <i class="bx bx-error text-yellow-500"></i>
                            <span class="text-yellow-500 ml-1">Irregular rhythm detected</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <p class="text-xs text-gray-500 mt-2">
                Last checked:
                <?= isset($vitals->heart_rate_date) ? $vitals->heart_rate_date : 'No record' ?>
            </p>
        </div>

        <!-- Temperature Card -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Temperature</h4>
            <div class="flex items-center">
                <i class="bx bx-thermometer text-orange-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->temperature)): ?>
                        <?= $vitals->temperature ?>°C
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->temperature)): ?>
                    <?php
                    $temp = $vitals->temperature;
                    $tempCategory = getTemperatureCategory($temp);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $tempCategory['class'] . '-100 text-' . $tempCategory['class'] . '-700 text-xs rounded-full">' . $tempCategory['category'] . '</span>';

                    if ($tempCategory['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $tempCategory['class'] . '-500 cursor-help" title="' . $tempCategory['advice'] . '">
                         <i class="bx bx-info-circle"></i>
                         </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
            <?php if (isset($vitals->temperature_trend) && isset($vitals->temperature)): ?>
                <div class="mt-2 text-xs">
                    <div class="flex items-center">
                        <?php
                        $temp = $vitals->temperature;
                        if ($vitals->temperature_trend === 'up' && $temp >= 37.8): ?>
                            <i class="bx bx-trending-up text-red-500"></i>
                            <span class="text-red-500 ml-1">Temperature rising - Monitor closely</span>
                        <?php elseif ($vitals->temperature_trend === 'down' && $temp >= 37.8): ?>
                            <i class="bx bx-trending-down text-green-500"></i>
                            <span class="text-green-500 ml-1">Temperature normalizing</span>
                        <?php elseif ($vitals->temperature_trend === 'up' && $temp < 36.0): ?>
                            <i class="bx bx-trending-up text-green-500"></i>
                            <span class="text-green-500 ml-1">Temperature normalizing</span>
                        <?php elseif ($vitals->temperature_trend === 'down' && $temp < 36.0): ?>
                            <i class="bx bx-trending-down text-red-500"></i>
                            <span class="text-red-500 ml-1">Temperature decreasing - Monitor closely</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TB-specific temperature monitoring -->
            <?php if (isset($tbTreatmentData) && isset($vitals->temperature) && $vitals->temperature >= 37.8): ?>
                <div class="mt-1 text-xs">
                    <div class="flex items-center">
                        <i class="bx bx-error-circle text-red-500"></i>
                        <span class="text-red-500 ml-1">
                            <?php if ($tbTreatmentData->weeks_on_treatment > 2): ?>
                                Persistent fever on TB treatment - Evaluate for treatment failure or complications
                            <?php else: ?>
                                Fever common in early TB treatment - Monitor response to therapy
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <p class="text-xs text-gray-500 mt-2">
                Last checked:
                <?= isset($vitals->temperature_date) ? $vitals->temperature_date : 'No record' ?>
            </p>
        </div>

        <!-- Respiratory Rate Card -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Respiratory Rate</h4>
            <div class="flex items-center">
                <i class="bx bx-wind text-blue-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->respiratory_rate)): ?>
                        <?= $vitals->respiratory_rate ?> /min
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->respiratory_rate)): ?>
                    <?php
                    $respRate = $vitals->respiratory_rate;
                    $patientAge = $patient->age_category ?? 'adult';
                    $rrCategory = getRespiratoryRateCategory($respRate, $patientAge);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $rrCategory['class'] . '-100 text-' . $rrCategory['class'] . '-700 text-xs rounded-full">' . $rrCategory['category'] . '</span>';

                    if ($rrCategory['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $rrCategory['class'] . '-500 cursor-help" title="' . $rrCategory['advice'] . '">
                         <i class="bx bx-info-circle"></i>
                         </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
            <?php if ((isset($vitals->respiratory_trend) || isset($vitals->respiratory_effort)) && isset($vitals->respiratory_rate)): ?>
                <div class="mt-2 text-xs">
                    <?php if (isset($vitals->respiratory_trend)): ?>
                        <div class="flex items-center">
                            <?php
                            $respRate = $vitals->respiratory_rate;
                            if ($vitals->respiratory_trend === 'up' && $respRate > 20): ?>
                                <i class="bx bx-trending-up text-red-500"></i>
                                <span class="text-red-500 ml-1">Rate increasing - Monitor closely</span>
                            <?php elseif ($vitals->respiratory_trend === 'down' && $respRate > 20): ?>
                                <i class="bx bx-trending-down text-green-500"></i>
                                <span class="text-green-500 ml-1">Rate normalizing</span>
                            <?php elseif ($vitals->respiratory_trend === 'up' && $respRate < 12): ?>
                                <i class="bx bx-trending-up text-green-500"></i>
                                <span class="text-green-500 ml-1">Rate normalizing</span>
                            <?php elseif ($vitals->respiratory_trend === 'down' && $respRate < 12): ?>
                                <i class="bx bx-trending-down text-red-500"></i>
                                <span class="text-red-500 ml-1">Rate decreasing - Monitor closely</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($vitals->respiratory_effort) && $vitals->respiratory_effort === 'labored'): ?>
                        <div class="flex items-center mt-1">
                            <i class="bx bx-error text-red-500"></i>
                            <span class="text-red-500 ml-1">Labored breathing observed</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- TB-specific respiratory monitoring -->
            <?php if (isset($tbTreatmentData) && isset($vitals->respiratory_rate) && $vitals->respiratory_rate > 20): ?>
                <div class="mt-1 text-xs">
                    <div class="flex items-center">
                        <i class="bx bx-error-circle text-red-500"></i>
                        <span class="text-red-500 ml-1">
                            Elevated respiratory rate in TB patient - Evaluate for respiratory complications
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <p class="text-xs text-gray-500 mt-2">
                Last checked:
                <?= isset($vitals->respiratory_rate_date) ? $vitals->respiratory_rate_date : 'No record' ?>
            </p>
        </div>

        <!-- Oxygen Saturation Card -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">O2 Saturation</h4>
            <div class="flex items-center">
                <i class="bx bx-water text-cyan-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->oxygen_saturation)): ?>
                        <?= $vitals->oxygen_saturation ?>%
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->oxygen_saturation)): ?>
                    <?php
                    $o2sat = $vitals->oxygen_saturation;
                    $hasRespiratoryCondition = $patient->has_respiratory_condition ?? false;
                    $o2Category = getO2SatCategory($o2sat, $hasRespiratoryCondition);

                    echo '<span class="ml-2 px-2 py-1 bg-' . $o2Category['class'] . '-100 text-' . $o2Category['class'] . '-700 text-xs rounded-full">' . $o2Category['category'] . '</span>';

                    if ($o2Category['class'] != 'green') {
                        echo '<div class="absolute top-0 right-0 m-2 text-' . $o2Category['class'] . '-500 cursor-help" title="' . $o2Category['advice'] . '">
                         <i class="bx bx-info-circle"></i>
                         </div>';
                    }
                    ?>
                <?php endif; ?>
            </div>
            <?php if (isset($vitals->oxygen_trend) && isset($vitals->oxygen_saturation)): ?>
                <div class="mt-2 text-xs">
                    <div class="flex items-center">
                        <?php
                        $o2sat = $vitals->oxygen_saturation;
                        if ($vitals->oxygen_trend === 'down' && $o2sat < 95): ?>
                            <i class="bx bx-trending-down text-red-500"></i>
                            <span class="text-red-500 ml-1">Saturation decreasing - Monitor closely</span>
                        <?php elseif ($vitals->oxygen_trend === 'up' && $o2sat < 95): ?>
                            <i class="bx bx-trending-up text-green-500"></i>
                            <span class="text-green-500 ml-1">Saturation improving</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TB-specific O2 saturation monitoring -->
            <?php if (isset($tbTreatmentData) && isset($vitals->oxygen_saturation) && $vitals->oxygen_saturation < 95): ?>
                <div class="mt-1 text-xs">
                    <div class="flex items-center">
                        <i class="bx bx-error-circle text-red-500"></i>
                        <span class="text-red-500 ml-1">
                            Decreased O2 saturation in TB patient - Evaluate for pulmonary involvement
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <p class="text-xs text-gray-500 mt-2">
                Last checked:
                <?= isset($vitals->oxygen_saturation_date) ? $vitals->oxygen_saturation_date : 'No record' ?>
            </p>
        </div>

        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Height</h4>
            <div class="flex items-center">
                <i class="bx bx-ruler text-green-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->height)): ?>
                        <?= $vitals->height ?>
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                Last checked:
                <?= isset($vitals->height_date) ? $vitals->height_date : 'No record' ?>
            </p>
        </div>

        <!-- Weight Card with CDS -->
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <h4 class="text-md font-medium mb-2">Weight</h4>
            <div class="flex items-center">
                <i class="bx bx-trending-up text-blue-500 mr-2"></i>
                <span class="text-2xl font-bold">
                    <?php if (isset($vitals->weight)): ?>
                        <?= $vitals->weight ?>kg
                    <?php else: ?>
                        <span class="text-gray-500 text-lg font-normal">No record</span>
                    <?php endif; ?>
                </span>
                <?php if (isset($vitals->weight)): ?>
                    <?php
                    $weight = floatval($vitals->weight);
                    $height = $vitals->height ?? null;

                    if ($height) {
                        $bmi = calculateBMI($weight, $height);

                        if ($bmi >= 40) {
                            echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Class III Obesity</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" title="Consider bariatric surgery evaluation and intensive weight management program">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        } elseif ($bmi >= 35) {
                            echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Class II Obesity</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" title="Consider weight management program and evaluate for comorbidities">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        } elseif ($bmi >= 30) {
                            echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Class I Obesity</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" title="Consider referral to nutritionist and weight management program">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        } elseif ($bmi >= 25) {
                            echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Overweight</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-yellow-500 cursor-help" title="Consider lifestyle modifications and dietary counseling">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        } elseif ($bmi >= 18.5 && $bmi < 25) {
                            echo '<span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Normal</span>';
                        } elseif ($bmi >= 17 && $bmi < 18.5) {
                            echo '<span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Mild Underweight</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-yellow-500 cursor-help" title="Consider nutritional assessment and supplementation">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        } else {
                            echo '<span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Severe Underweight</span>';
                            echo '<div class="absolute top-0 right-0 m-2 text-red-500 cursor-help" title="Evaluate for underlying conditions and consider nutritional intervention">
                             <i class="bx bx-info-circle"></i>
                             </div>';
                        }

                        echo '</div>';
                        echo '<p class="text-xs text-gray-500 mt-2">BMI: ' . number_format($bmi, 1) . '</p>';
                    }
                    ?>
                    <!-- <p class="text-xs text-gray-500 mt-2">BMI: <?= number_format($bmi, 1) ?></p> -->
                <?php endif; ?>
            </div>
            <?php if (isset($vitals->weight_trend) && isset($vitals->weight)): ?>
                <div class="mt-1 text-xs">
                    <div class="flex items-center">
                        <?php
                        $weight = floatval($vitals->weight);
                        $height = $vitals->height ?? null;
                        $bmi = $height ? calculateBMI($weight, $height) : null;

                        if ($vitals->weight_trend === 'up' && $bmi && $bmi >= 25): ?>
                            <i class="bx bx-trending-up text-red-500"></i>
                            <span class="text-red-500 ml-1">Weight increasing - Consider intervention</span>
                        <?php elseif ($vitals->weight_trend === 'down' && $bmi && $bmi < 18.5): ?>
                            <i class="bx bx-trending-down text-red-500"></i>
                            <span class="text-red-500 ml-1">Weight decreasing - Monitor closely</span>
                        <?php elseif ($vitals->weight_trend === 'up' && $bmi && $bmi < 18.5): ?>
                            <i class="bx bx-trending-up text-green-500"></i>
                            <span class="text-green-500 ml-1">Weight improving</span>
                        <?php elseif ($vitals->weight_trend === 'down' && $bmi && $bmi >= 25): ?>
                            <i class="bx bx-trending-down text-green-500"></i>
                            <span class="text-green-500 ml-1">Weight improving</span>
                        <?php elseif ($vitals->weight_trend === 'down' && $bmi && $bmi >= 18.5 && $bmi < 25): ?>
                            <i class="bx bx-trending-down text-yellow-500"></i>
                            <span class="text-yellow-500 ml-1">Weight loss in TB patient - Monitor closely</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TB-specific weight monitoring -->
            <?php if (isset($tbTreatmentData) && isset($vitals->weight)): ?>
                <div class="mt-1 text-xs">
                    <?php
                    $weight = floatval($vitals->weight);
                    $weightAtDiagnosis = $tbTreatmentData->weight_at_diagnosis ?? null;
                    if ($weightAtDiagnosis && $weight < $weightAtDiagnosis * 0.95): ?>
                        <div class="flex items-center">
                            <i class="bx bx-error-circle text-red-500"></i>
                            <span class="text-red-500 ml-1">Weight loss since TB diagnosis - Evaluate treatment efficacy</span>
                        </div>
                    <?php elseif ($weightAtDiagnosis && $weight > $weightAtDiagnosis * 1.05): ?>
                        <div class="flex items-center">
                            <i class="bx bx-check-circle text-green-500"></i>
                            <span class="text-green-500 ml-1">Weight gain since TB diagnosis - Good treatment response</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>


        <!-- Active Allergies & Symptoms Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Allergies Summary -->
            <div class="bg-white rounded-lg p-4 border border-red-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-red-700">Active Allergies</h3>
                        <p class="text-sm text-gray-500">Known allergic reactions</p>
                    </div>
                    <span class="px-2 py-1 bg-red-50 text-red-600 rounded-full text-sm">
                        <?= count($allergies ?? []) ?> Active
                    </span>
                </div>

                <div class="space-y-3">
                    <?php if (!empty($allergies)): ?>
                        <?php foreach ($allergies as $allergy): ?>
                            <div class="flex items-start space-x-3 p-3 bg-red-50 rounded-lg">
                                <i class="bx bx-error-circle text-red-500 text-xl mt-0.5"></i>
                                <div>
                                    <h4 class="font-medium text-red-700"><?= htmlspecialchars($allergy->allergy_name) ?></h4>
                                    <p class="text-sm text-red-600">
                                        Type: <?= htmlspecialchars($allergy->allergy_type) ?> |
                                        Severity: <span class="font-medium"><?= htmlspecialchars($allergy->severity) ?></span>
                                    </p>
                                    <?php if (!empty($allergy->reaction)): ?>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Reaction: <?= htmlspecialchars($allergy->reaction) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-gray-500">
                            No known allergies recorded.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Symptoms Summary with TB-specific highlighting -->
            <div class="bg-white rounded-lg p-4 border border-yellow-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-yellow-700">Current Symptoms</h3>
                        <p class="text-sm text-gray-500">Active symptoms and severity</p>
                    </div>
                    <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded-full text-sm">
                        <?= count($symptoms ?? []) ?> Active
                    </span>
                </div>

                <div class="space-y-3">
                    <?php if (!empty($symptoms)): ?>
                        <?php foreach ($symptoms as $symptom):
                            // Evaluate if this is a TB-related symptom
                            $tbSymptomEval = evaluateTBSymptom($symptom->name, $symptom->duration ?? null, $symptom->severity_level ?? null);
                            $isTBSymptom = $tbSymptomEval['is_tb_related'];
                            $bgColor = $isTBSymptom ? 'bg-amber-50' : 'bg-yellow-50';
                            $textColor = $isTBSymptom ? 'text-amber-700' : 'text-yellow-700';
                            $iconColor = $isTBSymptom ? 'text-amber-500' : 'text-yellow-500';
                            ?>
                            <div class="flex items-start space-x-3 p-3 <?= $bgColor ?> rounded-lg">
                                <i
                                    class="bx <?= $isTBSymptom ? 'bx-plus-medical' : 'bx-pulse' ?> <?= $iconColor ?> text-xl mt-0.5"></i>
                                <div>
                                    <h4 class="font-medium <?= $textColor ?>"><?= htmlspecialchars($symptom->name) ?>
                                        <?php if ($isTBSymptom): ?>
                                            <span class="text-xs bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded ml-1">TB
                                                Symptom</span>
                                        <?php endif; ?>
                                    </h4>
                                    <p class="text-sm <?= $isTBSymptom ? 'text-amber-600' : 'text-yellow-600' ?>">
                                        Severity: <span
                                            class="font-medium"><?= htmlspecialchars($symptom->severity_level ?? 'Unknown') ?></span>
                                        <?php if (!empty($symptom->duration)): ?>
                                            | Duration: <?= htmlspecialchars($symptom->duration) ?>
                                        <?php endif; ?>
                                    </p>
                                    <?php if (!empty($symptom->notes)): ?>
                                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($symptom->notes) ?></p>
                                    <?php endif; ?>

                                    <?php if ($isTBSymptom && $tbSymptomEval['importance'] !== 'low'): ?>
                                        <p class="text-xs text-amber-600 mt-1 italic">
                                            <?= $tbSymptomEval['advice'] ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($tbSymptomEval['alert']): ?>
                                        <div class="mt-1 flex items-center">
                                            <i class="bx bx-error-circle text-red-500"></i>
                                            <span class="text-xs text-red-600 ml-1"><?= $tbSymptomEval['alert_advice'] ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-gray-500">
                            No active symptoms recorded.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>



        <!-- Clinical Decision Support for Allergies and Symptoms -->
        <div class="mb-6 bg-gradient-to-r from-orange-50 to-yellow-50 p-4 rounded-lg border border-orange-100">
            <h3 class="text-lg font-medium mb-3 text-orange-800">
                <i class="bx bx-bulb mr-2"></i>Clinical Correlations
            </h3>
            <div class="space-y-3">
                <?php
                $clinicalCorrelations = [];

                // Enhanced analysis of allergies and symptoms together
                // Enhanced analysis of allergies and symptoms together
                if (!empty($allergies) && !empty($symptoms)) {
                    foreach ($allergies as $allergy) {
                        // Define symptom patterns based on allergy type
                        $allergyPatterns = [
                            'food' => [
                                'symptoms' => [
                                    'gi' => ['Nausea', 'Vomiting', 'Diarrhea', 'Abdominal', 'Stomach'],
                                    'skin' => ['Rash', 'Hives', 'Itching', 'Skin', 'Eczema'],
                                    'respiratory' => ['Breathing', 'Wheezing', 'Cough'],
                                    'anaphylaxis' => ['Swelling', 'Throat', 'Tongue', 'Lips']
                                ],
                                'severe_reaction' => 'Consider food elimination diet and maintain food diary'
                            ],
                            'drug' => [
                                'symptoms' => [
                                    'skin' => ['Rash', 'Hives', 'Itching', 'Skin'],
                                    'respiratory' => ['Breathing', 'Wheezing', 'Shortness'],
                                    'anaphylaxis' => ['Swelling', 'Throat', 'Face']
                                ],
                                'severe_reaction' => 'Document in alerts. Consider alternative medications'
                            ],
                            'environmental' => [
                                'symptoms' => [
                                    'respiratory' => ['Breathing', 'Congestion', 'Sneeze', 'Cough'],
                                    'eye' => ['Eye', 'Watery', 'Itchy'],
                                    'skin' => ['Rash', 'Itching']
                                ],
                                'severe_reaction' => 'Consider environmental modification and preventive measures'
                            ]
                        ];

                        $allergyType = strtolower($allergy->allergy_type);
                        $patterns = $allergyPatterns[$allergyType] ?? $allergyPatterns['food'];

                        foreach ($symptoms as $symptom) {
                            $matchFound = false;
                            $matchCategory = '';
                            $symptomLower = strtolower($symptom->name);

                            // Check each symptom category for the specific allergy type
                            foreach ($patterns['symptoms'] as $category => $keywords) {
                                foreach ($keywords as $keyword) {
                                    if (stripos($symptomLower, $keyword) !== false) {
                                        $matchFound = true;
                                        $matchCategory = $category;
                                        break 2;
                                    }
                                }
                            }

                            if ($matchFound) {
                                $severity = strtolower($symptom->severity_level ?? 'unknown');
                                $type = 'warning';
                                $advice = '';

                                // Compare with known reaction pattern
                                $knownReaction = strtolower($allergy->reaction ?? '');
                                $currentSymptom = strtolower($symptom->name);
                                $reactionMatch = stripos($knownReaction, $currentSymptom) !== false;

                                // Determine severity and advice
                                if ($matchCategory === 'anaphylaxis' || $severity === 'Severe') {
                                    $type = 'alert';
                                    $advice = $patterns['severe_reaction'] . '. Ensure anaphylaxis protocol is in place';
                                } elseif ($reactionMatch) {
                                    $type = 'alert';
                                    $advice = "Known reaction pattern for this allergen. " . $patterns['severe_reaction'];
                                } else {
                                    $advice = match ($matchCategory) {
                                        'respiratory' => "Monitor respiratory status. Consider peak flow monitoring",
                                        'skin' => "Consider antihistamines and document rash characteristics",
                                        'gi' => "Monitor hydration status and food intake",
                                        'eye' => "Consider antihistamine eye drops if approved",
                                        default => "Monitor symptoms closely"
                                    };
                                }

                                $clinicalCorrelations[] = [
                                    'type' => $type,
                                    'message' => "Possible {$allergy->allergy_type} Allergy reaction to {$symptom->name} similar to known reaction to {$allergy->allergy_name}",
                                    'advice' => $advice
                                ];
                            }
                        }

                        // Add specific warnings based on allergy severity and known reactions
                        if (strtolower($allergy->severity ?? 'unknown') === 'Severe') {
                            $clinicalCorrelations[] = [
                                'type' => 'alert',
                                'message' => "Severe {$allergy->allergy_type} allergy to {$allergy->allergy_name}" .
                                    (!empty($allergy->reaction) ? " (Previous reaction: {$allergy->reaction})" : ""),
                                'advice' => $patterns['severe_reaction'] . ". Ensure emergency protocol is documented"
                            ];
                        }
                    }
                }

                // TB medication side effects analysis
                if (!empty($symptoms) && !empty($medications)) {
                    $tbMedSideEffects = checkTBMedicationSideEffects($symptoms, $medications);

                    foreach ($tbMedSideEffects as $sideEffect) {
                        $type = (strpos($sideEffect['advice'], 'URGENT') !== false) ? 'alert' : 'warning';

                        $clinicalCorrelations[] = [
                            'type' => $type,
                            'message' => "Possible {$sideEffect['medication']} side effect: {$sideEffect['symptom']} ({$sideEffect['category']})",
                            'advice' => $sideEffect['advice']
                        ];
                    }
                }

                // TB-specific symptom analysis
                if (!empty($symptoms)) {
                    $tbSymptomCount = 0;
                    $criticalTBSymptoms = 0;
                    $tbSymptomsList = [];

                    foreach ($symptoms as $symptom) {
                        $tbEval = evaluateTBSymptom($symptom->name, $symptom->duration ?? null, $symptom->severity_level ?? null);
                        if ($tbEval['is_tb_related']) {
                            $tbSymptomCount++;
                            $tbSymptomsList[] = $symptom->name;

                            if ($tbEval['importance'] === 'high') {
                                $criticalTBSymptoms++;
                            }
                        }
                    }

                    // If multiple TB symptoms present
                    if ($tbSymptomCount >= 3) {
                        $clinicalCorrelations[] = [
                            'type' => 'alert',
                            'message' => "Multiple TB symptoms present: " . implode(', ', $tbSymptomsList),
                            'advice' => "Consider comprehensive TB evaluation including sputum testing, chest X-ray, and TB culture"
                        ];
                    } elseif ($criticalTBSymptoms >= 2) {
                        $clinicalCorrelations[] = [
                            'type' => 'alert',
                            'message' => "Multiple critical TB symptoms present",
                            'advice' => "High clinical suspicion for active TB. Ensure appropriate isolation and diagnostic workup"
                        ];
                    }
                }

                // TB treatment and symptom correlation
                if (!empty($symptoms) && isset($tbTreatmentData) && $tbTreatmentData->weeks_on_treatment > 2) {
                    $persistentTBSymptoms = [];

                    foreach ($symptoms as $symptom) {
                        $tbEval = evaluateTBSymptom($symptom->name);
                        if ($tbEval['is_tb_related'] && $tbEval['importance'] === 'high') {
                            $persistentTBSymptoms[] = $symptom->name;
                        }
                    }

                    if (count($persistentTBSymptoms) >= 2) {
                        $clinicalCorrelations[] = [
                            'type' => 'alert',
                            'message' => "Persistent TB symptoms after " . $tbTreatmentData->weeks_on_treatment . " weeks of treatment: " . implode(', ', $persistentTBSymptoms),
                            'advice' => "Evaluate for treatment failure, drug resistance, or alternative diagnoses. Consider drug susceptibility testing."
                        ];
                    }
                }

                // Display correlations with enhanced styling
                foreach ($clinicalCorrelations as $correlation): ?>
                    <div class="flex items-start space-x-3 p-3
                <?= $correlation['type'] === 'alert' ? 'bg-red-50' : 'bg-yellow-50' ?> rounded-lg">
                        <i class="bx <?= $correlation['type'] === 'alert' ? 'bx-shield-quarter' : 'bx-note' ?> 
                   <?= $correlation['type'] === 'alert' ? 'text-red-500' : 'text-yellow-500' ?> text-xl"></i>
                        <div>
                            <p
                                class="text-sm font-medium <?= $correlation['type'] === 'alert' ? 'text-red-700' : 'text-yellow-700' ?>">
                                <?= $correlation['message'] ?>
                            </p>
                            <?php if (!empty($correlation['advice'])): ?>
                                <p class="text-xs text-gray-600 mt-1"><?= $correlation['advice'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($clinicalCorrelations)): ?>
                    <p class="text-sm text-gray-600">No significant clinical correlations between current symptoms and known
                        allergies.
                    </p>
                <?php endif; ?>
            </div>
        </div>


        <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200 mt-2">
            <h3 class="text-lg font-medium mb-3 text-blue-800">Clinical Insights</h3>
            <div class="space-y-2">
                <?php
                // Enhanced clinical insights based on vitals and medical history
                $insights = [];
                $patientAge = $patient->age ?? 50;
                $patientSex = $patient->sex ?? 'unknown';
                $patientRiskFactors = $patient->risk_factors ?? [];
                $patientConditions = $patient->conditions ?? [];
                $isTBPatient = isset($tbTreatmentData);

                // Blood Pressure Analysis with risk stratification
                if (isset($vitals->blood_pressure)) {
                    $systolic = explode('/', $vitals->blood_pressure)[0];
                    $diastolic = explode('/', $vitals->blood_pressure)[1];

                    $hasCardiovascularRisk = false;
                    $hasDiabetes = false;
                    $hasKidneyDisease = false;

                    // Check for comorbidities that increase CV risk
                    if (!empty($patientConditions)) {
                        foreach ($patientConditions as $condition) {
                            if (in_array(strtolower($condition->name), ['coronary artery disease', 'stroke', 'peripheral artery disease'])) {
                                $hasCardiovascularRisk = true;
                            }
                            if (strtolower($condition->name) === 'diabetes') {
                                $hasDiabetes = true;
                            }
                            if (in_array(strtolower($condition->name), ['chronic kidney disease', 'renal failure'])) {
                                $hasKidneyDisease = true;
                            }
                        }
                    }

                    if ($systolic >= 180 || $diastolic >= 120) {
                        $insights[] = [
                            'type' => 'alert',
                            'message' => 'Hypertensive crisis (' . $vitals->blood_pressure . ') - Immediate intervention required',
                            'advice' => 'Consider IV antihypertensives and hospital admission if end-organ damage present',
                            'icon' => 'bx-shield-quarter'
                        ];
                    } elseif ($systolic >= 160 || $diastolic >= 100) {
                        $insights[] = [
                            'type' => 'alert',
                            'message' => 'Stage 2 Hypertension (' . $vitals->blood_pressure . ')',
                            'advice' => 'Consider combination therapy and more frequent monitoring. ' .
                                ($hasCardiovascularRisk ? 'High cardiovascular risk - aggressive management indicated. ' : '') .
                                ($hasDiabetes ? 'Target BP <130/80 recommended for diabetic patients. ' : '') .
                                ($hasKidneyDisease ? 'Renal protection strategy recommended. ' : ''),
                            'icon' => 'bx-shield-quarter'
                        ];
                    } elseif ($systolic >= 140 || $diastolic >= 90) {
                        $insights[] = [
                            'type' => 'warning',
                            'message' => 'Stage 1 Hypertension (' . $vitals->blood_pressure . ')',
                            'advice' => 'Consider lifestyle modifications' .
                                ($hasCardiovascularRisk || $hasDiabetes || $hasKidneyDisease ? ' and pharmacotherapy' : ' with possible monotherapy') .
                                '. Reassess in 1 month.',
                            'icon' => 'bx-shield-quarter'
                        ];
                    } elseif ($systolic >= 130 || $diastolic >= 80) {
                        $insights[] = [
                            'type' => 'warning',
                            'message' => 'Elevated blood pressure (' . $vitals->blood_pressure . ')',
                            'advice' => 'Recommend lifestyle modifications and reassess in 3-6 months',
                            'icon' => 'bx-shield-quarter'
                        ];
                    } elseif ($systolic <= 90 || $diastolic <= 60) {
                        $insights[] = [
                            'type' => 'warning',
                            'message' => 'Hypotension (' . $vitals->blood_pressure . ')',
                            'advice' => 'Review medications. Consider orthostatic evaluation if symptomatic.',
                            'icon' => 'bx-shield-quarter'
                        ];
                    }
                }

                // TB-specific liver function monitoring for patients on TB medications
                if ($isTBPatient && isset($vitals->liver_enzymes)) {
                    $alt = $vitals->liver_enzymes->alt ?? null;
                    $ast = $vitals->liver_enzymes->ast ?? null;
                    $bili = $vitals->liver_enzymes->total_bilirubin ?? null;

                    if (
                        ($alt !== null && $alt > 3 * $vitals->liver_enzymes->alt_upper_limit) ||
                        ($ast !== null && $ast > 3 * $vitals->liver_enzymes->ast_upper_limit)
                    ) {
                        $insights[] = [
                            'type' => 'alert',
                            'message' => 'Elevated liver enzymes in TB patient on treatment',
                            'advice' => 'Consider temporary discontinuation of hepatotoxic TB medications (isoniazid, rifampin, pyrazinamide). Consult hepatology.',
                            'icon' => 'bx-test-tube'
                        ];
                    } elseif (
                        ($alt !== null && $alt > 2 * $vitals->liver_enzymes->alt_upper_limit) ||
                        ($ast !== null && $ast > 2 * $vitals->liver_enzymes->ast_upper_limit)
                    ) {
                        $insights[] = [
                            'type' => 'warning',
                            'message' => 'Moderately elevated liver enzymes in TB patient',
                            'advice' => 'Monitor liver function tests more frequently. Consider dose adjustment if symptoms present.',
                            'icon' => 'bx-test-tube'
                        ];
                    }

                    if ($bili !== null && $bili > 2) {
                        $insights[] = [
                            'type' => 'alert',
                            'message' => 'Elevated bilirubin (' . $bili . ' mg/dL) in TB patient',
                            'advice' => 'Evaluate for drug-induced liver injury. Consider temporary discontinuation of hepatotoxic TB medications.',
                            'icon' => 'bx-test-tube'
                        ];
                    }
                }

                // TB-specific weight monitoring
                if ($isTBPatient && isset($vitals->weight)) {
                    $weight = $vitals->weight;
                    $weightAtDiagnosis = $tbTreatmentData->weight_at_diagnosis ?? null;

                    if ($weightAtDiagnosis && $weight < $weightAtDiagnosis * 0.95 && $tbTreatmentData->weeks_on_treatment > 4) {
                        $insights[] = [
                            'type' => 'alert',
                            'message' => 'Weight loss during TB treatment',
                            'advice' => 'Evaluate for treatment failure, malabsorption, or comorbidities. Consider nutritional support.',
                            'icon' => 'bx-trending-down'
                        ];
                    } elseif ($weightAtDiagnosis && $weight > $weightAtDiagnosis * 1.05) {
                        $insights[] = [
                            'type' => 'success',
                            'message' => 'Weight gain during TB treatment',
                            'advice' => 'Positive indicator of treatment response.',
                            'icon' => 'bx-trending-up'
                        ];
                    }
                }

                // Display enhanced insights with more detailed styling
                foreach ($insights as $insight): ?>
                    <div class="flex items-start space-x-3 p-3 
                <?php
                if ($insight['type'] === 'alert')
                    echo 'bg-red-50';
                elseif ($insight['type'] === 'warning')
                    echo 'bg-yellow-50';
                elseif ($insight['type'] === 'success')
                    echo 'bg-green-50';
                else
                    echo 'bg-blue-50';
                ?> rounded-lg">
                        <i class="bx <?= $insight['icon'] ?> 
                   <?php
                   if ($insight['type'] === 'alert')
                       echo 'text-red-600';
                   elseif ($insight['type'] === 'warning')
                       echo 'text-yellow-600';
                   elseif ($insight['type'] === 'success')
                       echo 'text-green-600';
                   else
                       echo 'text-blue-600';
                   ?> text-xl"></i>
                        <div>
                            <p class="text-sm font-medium 
                       <?php
                       if ($insight['type'] === 'alert')
                           echo 'text-red-700';
                       elseif ($insight['type'] === 'warning')
                           echo 'text-yellow-700';
                       elseif ($insight['type'] === 'success')
                           echo 'text-green-700';
                       else
                           echo 'text-blue-700';
                       ?>">
                                <?= $insight['message'] ?>
                            </p>
                            <?php if (!empty($insight['advice'])): ?>
                                <p class="text-xs text-gray-600 mt-1"><?= $insight['advice'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($insights)): ?>
                    <p class="text-sm text-gray-600">All vitals are within normal ranges. Continue current management plan.
                    </p>
                <?php endif; ?>
            </div>
        </div>


        <Actions>
            <Action name="Add TB drug resistance monitoring"
                description="Enhance the system to track and alert on potential drug resistance patterns" />
            <Action name="Implement TB contact tracing dashboard"
                description="Create a visualization for household and close contact TB screening status" />
            <Action name="Add TB treatment outcome prediction"
                description="Implement an algorithm to predict treatment outcomes based on current clinical data" />
            <Action name="Integrate TB medication dosing calculator"
                description="Add weight-based TB medication dosing recommendations" />
            <Action name="Add TB comorbidity management"
                description="Implement specific guidance for managing TB with HIV, diabetes, and other comorbidities" />
        </Actions>



    </div>
</div>