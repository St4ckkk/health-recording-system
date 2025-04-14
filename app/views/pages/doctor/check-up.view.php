<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/doctor/checkup.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/doctor/vitals-card.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .back-button:hover {
            background-color: #e5e7eb;
        }

        .back-button i {
            margin-right: 0.5rem;
        }

        /* Glowing tab styles */
        .tab-button {
            position: relative;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: #6B7280;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        .tab-button.active {
            color: #16a34a;
            border-bottom-color: #16a34a;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #16a34a;
            box-shadow: 0 0 8px #16a34a, 0 0 12px #16a34a;
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 4px #16a34a, 0 0 8px #16a34a;
            }

            to {
                box-shadow: 0 0 8px #16a34a, 0 0 16px #16a34a;
            }
        }

        /* Complete Checkup button styles */
        .complete-checkup-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: #3B82F6;
            color: white;
            font-weight: 500;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .complete-checkup-btn:hover {
            background-color: #2563EB;
        }

        .complete-checkup-btn i {
            margin-right: 0.5rem;
        }

        /* Pulse animation for the button */
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        /* Shine effect for the button */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0) 100%);
            transform: rotate(30deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(30deg);
            }

            100% {
                transform: translateX(100%) rotate(30deg);
            }
        }

        /* Floating action button for quick save */
        .floating-save-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background-color: #3B82F6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .floating-save-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .floating-save-btn i {
            font-size: 1.5rem;
        }

        /* Glowing effect for the floating button */
        .glow-effect {
            animation: glow-float 2s infinite alternate;
        }

        @keyframes glow-float {
            from {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0 0 rgba(59, 130, 246, 0.4);
            }

            to {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0 20px rgba(59, 130, 246, 0.7);
            }
        }

        /* Highlight for important fields */
        .highlight-field {
            position: relative;
        }

        .highlight-field::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 0.5rem;
            border: 2px solid #3B82F6;
            animation: highlight-pulse 2s infinite;
            pointer-events: none;
        }

        @keyframes highlight-pulse {
            0% {
                border-color: rgba(59, 130, 246, 0.7);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                border-color: rgba(59, 130, 246, 0.9);
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
            }

            100% {
                border-color: rgba(59, 130, 246, 0.7);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
        }

        /* Action buttons container */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #E5E7EB;
        }

        /* Save draft button */
        .save-draft-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: white;
            color: #374151;
            font-weight: 500;
            border-radius: 0.375rem;
            border: 1px solid #E5E7EB;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .save-draft-btn:hover {
            background-color: #F9FAFB;
        }

        .save-draft-btn i {
            margin-right: 0.5rem;
        }

        /* Fix for double scrollbar issue */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main-content {
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            overflow: hidden;
        }

        section.p-6 {
            height: 100%;
            overflow-y: auto;
            padding-bottom: 100px;
            /* Add extra padding at bottom for floating buttons */
        }

        /* Ensure tab content doesn't create its own scrollbar */
        .tab-content {
            overflow: visible;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Back button -->
                    <div class="mb-4">
                        <a href="<?= BASE_URL ?>/doctor/patientView"
                            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                            <button class="back-button">
                                <i class="bx bx-arrow-back mr-2"></i> Back
                            </button>
                        </a>
                    </div>

                    <!-- Patient info summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                                <?php if (!empty($patient->profile)): ?>
                                    <img src="<?= BASE_URL . '/' . $patient->profile ?>"
                                        class="w-full h-full object-cover rounded-full">
                                <?php else: ?>
                                    <i class="bx bx-user text-xl text-gray-400"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold uppercase">
                                    <?= htmlspecialchars($patient->first_name . ' ' . $patient->last_name) ?>
                                </h3>
                                <div class="flex text-sm text-gray-500 gap-4">
                                    <span><?= isset($patient->age) ? $patient->age : '43' ?> years</span>
                                    <span>•</span>
                                    <span><?= isset($patient->gender) ? ucfirst($patient->gender) : 'Male' ?></span>
                                    <span>•</span>
                                    <span>Blood Type:
                                        <?= isset($patient->blood_type) ? $patient->blood_type : 'A+' ?></span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <div class="text-sm text-gray-500">Checkup Date</div>
                                <div class="font-medium"><?= date('M d, Y') ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex">
                            <button class="tab-button active" data-tab="vitals">Vital Signs</button>
                            <button class="tab-button" data-tab="medications">Medications</button>
                            <button class="tab-button" data-tab="diagnosis">Diagnosis</button>
                        </div>
                    </div>

                    <!-- Vitals Tab Component -->
                    <div id="vitals-tab" class="tab-content active">
                        <?php include(VIEW_ROOT . '/pages/doctor/components/checkup/vitals.php') ?>
                    </div>

                    <!-- Medications Tab Component -->
                    <div id="medications-tab" class="tab-content">
                        <?php include(VIEW_ROOT . '/pages/doctor/components/checkup/medications.php') ?>
                    </div>

                    <!-- Diagnosis Tab Component -->
                    <div id="diagnosis-tab" class="tab-content">
                        <?php include(VIEW_ROOT . '/pages/doctor/components/checkup/diagnosis.php') ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="save-draft-btn" onclick="saveDraft()">
                            <i class="bx bx-save"></i>
                            Save Draft
                        </button>
                        <button class="complete-checkup-btn pulse-animation shine-effect" onclick="completeCheckup()">
                            <i class="bx bx-check"></i>
                            Complete Checkup
                        </button>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Floating Save Button -->
    <!-- <button class="floating-save-btn glow-effect" onclick="saveDraft()">
        <i class="bx bx-save"></i>
    </button> -->

    <!-- Include all modals -->
    <?php include(VIEW_ROOT . '/pages/doctor/components/common/modals.php') ?>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/js/doctor/checkup.js"></script>
    <script src="/js/doctor/vitals.js"></script>
    <script src="/js/doctor/medications.js"></script>
    <script src="/js/doctor/diagnosis.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to current tab
                    const tabName = this.getAttribute('data-tab');
                    this.classList.add('active');
                    document.getElementById(`${tabName}-tab`).classList.add('active');
                });
            });

            // Add highlight class to important fields (example)
            setTimeout(() => {
                const importantFields = document.querySelectorAll('.vital-temperature, .vital-blood-pressure');
                importantFields.forEach(field => {
                    field.classList.add('highlight-field');
                });

                // Remove highlight after 10 seconds
                setTimeout(() => {
                    importantFields.forEach(field => {
                        field.classList.remove('highlight-field');
                    });
                }, 10000);
            }, 1000);
        });
    </script>

</body>

</html>