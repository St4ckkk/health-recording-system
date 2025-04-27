<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TB Symptoms Analysis' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/result.css">

    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, #6366f1, #4f46e5);
            color: white;
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-content {
            backdrop-filter: blur(8px);
            background-color: rgba(99, 102, 241, 0.3);
        }

        .header-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
        }

        @media (min-width: 768px) {
            .header-container {
                flex-direction: row;
            }
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .logo-container {
                margin-bottom: 0;
            }
        }

        .logo-icon {
            background-color: white;
            padding: 0.5rem;
            border-radius: 9999px;
            box-shadow: var(--shadow-md);
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
        }

        nav ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        nav a {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 9999px;
            color: white;
            text-decoration: none;
            transition: background-color var(--transition-normal);
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        nav a.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        nav i {
            margin-right: 0.25rem;
        }

        /* Card Styles */
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-body {
            padding: 2rem;
        }

        .card-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
        }

        /* Page Title Styles */
        .page-title-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            background-color: #e0e7ff;
            color: #4338ca;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
        }

        .page-description {
            color: #64748b;
            max-width: 42rem;
            margin: 0 auto;
        }

        /* Result Category Styles */
        .result-category {
            border-radius: 1rem;
            padding: 1.75rem;
            height: 100%;
            transition: transform var(--transition-normal);
        }

        .result-category:hover {
            transform: translateY(-5px);
        }

        .category-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .respiratory {
            background-color: var(--respiratory-bg);
            border-left: 5px solid var(--respiratory-accent);
        }

        .respiratory .category-title {
            color: var(--respiratory-accent);
        }

        .general {
            background-color: var(--general-bg);
            border-left: 5px solid var(--general-accent);
        }

        .general .category-title {
            color: var(--general-accent);
        }

        .other {
            background-color: var(--other-bg);
            border-left: 5px solid var(--other-accent);
        }

        .other .category-title {
            color: var(--other-accent);
        }

        .info-box {
            background-color: var(--info-bg);
            border-radius: 1rem;
            padding: 1.75rem;
            height: 100%;
            border-left: 5px solid #64748b;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all var(--transition-normal);
            cursor: pointer;
            outline: none;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(to right, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 4px 6px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #4f46e5, #4338ca);
            box-shadow: 0 6px 8px rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .btn-icon {
            margin-right: 0.5rem;
            font-size: 1.25rem;
        }

        /* Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 1024px) {
            .grid-3 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Disclaimer Styles */
        .disclaimer {
            background-color: #fffbeb;
            border-left: 5px solid #f59e0b;
            padding: 1.25rem;
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .disclaimer-title {
            font-weight: 600;
            color: #b45309;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* Animation Styles */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
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

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        /* Progress Indicator */
        .progress-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 1rem;
            width: 100%;
            height: 2px;
            background-color: #e5e7eb;
            left: 50%;
            z-index: 0;
        }

        .progress-step.active:not(:last-child)::after,
        .progress-step.completed:not(:last-child)::after {
            background-color: #6366f1;
        }

        .progress-circle {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #9ca3af;
            margin-bottom: 0.5rem;
            z-index: 1;
            position: relative;
        }

        .progress-step.active .progress-circle,
        .progress-step.completed .progress-circle {
            background-color: #6366f1;
            color: white;
        }

        .progress-text {
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
        }

        .progress-step.active .progress-text,
        .progress-step.completed .progress-text {
            color: #4b5563;
            font-weight: 500;
        }

        /* Symptom Tag Styles */
        .symptom-tag {
            display: inline-flex;
            align-items: center;
            background-color: #f3f4f6;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
            transition: all var(--transition-fast);
        }

        .symptom-tag:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .symptom-tag i {
            margin-right: 0.25rem;
            font-size: 1rem;
        }

        /* Risk Assessment Styles */
        .risk-high {
            background-color: #fee2e2;
            border-left: 5px solid #ef4444;
        }

        .risk-high .category-title {
            color: #b91c1c;
        }

        .risk-low {
            background-color: #dcfce7;
            border-left: 5px solid #10b981;
        }

        .risk-low .category-title {
            color: #047857;
        }

        .risk-indicator {
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        .risk-dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .risk-dot.high {
            background-color: #ef4444;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .risk-dot.low {
            background-color: #10b981;
        }

        /* Chart Container */
        .chart-container {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.75rem;
            height: 16rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <main class="container">
        <!-- Page Title -->
        <div class="page-title-container fade-in">
            <span class="page-badge">Analysis Complete</span>
            <h1 class="page-title">TB Symptoms Analysis Results</h1>
            <p class="page-description">
                Based on the symptoms you've reported, we've analyzed your risk profile for tuberculosis.
                Please review the results below.
            </p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-container fade-in">
            <div class="progress-step completed">
                <div class="progress-circle">
                    <i class='bx bx-check'></i>
                </div>
                <div class="progress-text">Select Symptoms</div>
            </div>
            <div class="progress-step completed">
                <div class="progress-circle">
                    <i class='bx bx-check'></i>
                </div>
                <div class="progress-text">Analysis</div>
            </div>
            <div class="progress-step active">
                <div class="progress-circle">3</div>
                <div class="progress-text">Results</div>
            </div>
        </div>

        <div class="grid-3 fade-in">
            <!-- Risk Assessment Card -->
            <div class="card card-span-2">
                <div class="card-body">
                    <h2 class="category-title" style="color: #4f46e5; font-size: 1.5rem;">
                        <i class='bx bx-shield-quarter text-2xl mr-3'></i>
                        Risk Assessment
                    </h2>

                    <div class="grid">
                        <!-- Risk Level -->
                        <div>
                            <?php if ($prediction === 'High Risk'): ?>
                                <div class="result-category risk-high">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-red-100 p-2 rounded-full">
                                            <i class='bx bx-error-circle text-2xl text-red-600'></i>
                                        </div>
                                        <h3 class="ml-3 text-xl font-bold text-red-700">High Risk</h3>
                                    </div>
                                    <p class="text-red-700">
                                        Based on your symptoms, you may be at high risk for TB.
                                        Please consult a healthcare professional as soon as possible.
                                    </p>
                                    <div class="risk-indicator">
                                        <span class="risk-dot high"></span>
                                        <span class="text-sm font-medium text-red-700">Immediate attention
                                            recommended</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="result-category risk-low">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <i class='bx bx-check-circle text-2xl text-green-600'></i>
                                        </div>
                                        <h3 class="ml-3 text-xl font-bold text-green-700">Low Risk</h3>
                                    </div>
                                    <p class="text-green-700">
                                        Based on your symptoms, you appear to be at lower risk for TB.
                                        However, if symptoms persist, please consult a healthcare professional.
                                    </p>
                                    <div class="risk-indicator">
                                        <span class="risk-dot low"></span>
                                        <span class="text-sm font-medium text-green-700">Continue monitoring your
                                            health</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Next Steps -->
                            <div class="info-box mt-6">
                                <h3 class="category-title" style="color: #64748b; margin-bottom: 0.75rem;">
                                    <i class='bx bx-list-check text-xl mr-2'></i>
                                    Recommended Next Steps
                                </h3>
                                <ul class="space-y-2">
                                    <?php if ($prediction === 'High Risk'): ?>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Schedule an appointment with a doctor</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Mention this TB risk assessment to your healthcare
                                                provider</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Consider getting a TB skin test or blood test</span>
                                        </li>
                                    <?php else: ?>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Continue monitoring your symptoms</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">If symptoms persist or worsen, consult a healthcare
                                                provider</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Maintain good respiratory hygiene and a healthy
                                                lifestyle</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Probability Analysis -->
                        <div>
                            <div class="info-box h-full">
                                <h3 class="category-title" style="color: #64748b; margin-bottom: 0.75rem;">
                                    <i class='bx bx-line-chart text-xl mr-2'></i>
                                    Probability Analysis
                                </h3>

                                <div class="mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <div>
                                            <span class="text-3xl font-bold 
                                                <?= $probability < 30 ? 'text-green-600' :
                                                    ($probability < 70 ? 'text-yellow-600' : 'text-red-600') ?>">
                                                <?= $probability ?>%
                                            </span>
                                            <span class="text-gray-500 text-sm ml-1">Probability</span>
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                                <?= $symptomCount ?> of <?= $totalSymptoms ?> symptoms
                                            </span>
                                        </div>
                                    </div>

                                    <div class="h-3 relative max-w-xl rounded-full overflow-hidden bg-gray-200">
                                        <div class="absolute h-full rounded-full transition-all duration-500 ease-out
                                            <?= $probability < 30 ? 'bg-green-500' :
                                                ($probability < 70 ? 'bg-yellow-500' : 'bg-red-500') ?>"
                                            style="width: <?= $probability ?>%">
                                        </div>
                                    </div>

                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>Low</span>
                                        <span>Medium</span>
                                        <span>High</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-700 mb-2">Risk Interpretation</h4>
                                    <p class="text-sm text-gray-600">
                                        <?php if ($probability < 30): ?>
                                            Your symptom profile suggests a lower probability of TB. However, this does not
                                            rule out the possibility completely.
                                        <?php elseif ($probability < 70): ?>
                                            Your symptom profile suggests a moderate probability of TB. It's advisable to
                                            consult with a healthcare professional.
                                        <?php else: ?>
                                            Your symptom profile suggests a higher probability of TB. Please seek medical
                                            attention promptly.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Symptom Distribution Chart -->
            <div class="card">
                <div class="card-body">
                    <h2 class="category-title" style="color: #4f46e5; font-size: 1.5rem;">
                        <i class='bx bx-pie-chart-alt-2 text-2xl mr-3'></i>
                        Symptom Distribution
                    </h2>

                    <div class="chart-container">
                        <canvas id="symptomsChart"></canvas>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full mr-2
                                    <?= $probability < 30 ? 'bg-green-500' :
                                        ($probability < 70 ? 'bg-yellow-500' : 'bg-red-500') ?>"></span>
                                <span class="text-gray-700">Present Symptoms (<?= $symptomCount ?>)</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 bg-gray-300 rounded-full mr-2"></span>
                                <span class="text-gray-700">Absent Symptoms
                                    (<?= $totalSymptoms - $symptomCount ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card fade-in mt-8">
            <div class="card-header">
                <h2 class="category-title" style="color: #4f46e5; font-size: 1.5rem; margin-bottom: 0;">
                    <i class='bx bx-plus-medical text-2xl mr-3'></i>
                    Treatment Recommendations
                </h2>
            </div>
            <div class="card-body">
                <div class="grid-3">
                    <!-- Treatment Overview -->
                    <div class="info-box">
                        <h3 class="category-title" style="color: #64748b; margin-bottom: 0.75rem;">
                            <i class='bx bx-capsule text-xl mr-2'></i>
                            Treatment Overview
                        </h3>

                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Symptom Severity</span>
                                <span class="text-sm font-medium text-gray-700">
                                    <?= $treatmentData['symptom_severity_score'] ?>/10
                                </span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div id="severityGauge" class="h-full rounded-full transition-all duration-1000 ease-out
                                    <?php if ($treatmentData['symptom_severity_score'] < 4): ?>
                                    bg-green-500
                                    <?php elseif ($treatmentData['symptom_severity_score'] < 7): ?>
                                    bg-yellow-500
                                    <?php else: ?>
                                    bg-red-500
                                    <?php endif; ?>" style="width: 0%">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mt-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Diagnosis Probability:</span>
                                <span class="text-sm font-medium ml-2 <?php if ($probability < 30): ?>
                                    text-green-600
                                    <?php elseif ($probability < 70): ?>
                                    text-yellow-600
                                    <?php else: ?>
                                    text-red-600
                                    <?php endif; ?>">
                                    <?= $probability ?>%
                                </span>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Diagnosis Status:</span>
                                <span
                                    class="text-sm font-medium ml-2 <?= $treatmentData['diagnosis_confirmed'] ? 'text-red-600' : 'text-gray-600' ?>">
                                    <?= $treatmentData['diagnosis_confirmed'] ? 'Likely TB' : 'Requires Confirmation' ?>
                                </span>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-500">Treatment Duration:</span>
                                <span class="text-sm font-medium ml-2 text-gray-700">
                                    <?= $treatmentData['treatment_duration_weeks'] > 0 ? $treatmentData['treatment_duration_weeks'] . ' weeks' : 'N/A' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Tests -->
                    <div class="info-box">
                        <h3 class="category-title" style="color: #64748b; margin-bottom: 0.75rem;">
                            <i class='bx bx-test-tube text-xl mr-2'></i>
                            Recommended Tests
                        </h3>

                        <?php if (empty($treatmentData['recommended_tests'])): ?>
                            <p class="text-gray-600 text-sm">No specific tests recommended at this time.</p>
                        <?php else: ?>
                            <ul class="space-y-2">
                                <?php foreach ($treatmentData['recommended_tests'] as $test): ?>
                                    <li class="flex items-start">
                                        <i class='bx bx-check-circle text-indigo-600 mt-0.5 mr-2'></i>
                                        <span class="text-gray-700 text-sm">
                                            <?= $test ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Why These Tests?</h4>
                            <p class="text-xs text-gray-600">
                                These tests are recommended based on your symptom profile and risk assessment.
                                They help healthcare providers confirm a TB diagnosis and determine the most
                                effective treatment approach.
                            </p>
                        </div>
                    </div>

                    <!-- Treatment Regimen -->
                    <div class="info-box">
                        <h3 class="category-title" style="color: #64748b; margin-bottom: 0.75rem;">
                            <i class='bx bx-calendar-check text-xl mr-2'></i>
                            Treatment Plan
                        </h3>

                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Recommended Regimen:</span>
                                <p class=" text-sm text-gray-600 mt-1">
                                    <?= $treatmentData['treatment_regimen'] ?>
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-700">Follow-up Schedule:</span>
                                <p class=" text-sm text-gray-600 mt-1">
                                    <?= $treatmentData['follow_up_schedule'] ?>
                                </p>
                            </div>

                            <div>
                                <span class="text-sm font-medium text-gray-700">Special Considerations:</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <?php if ($treatmentData['isolation_required']): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class='bx bx-shield-quarter mr-1'></i> Isolation Recommended
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($treatmentData['hospitalization_needed']): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class='bx bx-building-house mr-1'></i> Hospitalization Advised
                                        </span>
                                    <?php endif; ?>

                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class='bx bx-food-menu mr-1'></i> Nutritional Support
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment Timeline Chart -->
                <?php if ($treatmentData['treatment_duration_weeks'] > 0): ?>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Treatment Timeline</h3>
                        <div class="chart-container" style="height: 12rem;">
                            <canvas id="treatmentTimelineChart"></canvas>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <p>Standard TB treatment consists of an intensive phase (typically 2 months) followed by a
                                continuation phase (4-7 months).</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Nutritional Support -->
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                            <i class='bx bx-food-menu text-xl text-blue-600'></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-md font-medium text-blue-800 mb-1">Nutritional Recommendations</h3>
                            <p class="text-sm text-blue-700">
                                <?= $treatmentData['nutritional_support'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Symptom Category Analysis -->
        <div class="card fade-in mt-8">
            <div class="card-header">
                <h2 class="category-title" style="color: #4f46e5; font-size: 1.5rem; margin-bottom: 0;">
                    <i class='bx bx-analyse text-2xl mr-3'></i>
                    Detailed Symptom Analysis
                </h2>
            </div>
            <div class="card-body">
                <div class="grid">
                    <!-- Symptom Categories Chart -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Symptom Categories</h3>
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <p>This chart shows the distribution of your symptoms across different categories.</p>
                        </div>
                    </div>

                    <!-- Category Breakdown -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-3">Category Breakdown</h3>

                        <div class="space-y-4">
                            <!-- Respiratory Symptoms -->
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-medium text-blue-800">Respiratory Symptoms</h4>
                                    <span class="text-sm font-medium text-blue-700">
                                        <?= $symptomCategories['respiratory']['count'] ?>/
                                        <?= $symptomCategories['respiratory']['total'] ?>
                                    </span>
                                </div>
                                <div class="h-2 bg-blue-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full"
                                        style=" width: <?= $symptomCategories['respiratory']['percentage'] ?>%">
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-blue-700">
                                    Respiratory symptoms are directly related to the lungs and breathing system.
                                </p>
                            </div>

                            <!-- General Symptoms -->
                            <div class="bg-violet-50 rounded-lg p-4 border border-violet-100">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-medium text-violet-800">General Symptoms</h4>
                                    <span class="text-sm font-medium text-violet-700">
                                        <?= $symptomCategories['general']['count'] ?>/
                                        <?= $symptomCategories['general']['total'] ?>
                                    </span>
                                </div>
                                <div class="h-2 bg-violet-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-violet-500 rounded-full"
                                        style=" width: <?= $symptomCategories['general']['percentage'] ?>%">
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-violet-700">
                                    General symptoms affect the whole body and overall health.
                                </p>
                            </div>

                            <!-- Other Symptoms -->
                            <div class="bg-fuchsia-50 rounded-lg p-4 border border-fuchsia-100">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-medium text-fuchsia-800">Other Symptoms</h4>
                                    <span class="text-sm font-medium text-fuchsia-700">
                                        <?= $symptomCategories['other']['count'] ?>/
                                        <?= $symptomCategories['other']['total'] ?>
                                    </span>
                                </div>
                                <div class="h-2 bg-fuchsia-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-fuchsia-500 rounded-full"
                                        style=" width: <?= $symptomCategories['other']['percentage'] ?>%">
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-fuchsia-700">
                                    Other symptoms may include lymphatic or musculoskeletal manifestations.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="symptomCount" value="<?= $symptomCount ?>">
        <input type="hidden" id="totalSymptoms" value="<?= $totalSymptoms ?>">
        <input type="hidden" id="probability" value="<?= $probability ?>">
        <input type="hidden" id="respiratoryPercentage" value="<?= $symptomCategories['respiratory']['percentage'] ?>">
        <input type="hidden" id="generalPercentage" value="<?= $symptomCategories['general']['percentage'] ?>">
        <input type="hidden" id="otherPercentage" value="<?= $symptomCategories['other']['percentage'] ?>">
        <input type="hidden" id="treatmentDuration" value="<?= $treatmentData['treatment_duration_weeks'] ?>">
        <input type="hidden" id="severityScore" value="<?= $treatmentData['symptom_severity_score'] ?>">
        <div class="mb-10">
            <div class="card fade-in">
                <div class="card-body">
                    <h2 class="category-title" style="color: #4f46e5; font-size: 1.5rem;">
                        <i class='bx bx-list-ul text-2xl mr-3'></i>
                        Your Selected Symptoms
                    </h2>

                    <?php if (empty($selectedSymptoms)): ?>
                        <div class="bg-gray-50 p-6 rounded-lg text-center">
                            <i class='bx bx-info-circle text-4xl text-gray-400 mb-2'></i>
                            <p class="text-gray-600">No symptoms were selected.</p>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <?php
                            // Define symptom categories and their colors
                            $symptomCategories = [
                                'respiratory' => [
                                    'symptoms' => ['coughing_blood', 'sputum_blood', 'shortness_breath', 'cough_phlegm', 'chest_pain'],
                                    'bg' => 'bg-blue-50',
                                    'border' => 'border-blue-200',
                                    'text' => 'text-blue-700',
                                    'icon' => 'bx-lungs'
                                ],
                                'general' => [
                                    'symptoms' => ['fever_two_weeks', 'night_sweats', 'weight_loss', 'body_tired', 'loss_appetite'],
                                    'bg' => 'bg-violet-50',
                                    'border' => 'border-violet-200',
                                    'text' => 'text-violet-700',
                                    'icon' => 'bx-body'
                                ],
                                'other' => [
                                    'symptoms' => ['back_pain', 'lumps', 'swollen_lymph'],
                                    'bg' => 'bg-fuchsia-50',
                                    'border' => 'border-fuchsia-200',
                                    'text' => 'text-fuchsia-700',
                                    'icon' => 'bx-pulse'
                                ]
                            ];

                            // Helper function to get symptom category
                            function getSymptomCategory($symptom, $categories)
                            {
                                foreach ($categories as $category => $data) {
                                    if (in_array($symptom, $data['symptoms'])) {
                                        return $category;
                                    }
                                }
                                return 'other';
                            }

                            foreach ($selectedSymptoms as $symptomKey => $symptomLabel):
                                $category = getSymptomCategory($symptomKey, $symptomCategories);
                                $categoryData = $symptomCategories[$category];
                                ?>
                                <div
                                    class="symptom-tag <?= $categoryData['bg'] ?> border <?= $categoryData['border'] ?> p-3 rounded-lg flex items-center">
                                    <i class='bx <?= $categoryData['icon'] ?> <?= $categoryData['text'] ?> mr-2'></i>
                                    <span class="text-gray-700"><?= $symptomLabel ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Important Note -->
                <div
                    class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl shadow-md p-6 border border-yellow-100 mb-10">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-amber-100 p-2 rounded-full">
                            <i class='bx bx-info-circle text-2xl text-amber-600'></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-amber-800 mb-2">Important Note</h3>
                            <div class="text-amber-700 space-y-2">
                                <p>
                                    This analysis is based on the symptoms you've reported and uses machine learning to
                                    estimate risk.
                                    It is not a medical diagnosis. TB can only be diagnosed by a healthcare professional
                                    through proper testing.
                                </p>
                                <p>
                                    If you're experiencing concerning symptoms, please consult with a healthcare
                                    provider
                                    regardless of the results shown here.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="<?= BASE_URL ?>/symptoms-checker" class="btn-back">
                        <i class='bx bx-left-arrow-alt mr-2'></i> Back to Checker
                    </a>

                    <div class="action-group">
                        <a href="<?= BASE_URL ?>/learn-about-tb" class="btn-learn">
                            <i class='bx bx-book-open mr-2'></i> Learn About TB
                        </a>

                        <a href="<?= BASE_URL ?>/appointment/doctor-availability" class="btn-appointment">
                            <i class='bx bx-calendar-plus mr-2'></i> Book an Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="<?= BASE_URL ?>/js/symptoms-chart.js"></script>


</body>