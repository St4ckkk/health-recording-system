<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-gray-900 font-heading">Notifications</h2>
                        <p class="text-sm text-gray-500">Updates about patient appointments</p>
                    </div>
                    <div class="p-4 card bg-white shadow-sm rounded-lg w-full fade-in">
                    <div class="space-y-4">
                        <div class="bg-[#f8faff] rounded-lg p-4 border border-primary-lighter">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="mt-1">
                                        <i class='bx bx-calendar-alt text-primary text-lg'></i>
                                    </div>
                                    <div>
                                        <h3 class="text-primary font-semibold mb-1">Appointment Reminder</h3>
                                        <p class="text-primary text-sm">Patient John Smith has an appointment with Dr. Sarah Johnson tomorrow at 10:00 AM.</p>
                                        <button class="mt-4 px-3 py-1.5 bg-white border border-primary-lighter text-primary rounded-md hover:bg-primary-light transition-colors duration-fast">
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs text-gray-500 mr-2">May 14, 2023</span>
                                    <div class="w-2 h-2 rounded-full bg-gray-900"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL ?>/js/reception.js"></script>
</body>

</html>