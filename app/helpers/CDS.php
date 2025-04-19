<?php
function calculateBMI($weight, $height_string)
{
    // Weight is already in kg, no need to convert
    $weight_kg = floatval($weight);

    // Check if height is in decimal format (assuming centimeters)
    if (is_numeric($height_string)) {
        // Convert height from cm to meters
        $height_m = floatval($height_string) / 100;
    } else {
        // Convert height from feet'inches" format to meters
        $height_parts = explode("'", str_replace('"', '', $height_string));
        $feet = floatval($height_parts[0]);
        $inches = isset($height_parts[1]) ? floatval($height_parts[1]) : 0;
        $total_inches = ($feet * 12) + $inches;
        $height_m = $total_inches * 0.0254;
    }

    error_log("Weight kg: $weight_kg, Height m: $height_m");

    // Calculate BMI (ensure we don't divide by zero)
    return ($height_m > 0) ? ($weight_kg / ($height_m * $height_m)) : 0;
}
// New function to determine blood pressure category based on latest guidelines
function getBPCategory($systolic, $diastolic)
{
    if ($systolic >= 180 || $diastolic >= 120) {
        return ['category' => 'Hypertensive Crisis', 'class' => 'red', 'advice' => 'Immediate medical attention required'];
    } elseif ($systolic >= 140 || $diastolic >= 90) {
        return ['category' => 'Hypertension Stage 2', 'class' => 'red', 'advice' => 'Medication adjustment and lifestyle modifications recommended'];
    } elseif (($systolic >= 130 && $systolic < 140) || ($diastolic >= 80 && $diastolic < 90)) {
        return ['category' => 'Hypertension Stage 1', 'class' => 'yellow', 'advice' => 'Consider lifestyle modifications and medication review'];
    } elseif (($systolic >= 120 && $systolic < 130) && $diastolic < 80) {
        return ['category' => 'Elevated', 'class' => 'yellow', 'advice' => 'Lifestyle modifications recommended'];
    } elseif ($systolic >= 90 && $systolic < 120 && $diastolic >= 60 && $diastolic < 80) {
        return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Maintain healthy lifestyle'];
    } else {
        return ['category' => 'Low', 'class' => 'yellow', 'advice' => 'Monitor for symptoms of hypotension'];
    }
}

// New function to determine glucose category based on clinical guidelines
function getGlucoseCategory($glucose, $fasting = true)
{
    if ($fasting) {
        if ($glucose >= 126) {
            return ['category' => 'Diabetic', 'class' => 'red', 'advice' => 'HbA1c test and diabetes management plan recommended'];
        } elseif ($glucose >= 100 && $glucose < 126) {
            return ['category' => 'Pre-diabetic', 'class' => 'yellow', 'advice' => 'Glucose tolerance test and lifestyle modifications recommended'];
        } else {
            return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
        }
    } else {
        // Random glucose
        if ($glucose >= 200) {
            return ['category' => 'Diabetic', 'class' => 'red', 'advice' => 'HbA1c test and diabetes management plan recommended'];
        } elseif ($glucose >= 140 && $glucose < 200) {
            return ['category' => 'Pre-diabetic', 'class' => 'yellow', 'advice' => 'Fasting glucose test recommended'];
        } else {
            return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
        }
    }
}

// New function to determine heart rate category
function getHeartRateCategory($heartRate, $age = 50)
{
    // Age-adjusted heart rate ranges
    $maxNormal = 220 - $age * 0.7;
    $minNormal = 60;

    if ($heartRate >= $maxNormal) {
        return ['category' => 'Tachycardia', 'class' => 'red', 'advice' => 'ECG and cardiac evaluation recommended'];
    } elseif ($heartRate < $minNormal) {
        if ($heartRate < 50) {
            return ['category' => 'Severe Bradycardia', 'class' => 'red', 'advice' => 'Cardiac evaluation recommended'];
        } else {
            return ['category' => 'Bradycardia', 'class' => 'yellow', 'advice' => 'Monitor and review medications'];
        }
    } else {
        return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
    }
}

