<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .tracking-number {
            background-color: #f3f4f6;
            border: 1px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            font-family: monospace;
            font-size: 1.25rem;
            text-align: center;
            letter-spacing: 1px;
        }

        .info-row {
            display: flex;
            border-bottom: 1px solid #f3f4f6;
            padding: 0.75rem 0;
        }

        .info-label {
            width: 40%;
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            width: 60%;
            color: #1f2937;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gray-50">
    <div class="w-full max-w-2xl">
        <div class="w-full flex justify-center mb-12">
            <div class="inline-flex items-center">
                <div class="mr-3">
                    <div class="w-24 h-24">
                        <img src="<?= BASE_URL ?>/images/logo.png" alt="Test Clinic Logo"
                            class="w-full h-full object-contain">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-8 text-center">

            <div class="p-8 text-center">
                <div
                    class="w-20 h-20 mx-auto mb-6 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                    <i class="bx bx-time-five text-4xl"></i>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-2">Appointment Booked!</h1>
                <p class="text-gray-600 mb-6">Your appointment has been successfully booked and is waiting for
                    confirmation.
                </p>

                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Your Tracking Number</p>
                    <div class="tracking-number"><?= $tracking_number ?></div>
                    <p class="text-sm text-gray-500 mt-2">Please save this number to track your appointment</p>
                    <p class="text-sm text-blue-600 mt-2">
                        <i class="bx bx-envelope align-middle"></i>
                        A copy of your tracking number has been sent to your registered email
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 text-left mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Appointment Details</h2>

                    <div class="info-row">
                        <div class="info-label">Doctor</div>
                        <div class="info-value">Dr. <?= isset($doctor->full_name) ? $doctor->full_name : 'Unknown' ?>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Specialty</div>
                        <div class="info-value capitalize">
                            <?= isset($doctor->specialization) ? $doctor->specialization : 'Not specified' ?>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Date</div>
                        <div class="info-value"><?= date('l, F j, Y', strtotime($appointment->appointment_date)) ?>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Time</div>
                        <div class="info-value"><?= date('g:i A', strtotime($appointment->appointment_time)) ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Location</div>
                        <div class="info-value"><?= $appointment->location ?? 'Main Clinic' ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Patient</div>
                        <div class="info-value">
                            <?= isset($patient) ? $patient->first_name . ' ' . $patient->last_name : 'Unknown Patient' ?>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Appointment Type</div>
                        <div class="info-value capitalize"><?= $appointment->appointment_type ?></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                                <?= ucfirst($appointment->status) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= BASE_URL ?>/appointment/doctor-availability" class="btn-outline py-2 px-6 rounded-lg">
                        Back to Doctors
                    </a>
                    <a href="<?= BASE_URL ?>/appointment/appointment-tracking" class="btn-primary py-2 px-6 rounded-lg">
                        Track Appointment
                    </a>
                </div>
            </div>

            <div class="mt-6 text-center space-y-2">
                <div class="bg-blue-50 text-blue-700 p-4 rounded-lg text-sm">
                    <p class="font-medium">What happens next?</p>
                    <p class="mt-1">Our staff will review your appointment request and confirm it shortly. You'll
                        receive a
                        confirmation email once approved.</p>
                </div>
                <p class="text-sm text-gray-500">If you have any questions, please contact us at support@testclinic.com
                </p>
            </div>
        </div>
</body>

</html>