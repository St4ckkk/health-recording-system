<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist</title>
    <link rel="stylesheet" href="../../node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="../../globals.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../output.css">
    <link rel="stylesheet" href="../assets/css/reception.css">
    <link rel="stylesheet" href="../../node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="../../node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="../../node_modules/flatpickr/dist/l10n/fr.js"></script>

</head>

<body class="font-body">
    <div class="flex">
        <?php include('components/sidebar.php') ?>
        <div class="flex-1 main-content">
            <?php include('components/header.php') ?>
            <div class="content-wrapper">

                <section class="p-6">
                    <?php include('components/patient_app.php') ?>
                </section>
            </div>
        </div>
    </div>
</body>

</html>