// New function to determine temperature category
function getTemperatureCategory($temp)
{
    if ($temp >= 39.5) {
        return ['category' => 'High Fever', 'class' => 'red', 'advice' => 'Urgent evaluation for infection, blood cultures recommended'];
    } elseif ($temp >= 38.3 && $temp < 39.5) {
        return ['category' => 'Fever', 'class' => 'red', 'advice' => 'Consider infection workup and antipyretics'];
    } elseif ($temp >= 37.8 && $temp < 38.3) {
        return ['category' => 'Low-grade Fever', 'class' => 'yellow', 'advice' => 'Monitor closely and consider antipyretics'];
    } elseif ($temp >= 36.5 && $temp <= 37.5) {
        return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
    } elseif ($temp >= 35.0 && $temp < 36.5) {
        return ['category' => 'Mild Hypothermia', 'class' => 'yellow', 'advice' => 'Monitor and consider warming measures'];
    } else {
        return ['category' => 'Hypothermia', 'class' => 'red', 'advice' => 'Immediate warming measures and evaluation of underlying causes'];
    }
}


function getRespiratoryRateCategory($respRate, $age)
{
    if ($age > 18) {
        if ($respRate > 30) {
            return ['category' => 'Severe Tachypnea', 'class' => 'red', 'advice' => 'Urgent respiratory assessment and intervention'];
        } elseif ($respRate > 24 && $respRate <= 30) {
            return ['category' => 'Tachypnea', 'class' => 'red', 'advice' => 'Blood gas analysis and respiratory assessment recommended'];
        } elseif ($respRate >= 12 && $respRate <= 20) {
            return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
        } elseif ($respRate >= 8 && $respRate < 12) {
            return ['category' => 'Mild Bradypnea', 'class' => 'yellow', 'advice' => 'Monitor and review medications'];
        } else {
            return ['category' => 'Severe Bradypnea', 'class' => 'red', 'advice' => 'Evaluate for respiratory depression and medication effects'];
        }
    } else {
        // Child rates would go here
        return ['category' => 'Evaluate', 'class' => 'yellow', 'advice' => 'Evaluate based on pediatric guidelines'];
    }
}

// New function to determine oxygen saturation category
function getO2SatCategory($o2sat, $hasRespiratoryCondition = false)
{
    if ($hasRespiratoryCondition) {
        // Adjusted thresholds for patients with COPD or other chronic respiratory conditions
        if ($o2sat < 88) {
            return ['category' => 'Severe Hypoxemia', 'class' => 'red', 'advice' => 'Immediate oxygen therapy and cardiopulmonary evaluation'];
        } elseif ($o2sat >= 88 && $o2sat < 92) {
            return ['category' => 'Mild Hypoxemia', 'class' => 'yellow', 'advice' => 'Consider supplemental oxygen and monitor closely'];
        } else {
            return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
        }
    } else {
        // Standard thresholds
        if ($o2sat < 90) {
            return ['category' => 'Severe Hypoxemia', 'class' => 'red', 'advice' => 'Immediate oxygen therapy and cardiopulmonary evaluation'];
        } elseif ($o2sat >= 90 && $o2sat < 95) {
            return ['category' => 'Mild Hypoxemia', 'class' => 'yellow', 'advice' => 'Consider supplemental oxygen and monitor closely'];
        } else {
            return ['category' => 'Normal', 'class' => 'green', 'advice' => 'Continue regular monitoring'];
        }
    }
}

