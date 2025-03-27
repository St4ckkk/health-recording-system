<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden | Healthcare Portal</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
</head>

<body class="font-body leading-normal bg-gray-50 min-h-screen flex flex-col">
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-4">
                    <i class='bx bx-lock-alt text-red-600 text-6xl'></i>
                </div>
                <h1 class="text-6xl font-bold text-gray-900 mb-2">403</h1>
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Access Forbidden</h2>
                <p class="text-gray-600 mb-8">
                    You don't have permission to access this page. Please contact your administrator if you believe this
                    is an error.
                </p>
            </div>

            <div class="space-y-4">
                <a href="<?= BASE_URL ?>/"
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-full hover:bg-blue-700 transition-colors duration-200">
                    <i class='bx bx-home-alt mr-2'></i>
                    Return to Homepage
                </a>

                <div class="pt-4">
                    <a href="javascript:history.back()"
                        class="text-blue-600 hover:text-blue-800 underline transition-colors duration-200">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Go Back
                    </a>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-200 pt-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md text-left">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class='bx bx-info-circle text-yellow-400 text-xl'></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                If you need access to this resource, please contact your system administrator or the IT
                                department at ext. 1234.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white py-6 border-t border-gray-200">
        <div class="container mx-auto px-6 text-center">
            <div class="w-full mb-4">
                <div
                    class="border-2 inline-block border-gray-800 w-[40px] h-[40px] flex justify-center items-center font-bold mx-auto">
                    LOGO
                </div>
            </div>
            <p class="text-sm text-gray-600">
                &copy; <?= date('Y') ?> Healthcare Portal. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>