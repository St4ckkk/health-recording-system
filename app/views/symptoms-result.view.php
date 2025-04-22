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
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --respiratory-bg: #f0f7ff;
            --respiratory-accent: #4361ee;
            --general-bg: #f0fff4;
            --general-accent: #38b2ac;
            --other-bg: #faf5ff;
            --other-accent: #805ad5;
            --info-bg: #f7fafc;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

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
    <!-- Modern Header with Glassmorphism -->
    <header>
        <div class="header-content">
            <div class="header-container container">
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class='bx bx-plus-medical text-2xl text-indigo-600'></i>
                    </div>
                    <h1 class="logo-text">Health Recording System</h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/" class="nav-link"><i class='bx bx-home-alt'></i> Home</a></li>
                        <li><a href="<?= BASE_URL ?>/appointment/doctor-availability" class="nav-link"><i class='bx bx-calendar-check'></i> Appointments</a></li>
                        <li><a href="<?= BASE_URL ?>/symptoms-checker" class="nav-link active"><i class='bx bx-check-shield'></i> TB Checker</a></li>
                        <li><a href="<?= BASE_URL ?>/appointment-tracking" class="nav-link"><i class='bx bx-radar'></i> Track</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

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
            <div class="card" style="grid-column: span 2;">
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
                                        <span class="text-sm font-medium text-red-700">Immediate attention recommended</span>
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
                                        <span class="text-sm font-medium text-green-700">Continue monitoring your health</span>
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
                                            <span class="text-gray-700">Mention this TB risk assessment to your healthcare provider</span>
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
                                            <span class="text-gray-700">If symptoms persist or worsen, consult a healthcare provider</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class='bx bx-right-arrow-alt text-indigo-600 mt-1 mr-2'></i>
                                            <span class="text-gray-700">Maintain good respiratory hygiene and a healthy lifestyle</span>
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
                                            <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
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
                                            Your symptom profile suggests a lower probability of TB. However, this does not rule out the possibility completely.
                                        <?php elseif ($probability < 70): ?>
                                            Your symptom profile suggests a moderate probability of TB. It's advisable to consult with a healthcare professional.
                                        <?php else: ?>
                                            Your symptom profile suggests a higher probability of TB. Please seek medical attention promptly.
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
                                <span class="text-gray-700">Absent Symptoms (<?= $totalSymptoms - $symptomCount ?>)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Selected Symptoms -->
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
                        function getSymptomCategory($symptom, $categories) {
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
                            <div class="symptom-tag <?= $categoryData['bg'] ?> border <?= $categoryData['border'] ?> p-3 rounded-lg flex items-center">
                                <i class='bx <?= $categoryData['icon'] ?> <?= $categoryData['text'] ?> mr-2'></i>
                                <span class="text-gray-700"><?= $symptomLabel ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
        
        <!-- Important Note -->
        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl shadow-md p-6 border border-yellow-100 mb-10">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-amber-100 p-2 rounded-full">
                    <i class='bx bx-info-circle text-2xl text-amber-600'></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Important Note</h3>
                    <div class="text-amber-700 space-y-2">
                        <p>
                            This analysis is based on the symptoms you've reported and uses machine learning to estimate risk.
                            It is not a medical diagnosis. TB can only be diagnosed by a healthcare professional through proper testing.
                        </p>
                        <p>
                            If you're experiencing concerning symptoms, please consult with a healthcare provider regardless of the results shown here.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            <a href="<?= BASE_URL ?>/symptoms-checker" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                <i class='bx bx-left-arrow-alt mr-2'></i> Back to Checker
            </a>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="<?= BASE_URL ?>/learn-about-tb" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                    <i class='bx bx-book-open mr-2'></i> Learn About TB
                </a>
                
                <a href="<?= BASE_URL ?>/appointment/doctor-availability" class="bg-gradient-to-r from-violet-600 to-indigo-700 hover:from-violet-700 hover:to-indigo-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-300 flex items-center justify-center">
                    <i class='bx bx-calendar-plus mr-2'></i> Book an Appointment
                </a>
            </div>
        </div>
    </main>

    <!-- Modern Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="bg-white p-2 rounded-full shadow-md mr-3">
                            <i class='bx bx-plus-medical text-xl text-indigo-600'></i>
                        </div>
                        <h3 class="text-xl font-bold">Health Recording System</h3>
                    </div>
                    <p class="text-gray-400 mb-4 max-w-md">
                        Providing advanced health monitoring and diagnostic tools to help you stay informed about your health and make better healthcare decisions.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class='bx bxl-facebook text-xl'></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class='bx bxl-twitter text-xl'></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 h-10 w-10 rounded-full flex items-center justify-center transition duration-300">
                            <i class='bx bxl-instagram text-xl'></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-800 pb-2">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?= BASE_URL ?>/" class="hover:text-white transition duration-300 flex items-center"><i class='bx bx-chevron-right text-sm mr-2'></i> Home</a></li>
                        <li><a href="<?= BASE_URL ?>/appointment/doctor-availability" class="hover:text-white transition duration-300 flex items-center"><i class='bx bx-chevron-right text-sm mr-2'></i> Book Appointment</a></li>
                        <li><a href="<?= BASE_URL ?>/symptoms-checker" class="hover:text-white transition duration-300 flex items-center"><i class='bx bx-chevron-right text-sm mr-2'></i> TB Symptoms Checker</a></li>
                        <li><a href="<?= BASE_URL ?>/appointment-tracking" class="hover:text-white transition duration-300 flex items-center"><i class='bx bx-chevron-right text-sm mr-2'></i> Track Appointment</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-800 pb-2">Contact</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class='bx bx-envelope text-indigo-400 mt-1 mr-3'></i> 
                            <span>support@healthsystem.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class='bx bx-phone text-indigo-400 mt-1 mr-3'></i> 
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-start">
                            <i class='bx bx-map text-indigo-400 mt-1 mr-3'></i> 
                            <span>123 Medical Center Dr, Health City</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">&copy; <?= date('Y') ?> Health Recording System. All rights reserved.</p>
                <div class="mt-4 md:mt-0">
                    <ul class="flex space-x-6 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-white transition duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prepare data for the chart
            const ctx = document.getElementById('symptomsChart').getContext('2d');
            
            <?php
            // Prepare data for the doughnut chart
            $presentCount = $symptomCount;
            $absentCount = $totalSymptoms - $symptomCount;
            ?>
            
            const data = {
                labels: ['Present Symptoms', 'Absent Symptoms'],
                datasets: [{
                    data: [<?= $presentCount ?>, <?= $absentCount ?>],
                    backgroundColor: [
                        '<?= $probability < 30 ? "rgba(16, 185, 129, 0.8)" : 
                            ($probability < 70 ? "rgba(245, 158, 11, 0.8)" : "rgba(239, 68, 68, 0.8)") ?>',
                        'rgba(209, 213, 219, 0.8)'
                    ],
                    borderColor: [
                        '<?= $probability < 30 ? "rgb(16, 185, 129)" : 
                            ($probability < 70 ? "rgb(245, 158, 11)" : "rgb(239, 68, 68)") ?>',
                        'rgb(209, 213, 219)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            };
            
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                boxWidth: 12,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            },
                            titleFont: {
                                family: "'Inter', sans-serif"
                            },
                            bodyFont: {
                                family: "'Inter', sans-serif"
                            },
                            padding: 12,
                            boxPadding: 6
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            };
            
            new Chart(ctx, config);
            
            // Animate the probability bar on load
            const probabilityBar = document.querySelector('.h-3 .absolute');
            if (probabilityBar) {
                probabilityBar.style.width = '0%';
                setTimeout(() => {
                    probabilityBar.style.width = '<?= $probability ?>%';
                }, 300);
            }
        });
    </script>
</body>
</html>