function evaluateTBSymptom($symptom, $duration = null, $severity = null)
{
    $tbSymptoms = [
        'cough' => [
            'importance' => 'high',
            'advice' => 'Cardinal TB symptom. Evaluate duration and sputum characteristics.',
            'alert_threshold' => 'severe',
            'alert_advice' => 'Consider sputum AFB, culture, and GeneXpert testing.',
            'duration_threshold' => [
                'weeks' => 2,
                'months' => 1,
                'days' => 14
            ]
        ],
        'hemoptysis' => [
            'importance' => 'high',
            'advice' => 'Concerning for active pulmonary TB. Urgent evaluation needed.',
            'alert_threshold' => 'any',
            'alert_advice' => 'Immediate sputum testing and chest imaging required.',
            'duration_threshold' => [
                'weeks' => 1,
                'months' => 0.25,
                'days' => 7
            ]
        ],
        // ... other symptoms remain the same ...
    ];

    $symptomLower = strtolower($symptom);
    $result = ['is_tb_related' => false, 'importance' => 'low', 'advice' => '', 'alert' => false];

    foreach ($tbSymptoms as $tbSymptom => $details) {
        if (stripos($symptomLower, $tbSymptom) !== false) {
            $result['is_tb_related'] = true;
            $result['importance'] = $details['importance'];
            $result['advice'] = $details['advice'];

            // Evaluate duration if provided
            if ($duration) {
                $durationLower = strtolower($duration);

                // Extract number and unit from duration string (e.g., "2 weeks", "3 months", "5 days")
                if (preg_match('/(\d+)\s*(day|days|week|weeks|month|months)/i', $durationLower, $matches)) {
                    $number = intval($matches[1]);
                    $unit = strtolower($matches[2]);

                    // Standardize unit name
                    $unit = str_replace(['day', 'week', 'month'], ['days', 'weeks', 'months'], $unit);

                    // Get threshold for this symptom
                    $threshold = $details['duration_threshold'] ?? null;

                    if ($threshold) {
                        $isLongDuration = false;

                        switch ($unit) {
                            case 'days':
                                $isLongDuration = $number >= $threshold['days'];
                                break;
                            case 'weeks':
                                $isLongDuration = $number >= $threshold['weeks'];
                                break;
                            case 'months':
                                $isLongDuration = $number >= $threshold['months'];
                                break;
                        }

                        if ($isLongDuration) {
                            $result['alert'] = true;
                            $result['duration_alert'] = true;
                            $result['duration_advice'] = "Symptom duration of $duration is concerning for TB. ";
                            $result['alert_advice'] = ($result['alert_advice'] ?? '') .
                                "Extended duration requires immediate evaluation.";
                        }
                    }
                }
            }

            // Existing severity check remains the same
            if ($severity) {
                $severityLower = strtolower($severity);
                if (
                    ($details['alert_threshold'] === 'any') ||
                    ($details['alert_threshold'] === 'Moderate' && in_array($severityLower, ['Moderate', 'Severe', 'High'])) ||
                    ($details['alert_threshold'] === 'Severe' && in_array($severityLower, ['Severe', 'High']))
                ) {
                    $result['alert'] = true;
                    $result['alert_advice'] = $details['alert_advice'];
                }
            }

            break;
        }
    }

    return $result;
}


