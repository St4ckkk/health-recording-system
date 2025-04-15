<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/pharmacist/patientview.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/jsbarcode/dist/JsBarcode.all.min.js"></script>
    <!-- Add this before your scripts -->
    <input type="hidden" id="prescription-data" value='<?= json_encode([
        "patientId" => $patient->id,
        "medications" => $medications,
        "advice" => $advice,
        "followUpDate" => $followup_date,
        "vitalsId" => $vitals->id ?? null,
        "signature" => $_POST['signature'] ?? ''
    ]) ?>'>
    
    <script src="<?= BASE_URL ?>/node_modules/html2canvas/dist/html2canvas.min.js"></script>
    <script>
        const BASE_URL = document.querySelector('meta[name="base-url"]').content;
    </script>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-container, .print-container * {
                visibility: visible;
            }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            .no-print { 
                display: none !important; 
            }
            /* Ensure charts fit in print */
            .w-1/2 {
                width: 45% !important;
            }
            .h-48 {
                height: 200px !important;
            }
            /* Hide URL and preview elements */
            @page {
                margin: 0.5cm;
                size: A4;
            }
            a[href]:after {
                content: none !important;
            }
            .w-1/2 {
                width: 100% !important;
            }
            .h-48 {
                height: 150px !important;
            }
            canvas {
                max-width: 100% !important;
                max-height: 100% !important;
            }
        }
        .dosage-cell { 
            background-color: rgba(209, 250, 229, 0.4); 
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Back button -->
                    <div class="mb-4 no-print">
                        <a href="<?= BASE_URL ?>/doctor/patients"
                            class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark">
                            <button class="back-button">
                                <i class="bx bx-arrow-back mr-2"></i> Back
                            </button>
                        </a>
                    </div>

                    <!-- Prescription Preview -->
                    <div class="rounded-lg overflow-hidden print-container">
                        <!-- Clinic Header -->
                        <div class="p-6 border-b flex justify-between items-center">
                            <!-- Doctor Info -->
                            <div class="text-teal-600">
                                <h2 class="text-xl font-semibold">Dr. <?= htmlspecialchars($_SESSION['doctor']['first_name'] . ' ' . $_SESSION['doctor']['last_name']) ?></h2>
                                <p class="text-gray-600 uppercase"><?= htmlspecialchars($_SESSION['doctor']['specialization'] ?? 'M.B.B.S.') ?> | Reg. No: <?= htmlspecialchars($_SESSION['doctor']['license_number']) ?></p>
                                <p class="text-gray-600">Mob. No: <?= htmlspecialchars($_SESSION['doctor']['contact_number'] ?? 'N/A') ?></p>
                            </div>

                            <!-- Logo -->
                            <div class="flex justify-center items-center">
                                <img src="<?= BASE_URL ?>/assets/images/logo.png" alt="Care Clinic" class="h-16">
                            </div>

                            <div class="text-right text-teal-600">
                                <h3 class="text-lg font-semibold">Health Care Center</h3>
                                <p class="text-gray-600">123 Medical Plaza, Downtown Area</p>
                                <p class="text-gray-600">Ph: (555) 123-4567, Hours: 9:00 AM - 5:00 PM</p>
                                <p class="text-gray-600">Weekends: By Appointment Only</p>
                            </div>
                        </div>

                        <hr class="border-t border-gray-800">

                        <!-- Barcode -->
                        <div class="px-6 pt-4">
                            <svg id="barcode"></svg>
                        </div>

                        <!-- Patient Details -->
                        <div class="p-6 flex justify-between">
                            <div>
                                <p class="font-bold">ID: <?= $patient->patient_reference_number ?> - <?= strtoupper($patient->first_name . ' ' . $patient->last_name) ?> (<?= substr($patient->gender, 0, 1) ?>)</p>
                                <p>Address: <?= strtoupper($patient->address) ?></p>
                                <p>Temp (deg): <?= $vitals->temperature ?? 'N/A' ?>, BP: <?= $vitals->blood_pressure ?? 'N/A' ?> mmHg</p>
                            </div>
                            <div class="text-right">
                                <p>Date: <?= date('d-M-Y, h:i A') ?></p>
                            </div>
                        </div>

                        <hr class="border-t border-gray-800 mx-6">

                        <!-- Medications -->
                        <div class="px-6 py-4">
                            <h4 class="font-semibold mb-2">R</h4>
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-t border-b border-gray-800">
                                        <th class="text-left py-2 w-1/4">Medicine Name</th>
                                        <th class="text-left py-2 w-2/5">Dosage</th>
                                        <th class="text-left py-2 w-1/4">Duration</th>
                                        <th class="text-left py-2 w-1/4">Special Instructions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; foreach ($medications as $med): ?>
                                    <tr class="border-b border-gray-300">
                                        <td class="py-2"><?= $count ?>) <?= htmlspecialchars($med['name']) ?></td>
                                        <td class="py-2 dosage-cell"><?= htmlspecialchars($med['dosage']) ?></td>
                                        <td class="py-2"><?= htmlspecialchars($med['duration']) ?></td>
                                        <td class="py-2 instructions-cell"><?= htmlspecialchars($med['instructions'] ?? '') ?></td>
                                    </tr>
                                    <?php $count++; endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Advice -->
                        <div class="px-6 py-2">
                            <p class="font-bold">Advice Given:</p>
                            <p class="mt-1">* <?= htmlspecialchars($advice) ?></p>
                        </div>

                        <!-- Follow Up -->
                        <div class="px-6 py-2">
                            <p class="font-bold">Follow Up: <?= $followup_date ?></p>
                        </div>

                        <!-- Charts -->
                        <div class="p-6">
                            <p class="font-bold mb-2">Charts</p>
                            <div class="flex justify-between space-x-4">
                                <div class="w-1/2 h-48">
                                    <!-- Temperature Chart -->
                                    <canvas id="tempChart"></canvas>
                                </div>
                                <div class="w-1/2 h-48">
                                    <!-- BP Chart -->
                                    <canvas id="bpChart"></canvas>
                                </div>
                            </div>
                        </div>
                                        
                        <!-- Signature -->
                        <div class="p-6">
                            <div class="flex flex-col items-end">
                                <div class="text-right" style="min-height: 100px;">
                                    <?php if (isset($_POST['signature']) && !empty($_POST['signature'])): ?>
                                        <img src="<?= $_POST['signature'] ?>" 
                                             alt="Doctor's Signature" 
                                             style="height: 80px; display: inline-block; margin-bottom: -20px;">
                                    <?php endif; ?>
                                    
                                    <div class="text-right mt-6">
                                        <p class="font-medium text-gray-800">Dr. <?= htmlspecialchars($_SESSION['doctor']['first_name'] . ' ' . $_SESSION['doctor']['last_name']) ?></p>
                                        <p class="text-sm text-blue-600 uppercase"><?= htmlspecialchars($_SESSION['doctor']['specialization'] ?? 'M.B.B.S.') ?></p>
                                    </div>
                                </div>
                              
                            </div>
                        </div>

                       
                                    <div class="p-6 bg-gray-50 no-print flex gap-4 justify-end">
                                        <button onclick="savePrescription()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            <i class="bx bx-save mr-2"></i>Save Prescription
                                        </button>
                                        <button onclick="downloadPrescription()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <i class="bx bx-download mr-2"></i>Download
                                        </button>
                                        <button onclick="emailPrescription()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="bx bx-envelope mr-2"></i>Email to Patient
                                        </button>
                                        <button onclick="window.print()" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            <i class="bx bx-printer mr-2"></i>Print
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                
                <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
                <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>

                <script src="<?= BASE_URL ?>/js/doctor/preview-prescription.js"></script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            // Generate barcode using JsBarcode
            JsBarcode("#barcode", "<?= $patient->patient_reference_number ?>", {
                format: "CODE128",
                width: 2,
                height: 50,
                displayValue: false
            });

            // Temperature Chart
            const tempCtx = document.getElementById('tempChart').getContext('2d');
            const tempChart = new Chart(tempCtx, {
                type: 'line',
                data: {
                    labels: ['20.03', '22.03', '24.03', '26.03', '28.03', '30.03'],
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: [37, 36.5, 36, 35.5, 36, 36.5],
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 20,
                            max: 40,
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });

            // Blood Pressure Chart
            const bpCtx = document.getElementById('bpChart').getContext('2d');
            const bpChart = new Chart(bpCtx, {
                type: 'line',
                data: {
                    labels: ['20.03', '22.03', '24.03', '26.03', '28.03', '30.03'],
                    datasets: [{
                        label: 'Blood Pressure (mmHg)',
                        data: [120, 110, 100, 90, 95, 90],
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 0,
                            max: 140,
                            title: {
                                display: true,
                                text: 'Blood Pressure (mmHg)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        });
    </script>




<div id="savePrescriptionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0" id="savePrescriptionModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Save Prescription</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeSavePrescriptionModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                <div class="flex items-start">
                    <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                    <p class="text-sm text-blue-700">
                        Please confirm that you want to save this prescription. This action cannot be undone.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-file text-primary mr-2"></i>
                        <span class="text-sm font-medium">Prescription Details</span>
                    </div>
                    <p class="text-sm text-gray-500">All medication details and instructions will be saved to the patient's record.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelSavePrescriptionBtn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmSavePrescriptionBtn" class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Save Prescription
            </button>
        </div>
    </div>
</div>

<!-- Email Prescription Modal -->
<div id="emailPrescriptionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0" id="emailPrescriptionModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Email Prescription</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeEmailPrescriptionModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                <div class="flex items-start">
                    <i class="bx bx-envelope text-blue-500 text-lg mr-2"></i>
                    <p class="text-sm text-blue-700">
                        The prescription will be sent to the patient's registered email address.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="include_instructions" name="include_instructions" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Include Instructions</span>
                            <span class="text-xs text-gray-500">Attach detailed medication instructions</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="email_message" class="block text-sm font-medium text-gray-700 mb-1">Additional Message:</label>
                    <textarea id="email_message" name="email_message" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Add any additional message..."></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelEmailPrescriptionBtn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmEmailPrescriptionBtn" class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Send Email
            </button>
        </div>
    </div>
</div>
</body>
</html>