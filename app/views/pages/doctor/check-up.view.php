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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>

</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">


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
                </section>
            </div>
        </main>
    </div>

    <!-- Include all modals -->
    <?php include(VIEW_ROOT . '/pages/doctor/components/common/modals.php') ?>

    <script src="<?= BASE_URL ?>/js/doctor/checkup.js"></script>
</body>

</html>