function checkTBMedicationSideEffects($symptoms, $medications)
{
    $sideEffects = [];

    // Define common TB medications and their side effects
    $tbMedSideEffects = [
        'isoniazid' => [
            'peripheral neuropathy' => ['numbness', 'tingling', 'pain in extremities'],
            'hepatotoxicity' => ['nausea', 'vomiting', 'abdominal pain', 'jaundice', 'dark urine'],
            'rash' => ['skin rash', 'itching'],
            'other' => ['fatigue', 'dizziness', 'vision changes']
        ],
        'rifampin' => [
            'hepatotoxicity' => ['nausea', 'vomiting', 'abdominal pain', 'jaundice', 'dark urine'],
            'flu-like symptoms' => ['fever', 'chills', 'headache', 'bone pain'],
            'rash' => ['skin rash', 'itching'],
            'other' => ['orange discoloration of body fluids', 'dizziness']
        ],
        'pyrazinamide' => [
            'hepatotoxicity' => ['nausea', 'vomiting', 'abdominal pain', 'jaundice', 'dark urine'],
            'arthralgia' => ['joint pain', 'gout', 'arthritis'],
            'other' => ['rash', 'fever', 'malaise']
        ],
        'ethambutol' => [
            'optic neuritis' => ['vision changes', 'color blindness', 'blurred vision', 'eye pain'],
            'other' => ['rash', 'joint pain', 'headache', 'dizziness', 'nausea']
        ],
        'bedaquiline' => [
            'cardiac' => ['qt prolongation', 'palpitations', 'chest pain'],
            'other' => ['nausea', 'joint pain', 'headache']
        ],
        'linezolid' => [
            'peripheral neuropathy' => ['numbness', 'tingling', 'pain in extremities'],
            'optic neuritis' => ['vision changes', 'blurred vision'],
            'bone marrow suppression' => ['fatigue', 'weakness', 'pallor'],
            'other' => ['nausea', 'diarrhea', 'headache']
        ],
        'fluoroquinolones' => [
            'tendinopathy' => ['tendon pain', 'joint pain', 'swelling'],
            'cns effects' => ['headache', 'dizziness', 'insomnia', 'anxiety'],
            'gi effects' => ['nausea', 'diarrhea', 'abdominal pain'],
            'other' => ['rash', 'itching']
        ]
    ];

    // Check if patient is on TB medications
    $patientTBMeds = [];
    if (!empty($medications)) {
        foreach ($medications as $medication) {
            $medName = strtolower($medication->name);
            foreach ($tbMedSideEffects as $tbMed => $effects) {
                if (stripos($medName, $tbMed) !== false) {
                    $patientTBMeds[$tbMed] = $medication->name;
                }
            }

            // Check for fluoroquinolones class
            $fluoroquinolones = ['levofloxacin', 'moxifloxacin', 'ciprofloxacin', 'ofloxacin'];
            foreach ($fluoroquinolones as $fq) {
                if (stripos($medName, $fq) !== false) {
                    $patientTBMeds['fluoroquinolones'] = $medication->name;
                }
            }
        }
    }

    // If patient is on TB medications, check for side effects
    if (!empty($patientTBMeds) && !empty($symptoms)) {
        foreach ($patientTBMeds as $tbMed => $actualMedName) {
            foreach ($tbMedSideEffects[$tbMed] as $effectCategory => $effectSymptoms) {
                foreach ($symptoms as $symptom) {
                    $symptomName = strtolower($symptom->name);
                    foreach ($effectSymptoms as $effectSymptom) {
                        if (stripos($symptomName, $effectSymptom) !== false) {
                            $sideEffects[] = [
                                'medication' => $actualMedName,
                                'category' => $effectCategory,
                                'symptom' => $symptom->name,
                                'severity' => $symptom->severity_level ?? 'unknown',
                                'advice' => getAdviceForTBMedSideEffect($tbMed, $effectCategory, $symptom->severity_level ?? 'unknown')
                            ];
                        }
                    }
                }
            }
        }
    }

    return $sideEffects;
}

// Helper function to get advice for TB medication side effects
function getAdviceForTBMedSideEffect($medication, $category, $severity)
{
    $severityLower = strtolower($severity);
    $isSerious = in_array($severityLower, ['Severe', 'High']);

    $criticalSideEffects = [
        'isoniazid' => ['hepatotoxicity'],
        'rifampin' => ['hepatotoxicity'],
        'pyrazinamide' => ['hepatotoxicity'],
        'ethambutol' => ['optic neuritis'],
        'bedaquiline' => ['cardiac'],
        'linezolid' => ['bone marrow suppression', 'optic neuritis'],
        'fluoroquinolones' => ['tendinopathy']
    ];

    $isCritical = isset($criticalSideEffects[$medication]) && in_array($category, $criticalSideEffects[$medication]);

    if ($isCritical && $isSerious) {
        return "URGENT: Consider temporary discontinuation and immediate medical evaluation.";
    } elseif ($isCritical) {
        return "Important side effect requiring prompt evaluation. Consider dose adjustment or medication change.";
    } elseif ($isSerious) {
        return "Significant side effect requiring medical evaluation.";
    } else {
        return "Monitor symptoms and report if worsening.";
    }
}

