<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Verify Your Access
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Please enter the verification code sent to <?= htmlspecialchars($patient_email) ?>
                </p>
            </div>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?= $_SESSION['flash_message'] ?>
                    <?php unset($_SESSION['flash_message']); ?>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" action="<?= BASE_URL ?>/patient/verify/<?= $token ?>" method="POST">
                <div>
                    <label for="verification_code" class="sr-only">Verification Code</label>
                    <input id="verification_code" name="verification_code" type="text" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Enter 6-digit code">
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Verify Access
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>