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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- E-Prescription Form -->
                    <div class="">
                        <form action="<?= BASE_URL ?>/doctor/preview-prescription" method="POST">
                            <input type="hidden" name="patient_id" value="<?= $patient->id ?>">
                            <!-- Doctor Information -->
                            <div class="border rounded-md mb-6 overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b">
                                    <h2 class="text-lg font-medium text-gray-800">Doctor Information</h2>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Doctor Name</label>
                                            <input type="text" value="Dr. <?= htmlspecialchars($_SESSION['doctor']['first_name'] . ' ' . $_SESSION['doctor']['last_name']) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">License Number</label>
                                            <input type="text" value="<?= htmlspecialchars($_SESSION['doctor']['license_number'] ?? '') ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Patient Information -->
                            <div class="border rounded-md mb-6 overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b">
                                    <h2 class="text-lg font-medium text-gray-800">Patient Information</h2>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Patient Name</label>
                                            <input type="text" value="<?= htmlspecialchars($patient->first_name . ' ' . $patient->last_name) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                            <div class="relative">
                                                <input type="text" value="<?= date('d-M-Y', strtotime($patient->date_of_birth)) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="bx bx-calendar text-gray-400 text-xl"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Patient ID</label>
                                            <input type="text" value="<?= htmlspecialchars($patient->patient_reference_number) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                            <input type="text" value="<?= htmlspecialchars($patient->contact_number) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                        
                                        <!-- Updated Vitals Section -->
                                        <div class="md:col-span-2">
                                            <div class="border rounded-lg p-4 bg-gray-50">
                                                <h3 class="text-sm font-medium text-gray-700 mb-3">Latest Vitals</h3>
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Temperature</label>
                                                        <div class="bg-white px-3 py-2 rounded-md border">
                                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vitals->temperature ?? 'N/A') ?></span>
                                                            <span class="text-xs text-gray-500 ml-1">°C</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Blood Pressure</label>
                                                        <div class="bg-white px-3 py-2 rounded-md border">
                                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vitals->blood_pressure ?? 'N/A') ?></span>
                                                            <span class="text-xs text-gray-500 ml-1">mmHg</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Heart Rate</label>
                                                        <div class="bg-white px-3 py-2 rounded-md border">
                                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vitals->heart_rate ?? 'N/A') ?></span>
                                                            <span class="text-xs text-gray-500 ml-1">bpm</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Respiratory Rate</label>
                                                        <div class="bg-white px-3 py-2 rounded-md border">
                                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($vitals->respiratory_rate ?? 'N/A') ?></span>
                                                            <span class="text-xs text-gray-500 ml-1">bpm</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                            <input type="text" value="<?= htmlspecialchars($patient->address) ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medications -->
                            <div class="border rounded-md mb-6 overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                    <h2 class="text-lg font-medium text-gray-800">Medications</h2>
                                    <button type="button" id="addMedication" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="bx bx-plus text-xl mr-1"></i>
                                        Add Medication
                                    </button>
                                </div>
                                <div class="p-4">
                                    <!-- Change the grid layout here -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="medicationsContainer">
                                        <!-- Medication cards will be added here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="border rounded-md mb-2 overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b">
                                    <h2 class="text-lg font-medium text-gray-800">Additional Information</h2>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Advice Given</label>
                                            <textarea name="advice" placeholder="AVOID OILY AND SPICY FOOD" rows="2" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Follow Up Date</label>
                                            <div class="relative">
                                                <input type="text" name="followup_date" placeholder="Pick a date" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <i class="bx bx-calendar text-gray-400 text-xl"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Prescription Date</label>
                                            <div class="relative">
                                                <input type="text" name="prescription_date" value="<?= date('d-M-Y') ?>" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                    <i class="bx bx-calendar text-gray-400 text-xl"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                               
                                <div class="p-4">
                                    <div class="flex justify-end items-center gap-4">
                                        <div class="flex flex-col items-end">
                                            <label for="signature" class="text-sm font-medium text-gray-700 mb-2">Signature</label>
                                            <div class="w-[200px]">
                                                <div class="border rounded-md bg-white">
                                                    <canvas id="signaturePad" class="border-gray-200" style="touch-action: none;" width="200" height="80"></canvas>
                                                </div>
                                                <div class="mt-2 flex justify-end gap-2">
                                                    <input type="file" id="signatureImage" accept="image/*" class="hidden">
                                                    <button type="button" id="uploadSignature" class="inline-flex items-center px-3 py-1 text-sm text-green-700 border border-green-300 rounded-md hover:bg-green-50">
                                                        <i class='bx bx-upload mr-1'></i>
                                                        Upload
                                                    </button>
                                                    <button type="button" id="clearSignature" class="inline-flex items-center px-3 py-1 text-sm text-red-700 border border-red-300 rounded-md hover:bg-red-50">
                                                        <i class='bx bx-x mr-1'></i>
                                                        Clear
                                                    </button>
                                                </div>
                                                <input type="hidden" name="signature" id="signatureData">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Preview Prescription
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
           
        </main>
    </div>

    <div id="toast-container" class="fixed top-4 right-4 z-50"></div>

    <script src="<?= BASE_URL ?>/js/doctor/checkup.js"></script>
    <script src="<?= BASE_URL ?>/js/doctor/prescription.js"></script>
    <!-- <script>
        // Initialize flatpickr for date inputs
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("input[placeholder='Pick a date']", {
                dateFormat: "d-M-Y",
            });
            
            flatpickr("input[value='27-Apr-2023']", {
                dateFormat: "d-M-Y",
                defaultDate: "27-Apr-2023"
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize signature pad
            const canvas = document.getElementById('signaturePad');
            
            // Set canvas width
            canvas.width = canvas.offsetWidth;
            
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 2.5
            });

            // Handle window resize
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.height * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            window.onresize = resizeCanvas;
            resizeCanvas();

            // Clear signature
            document.getElementById('clearSignature').addEventListener('click', () => {
                signaturePad.clear();
            });

            // Handle signature image upload
                        const uploadBtn = document.getElementById('uploadSignature');
                        const fileInput = document.getElementById('signatureImage');
                        
                        uploadBtn.addEventListener('click', () => {
                            fileInput.click();
                        });

                        fileInput.addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    const img = new Image();
                                    img.onload = function() {
                                        const canvas = document.getElementById('signaturePad');
                                        const ctx = canvas.getContext('2d');
                                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                                        
                                        // Calculate aspect ratio to fit image within canvas
                                        const scale = Math.min(
                                            canvas.width / img.width,
                                            canvas.height / img.height
                                        );
                                        const x = (canvas.width - img.width * scale) / 2;
                                        const y = (canvas.height - img.height * scale) / 2;
                                        
                                        ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
                                        document.getElementById('signatureData').value = canvas.toDataURL();
                                    };
                                    img.src = event.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                const signatureData = document.getElementById('signatureData').value;
                if (signaturePad.isEmpty() && !signatureData) {
                    e.preventDefault();
                    showToast('error', 'Signature Required', 'Please provide a signature before submitting the prescription.');
                    return;
                }
                
                // If signature pad is empty but we have uploaded image data, use that
                if (signaturePad.isEmpty() && signatureData) {
                    document.getElementById('signatureData').value = signatureData;
                } else {
                    document.getElementById('signatureData').value = signaturePad.toDataURL();
                }
            });
        });
    </script> -->
</body>

</html>