// Function to evaluate TB treatment progress
function evaluateTBTreatmentProgress($tbTreatmentData)
{
    if (empty($tbTreatmentData))
        return null;

    $treatmentPhase = $tbTreatmentData->phase ?? 'unknown';
    $weeksOnTreatment = $tbTreatmentData->weeks_on_treatment ?? 0;
    $initialSmear = $tbTreatmentData->initial_smear_result ?? 'unknown';
    $latestSmear = $tbTreatmentData->latest_smear_result ?? 'unknown';
    $adherence = $tbTreatmentData->adherence_percentage ?? 0;
    $weightTrend = $tbTreatmentData->weight_trend ?? 'stable';
    $symptomImprovement = $tbTreatmentData->symptom_improvement ?? 'unknown';

    $insights = [];

    // Evaluate treatment phase and duration
    if ($treatmentPhase === 'intensive' && $weeksOnTreatment >= 8) {
        $insights[] = [
            'type' => 'warning',
            'message' => 'Patient has been on intensive phase for ' . $weeksOnTreatment . ' weeks',
            'advice' => 'Evaluate for transition to continuation phase. Check sputum conversion.'
        ];
    } elseif ($treatmentPhase === 'continuation' && $weeksOnTreatment >= 16) {
        $insights[] = [
            'type' => 'info',
            'message' => 'Patient has been on continuation phase for ' . $weeksOnTreatment . ' weeks',
            'advice' => 'Evaluate for treatment completion. Consider final sputum testing.'
        ];
    }

    // Evaluate sputum conversion
    if ($initialSmear === 'positive' && $latestSmear === 'positive' && $weeksOnTreatment >= 8) {
        $insights[] = [
            'type' => 'alert',
            'message' => 'No sputum conversion after ' . $weeksOnTreatment . ' weeks of treatment',
            'advice' => 'Evaluate for treatment failure or drug resistance. Consider drug susceptibility testing.'
        ];
    } elseif ($initialSmear === 'positive' && $latestSmear === 'negative') {
        $insights[] = [
            'type' => 'success',
            'message' => 'Successful sputum conversion achieved',
            'advice' => 'Continue current treatment regimen.'
        ];
    }

    // Evaluate adherence
    if ($adherence < 80) {
        $insights[] = [
            'type' => 'alert',
            'message' => 'Poor treatment adherence (' . $adherence . '%)',
            'advice' => 'Address barriers to adherence. Consider directly observed therapy (DOT).'
        ];
    } elseif ($adherence >= 80 && $adherence < 95) {
        $insights[] = [
            'type' => 'warning',
            'message' => 'Suboptimal treatment adherence (' . $adherence . '%)',
            'advice' => 'Reinforce importance of medication adherence. Identify and address barriers.'
        ];
    }

    // Evaluate weight trend
    if ($weightTrend === 'decreasing') {
        $insights[] = [
            'type' => 'warning',
            'message' => 'Weight loss during treatment',
            'advice' => 'Evaluate nutritional status and treatment efficacy. Consider comorbidities.'
        ];
    } elseif ($weightTrend === 'increasing') {
        $insights[] = [
            'type' => 'success',
            'message' => 'Weight gain during treatment',
            'advice' => 'Positive indicator of treatment response.'
        ];
    }

    // Evaluate symptom improvement
    if ($symptomImprovement === 'none' && $weeksOnTreatment >= 4) {
        $insights[] = [
            'type' => 'alert',
            'message' => 'No symptom improvement after ' . $weeksOnTreatment . ' weeks of treatment',
            'advice' => 'Evaluate for treatment failure, drug resistance, or alternative diagnoses.'
        ];
    } elseif ($symptomImprovement === 'minimal' && $weeksOnTreatment >= 8) {
        $insights[] = [
            'type' => 'warning',
            'message' => 'Minimal symptom improvement after ' . $weeksOnTreatment . ' weeks of treatment',
            'advice' => 'Consider treatment adherence, drug resistance, or comorbidities.'
        ];
    } elseif ($symptomImprovement === 'significant') {
        $insights[] = [
            'type' => 'success',
            'message' => 'Significant symptom improvement on treatment',
            'advice' => 'Continue current treatment regimen.'
        ];
    }

    return $insights;
}
?>