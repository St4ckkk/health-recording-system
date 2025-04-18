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
</head>

<body class="font-body bg-gray-50">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Patient Info Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Admission Records</h1>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Patient:</span>
                                        <span
                                            class="font-semibold"><?= $patient->first_name . ' ' . $patient->last_name ?></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">PAT ID:</span>
                                        <span class="font-semibold"><?= $patient->patient_reference_number ?></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Age:</span>
                                        <span class="font-semibold"><?= $patient->age ?? 'N/A' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="<?= BASE_URL ?>/doctor/patientView?id=<?= $patient->id ?>"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-arrow-back mr-1"></i> Back to Patient
                                </a>
                                <button
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-printer mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Admission Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="bx bx-calendar text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Admissions</p>
                                    <h3 class="text-xl font-bold"><?= $stats['total'] ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="bx bx-plus-medical text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Active Admissions</p>
                                    <h3 class="text-xl font-bold"><?= $stats['active'] ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-gray-100 text-gray-600 mr-4">
                                    <i class="bx bx-check-circle text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Discharged</p>
                                    <h3 class="text-xl font-bold"><?= $stats['discharged'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Admission Details -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Current Admission Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Diagnosis</p>
                                    <p class="font-medium">
                                        <?= htmlspecialchars($currentAdmission->diagnosis_name ?? 'No diagnosis') ?>
                                    </p>
                                    <?php if (!empty($currentAdmission->diagnosis_notes)): ?>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <?= htmlspecialchars($currentAdmission->diagnosis_notes) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Admitted By</p>
                                    <p class="font-medium">Dr.
                                        <?= htmlspecialchars($currentAdmission->doctor_first_name . ' ' . $currentAdmission->doctor_last_name) ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?= htmlspecialchars($currentAdmission->doctor_specialization) ?>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Reason for Admission</p>
                                    <p class="font-medium">
                                        <?= htmlspecialchars($currentAdmission->reason ?? 'Not specified') ?>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Ward / Room</p>
                                    <p class="font-medium"><?= htmlspecialchars($currentAdmission->ward) ?> / Bed
                                        <?= htmlspecialchars($currentAdmission->bed_no) ?>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Admission Date</p>
                                    <p class="font-medium">
                                        <?= date('F j, Y', strtotime($currentAdmission->admission_date)) ?>
                                    </p>
                                </div>

                                <?php if ($currentAdmission->status === 'discharged'): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Discharge Date</p>
                                        <p class="font-medium">
                                            <?= date('F j, Y', strtotime($currentAdmission->discharge_date)) ?>
                                        </p>
                                    </div>
                                <?php elseif ($currentAdmission->status === 'referred'): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Referral Date</p>
                                        <p class="font-medium">
                                            <?= date('F j, Y', strtotime($currentAdmission->referral_date)) ?>
                                        </p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Referred To</p>
                                        <p class="font-medium">
                                            <?= htmlspecialchars($currentAdmission->referred_to) ?>
                                        </p>
                                    </div>
                                <?php elseif ($currentAdmission->status === 'transferred'): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Transfer Date</p>
                                        <p class="font-medium">
                                            <?= date('F j, Y', strtotime($currentAdmission->transferred_date)) ?>
                                        </p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Transferred To</p>
                                        <p class="font-medium">
                                            <?= htmlspecialchars($currentAdmission->transferred_to) ?>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Discharge Date</p>
                                        <p class="font-medium">Not discharged yet</p>
                                    </div>
                                <?php endif; ?>

                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-1">Status</p>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                            <?php
                                            switch ($currentAdmission->status) {
                                                case 'admitted':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'discharged':
                                                    echo 'bg-gray-100 text-gray-800';
                                                    break;
                                                case 'referred':
                                                    echo 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 'transferred':
                                                    echo 'bg-purple-100 text-purple-800';
                                                    break;
                                                default:
                                                    echo 'bg-yellow-100 text-yellow-800';
                                            }
                                            ?>">
                                            <?= htmlspecialchars($currentAdmission->status) ?>
                                        </span>
                                        <button id="updateStatusBtn" class="text-sm text-blue-600 hover:text-blue-800">
                                            <i class="bx bx-edit"></i> Update Status
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admission History -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Admission History</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Diagnosis</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ward</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Admission Date</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Discharge Date</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (!empty($admissionHistory)): ?>
                                        <?php foreach ($admissionHistory as $admission): ?>
                                            <tr class="<?= $admission->id == $currentAdmission->id ? 'bg-blue-50' : '' ?>">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($admission->diagnosis_name ?? 'No diagnosis') ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <?= htmlspecialchars($admission->ward) ?> / Bed
                                                    <?= htmlspecialchars($admission->bed_no) ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <?= date('Y-m-d', strtotime($admission->admission_date)) ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    <?= $admission->discharge_date ? date('Y-m-d', strtotime($admission->discharge_date)) : 'Not discharged' ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                                        <?php
                                                        switch ($admission->status) {
                                                            case 'admitted':
                                                                echo 'bg-green-100 text-green-800';
                                                                break;
                                                            case 'discharged':
                                                                echo 'bg-gray-100 text-gray-800';
                                                                break;
                                                            case 'referred':
                                                                echo 'bg-blue-100 text-blue-800';
                                                                break;
                                                            case 'transferred':
                                                                echo 'bg-purple-100 text-purple-800';
                                                                break;
                                                            default:
                                                                echo 'bg-yellow-100 text-yellow-800';
                                                        }
                                                        ?>">
                                                        <?= htmlspecialchars($admission->status) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                                                No admission records found
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    </section>
    </div>
    </main>
    </div>

    <!-- Status Update Modal -->
    <?php include(VIEW_ROOT . '/pages/doctor/components/modals/update-admission.php') ?>

    <!-- Toast Container -->
    <script src="<?= BASE_URL ?>/js/doctor/update-admission.js"></script>
</body>

</html>