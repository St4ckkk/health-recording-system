<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'TB Symptoms Checker' ?></title>
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
            background: white;
            color: #1e293b;
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-content {
            background-color: white;
        }

        .nav-link {
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all var(--transition-normal);
        }

        .nav-link:hover {
            background-color: #f1f5f9;
        }

        .nav-link.active {
            background-color: #e2e8f0;
            font-weight: 600;
        }

        .header-content {
            backdrop-filter: blur(8px);
            background-color: rgba(99, 102, 241, 0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-right ul {
            display: flex;
            gap: 1rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all var(--transition-normal);
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        .nav-link i {
            font-size: 1.25rem;
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            .header-right ul {
                flex-wrap: wrap;
                justify-content: center;
            }
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

        /* Symptom Category Styles */
        .symptom-category {
            border-radius: 1rem;
            padding: 1.75rem;
            height: 100%;
            transition: transform var(--transition-normal);
        }

        .symptom-category:hover {
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

        /* Checkbox Styles */
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background-color var(--transition-fast);
        }

        .checkbox-container:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .checkbox-container:last-child {
            margin-bottom: 0;
        }

        .custom-checkbox {
            position: relative;
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 1.25rem;
            width: 1.25rem;
            background-color: #fff;
            border: 2px solid #cbd5e0;
            border-radius: 0.25rem;
            transition: all var(--transition-fast);
        }

        .respiratory .custom-checkbox input:checked~.checkmark {
            background-color: var(--respiratory-accent);
            border-color: var(--respiratory-accent);
        }

        .general .custom-checkbox input:checked~.checkmark {
            background-color: var(--general-accent);
            border-color: var(--general-accent);
        }

        .other .custom-checkbox input:checked~.checkmark {
            background-color: var(--other-accent);
            border-color: var(--other-accent);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 0.4rem;
            top: 0.2rem;
            width: 0.25rem;
            height: 0.5rem;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #4b5563;
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

        .progress-step.active:not(:last-child)::after {
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

        .progress-step.active .progress-circle {
            background-color: #6366f1;
            color: white;
        }

        .progress-text {
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
        }

        .progress-step.active .progress-text {
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

        /* Loader Styles */
        .circular-loader {
            width: 80px;
            height: 80px;
            position: relative;
            animation: rotate 2s linear infinite;
        }

        .loader-path {
            stroke-dasharray: 150, 200;
            stroke-dashoffset: -10;
            stroke-linecap: round;
            stroke-width: 4px;
            stroke: #6366f1;
            fill: none;
            animation: dash 1.5s ease-in-out infinite;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 4px solid transparent;
            border-top-color: #6366f1;
            border-radius: 50%;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes dash {
            0% {
                stroke-dasharray: 1, 150;
                stroke-dashoffset: 0;
            }

            50% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -35;
            }

            100% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -124;
            }
        }

        .progress-bar {
            transition: width 0.5s ease;
        }
    </style>
</head>

<body>
    <main class="container">
        <!-- Page Title -->
        <div class="page-title-container fade-in">
            <span class="page-badge">Health Assessment</span>
            <h1 class="page-title">TB Symptoms Checker</h1>
            <p class="page-description">
                Select the symptoms you are experiencing to check your risk of tuberculosis (TB).
                This tool uses machine learning to analyze your symptoms and provide a risk assessment.
            </p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-container fade-in">
            <div class="progress-step active">
                <div class="progress-circle">1</div>
                <div class="progress-text">Select Symptoms</div>
            </div>
            <div class="progress-step">
                <div class="progress-circle">2</div>
                <div class="progress-text">Analysis</div>
            </div>
            <div class="progress-step">
                <div class="progress-circle">3</div>
                <div class="progress-text">Results</div>
            </div>
        </div>

        <div class="card fade-in">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/analyze-symptoms" method="POST">
                    <div class="grid">
                        <div class="symptom-category respiratory">
                            <h2 class="category-title">
                                <i class='bx bx-lungs' style="font-size: 1.5rem;"></i>
                                Respiratory Symptoms
                            </h2>

                            <div>
                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="coughing_blood">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Coughing blood</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="sputum_blood">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Sputum mixed with blood</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="shortness_breath">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Shortness of breath</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="cough_phlegm">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Cough and phlegm (2-4 weeks)</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="chest_pain">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Chest pain</span>
                                </label>
                            </div>
                        </div>

                        <div class="symptom-category general">
                            <h2 class="category-title">
                                <i class='bx bx-body' style="font-size: 1.5rem;"></i>
                                General Symptoms
                            </h2>

                            <div>
                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="fever_two_weeks">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Fever for two weeks</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="night_sweats">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Night sweats</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="weight_loss">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Weight loss</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="body_tired">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Body feels tired</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="loss_appetite">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Loss of appetite</span>
                                </label>
                            </div>
                        </div>

                        <div class="symptom-category other">
                            <h2 class="category-title">
                                <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
                                Other Symptoms
                            </h2>

                            <div>
                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="back_pain">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Back pain in certain parts</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="lumps">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Lumps around armpits/neck</span>
                                </label>

                                <label class="checkbox-container">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="swollen_lymph">
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="checkbox-label">Swollen lymph nodes</span>
                                </label>
                            </div>
                        </div>

                        <div class="info-box">
                            <div class="mb-4">
                                <h2 class="category-title" style="color: #64748b;">
                                    <i class='bx bx-info-circle' style="font-size: 1.5rem;"></i>
                                    About TB
                                </h2>
                                <p class="text-sm">
                                    Tuberculosis (TB) is a potentially serious infectious disease that mainly affects
                                    the
                                    lungs.
                                    Early detection and treatment are crucial for preventing complications and spread.
                                </p>
                            </div>

                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">When to see a doctor:</h3>
                                <p class="text-sm">
                                    If you have a fever, unexplained weight loss, night sweats, or a persistent cough,
                                    see your doctor for proper evaluation, regardless of the results of this checker.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Symptoms Preview -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Selected Symptoms:</h3>
                        <div class="selected-symptoms" id="selectedSymptoms">
                            <span class="text-gray-500 text-sm italic">No symptoms selected yet</span>
                        </div>
                    </div>

                    <div class="disclaimer">
                        <div class="disclaimer-title">
                            <i class='bx bx-shield-quarter'></i>
                            Important Notice
                        </div>
                        <p>
                            This symptoms checker is for informational purposes only and is not a substitute for
                            professional
                            medical advice, diagnosis, or treatment. TB is diagnosed through various tests including
                            skin tests,
                            blood tests, chest X-rays, and sputum tests. Only a healthcare professional can diagnose TB.
                        </p>
                    </div>

                    <div class="flex justify-center mt-8">
                        <button type="submit" class="btn btn-primary btn-lg pulse" id="analyzeBtn">
                            <i class='bx bx-search-alt btn-icon'></i>
                            Analyze Symptoms
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Analysis Loader (Hidden by default) -->
    <div id="analysisLoader" class="card fade-in" style="display: none;">
        <div class="card-body text-center py-16">
            <div class="flex flex-col items-center justify-center">
                <!-- Animated Loader -->
                <div class="loader-container mb-8">
                    <img src="<?= BASE_URL ?>/images/loader.gif" alt="Loading..." width="150" height="150"
                        class="mx-auto">
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4">Analyzing Your Symptoms</h2>
                <p class="text-gray-600 max-w-md mx-auto mb-6">
                    Our AI system is processing your symptoms and calculating your TB risk profile.
                    This will only take a few moments.
                </p>

                <!-- Progress Indicator -->
                <div class="w-full max-w-md bg-gray-200 rounded-full h-2.5 mb-6">
                    <div class="bg-indigo-600 h-2.5 rounded-full progress-bar" style="width: 0%"></div>
                </div>

                <!-- Status Messages -->
                <div class="text-sm text-gray-500 status-message">Collecting symptom data...</div>
            </div>
        </div>
    </div>
    </main>

    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
    <script>
        // Simple script to show selected symptoms
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const selectedSymptomsContainer = document.getElementById('selectedSymptoms');
            const analyzeBtn = document.getElementById('analyzeBtn');
            const analysisLoader = document.getElementById('analysisLoader');
            const form = document.querySelector('form');
            const progressBar = document.querySelector('.progress-bar');
            const statusMessage = document.querySelector('.status-message');
            const mainCard = document.querySelector('.card:not(#analysisLoader)');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedSymptoms);
            });

            function updateSelectedSymptoms() {
                const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');

                if (selectedCheckboxes.length === 0) {
                    selectedSymptomsContainer.innerHTML = '<span class="text-gray-500 text-sm italic">No symptoms selected yet</span>';
                    return;
                }

                selectedSymptomsContainer.innerHTML = '';

                selectedCheckboxes.forEach(checkbox => {
                    const label = checkbox.closest('.checkbox-container').querySelector('.checkbox-label').textContent;
                    const category = checkbox.closest('.symptom-category').querySelector('.category-title').textContent.trim();
                    let iconClass = 'bx-plus-medical';
                    let color = '#805ad5';

                    if (category.includes('Respiratory')) {
                        iconClass = 'bx-lungs';
                        color = '#4361ee';
                    } else if (category.includes('General')) {
                        iconClass = 'bx-body';
                        color = '#38b2ac';
                    }

                    const tag = document.createElement('span');
                    tag.className = 'symptom-tag';
                    tag.innerHTML = `<i class='bx ${iconClass}' style="color: ${color}"></i>${label}`;
                    selectedSymptomsContainer.appendChild(tag);
                });
            }

            // Add form submission handler with 5-second loader
            if (form) {
                form.addEventListener('submit', function (e) {
                    const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                    if (selectedCheckboxes.length > 0) {
                        e.preventDefault(); // Prevent immediate form submission

                        // Update progress steps
                        const progressSteps = document.querySelectorAll('.progress-step');
                        progressSteps[0].classList.remove('active');
                        progressSteps[1].classList.add('active');

                        // Hide the main card and show the loader
                        mainCard.style.display = 'none';
                        analysisLoader.style.display = 'block';

                        // Animate the progress bar over 5 seconds
                        let progress = 0;
                        const totalTime = 5000; // 5 seconds
                        const interval = 50; // Update every 50ms
                        const increment = (interval / totalTime) * 100;

                        const progressInterval = setInterval(() => {
                            progress += increment;
                            if (progress > 100) progress = 100;
                            progressBar.style.width = `${progress}%`;

                            // Update status messages based on progress
                            if (progress < 25) {
                                statusMessage.textContent = 'Collecting symptom data...';
                            } else if (progress < 50) {
                                statusMessage.textContent = 'Running TB risk assessment algorithm...';
                            } else if (progress < 75) {
                                statusMessage.textContent = 'Analyzing symptom patterns...';
                            } else {
                                statusMessage.textContent = 'Finalizing results...';
                            }

                            if (progress >= 100) {
                                clearInterval(progressInterval);
                                // Submit the form after reaching 100%
                                setTimeout(() => {
                                    form.submit();
                                }, 300); // Small delay to show 100% completion
                            }
                        }, interval);
                    }
                });
            }
        });
    </script>

    <!-- Add these styles to the existing style section in the head -->
    <style>

    </style>
</body>

</html>