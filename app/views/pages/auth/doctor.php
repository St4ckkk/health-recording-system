<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Doctor Portal - Healthcare System' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
</head>

<body class="font-body leading-normal bg-white min-h-screen flex">
    <div class="flex w-full min-h-screen">
        <div class="p-4 mx-auto flex flex-col justify-center">
            <div class="w-20 mb-12">
                <div class="border-2 border-gray-800 w-[50px] h-[50px] flex justify-center items-center font-bold">LOGO
                </div>
            </div>

            <div class="text-center">
                <h1 class="text-3xl font-semibold font-heading mb-2">Doctor Portal</h1>
                <p class="text-md mb-4 text-gray-600">Log in to access your dashboard</p>
            </div>

            <?php if (isset($errors['login'])): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-center">
                    <?= $errors['login'] ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/doctor"
                class="max-w-[500px] w-[800px] p-[2.9rem] border border-gray-300 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 bg-white">

                <div class="mb-6">
                    <label for="email" class="block text-lg font-medium">Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="<?= $email ?? '' ?>" required
                            class="w-full py-3 px-3 border border-black rounded-md text-base focus:outline-none focus:border-green-600 focus:border-2">
                    </div>
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-lg font-medium">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full py-3 px-3 border border-black rounded-md text-base focus:outline-none focus:border-green-600 focus:border-2">
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-green-600 bg-transparent border-none cursor-pointer text-sm font-medium">SHOW</button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-green-600 text-white border-none rounded-full text-base font-medium cursor-pointer hover:bg-green-700 transform hover:-translate-y-0.5 transition-all duration-200 hover:shadow-md">Login</button>

                <div class="text-center my-4 text-sm">
                    <a href="#"
                        class="text-green-600 underline hover:text-green-800 transition-colors duration-200">Reset Password</a>
                </div>

                <div class="text-center mb-4 text-sm">
                    New doctor? <a href="#"
                        class="text-green-600 underline hover:text-green-800 transition-colors duration-200">Register here</a>
                </div>
            </form>
        </div>

        <div class="w-[500px] relative bg-cover bg-center"
            style="background-image: url('<?= BASE_URL ?>/images/doctor-bg.png')">
            <div class="absolute inset-0 bg-gradient-to-br from-green-600/90 to-green-700/75"></div>
            <div class="relative h-full flex flex-col justify-end z-10">
                <div class="p-12">
                    <h2 class="text-xl font-heading mb-6 text-white">Doctor Resources</h2>
                    <div class="space-y-2">
                        <a href="#"
                            class="flex items-center text-white no-underline mb-4 font-medium p-2.5 rounded-lg hover:bg-white/10 transform hover:translate-x-1 transition-all duration-200">
                            <i class='bx bx-calendar mr-2.5 text-2xl font-light'></i>
                            <span class="text-base relative underline font-medium">Patient Appointments</span>
                        </a>
                        <a href="#"
                            class="flex items-center text-white no-underline mb-4 font-medium p-2.5 rounded-lg hover:bg-white/10 transform hover:translate-x-1 transition-all duration-200">
                            <i class='bx bx-notepad mr-2.5 text-2xl font-light'></i>
                            <span class="text-base relative underline font-medium">Medical Records</span>
                        </a>
                        <a href="#"
                            class="flex items-center text-white no-underline mb-4 font-medium p-2.5 rounded-lg hover:bg-white/10 transform hover:translate-x-1 transition-all duration-200">
                            <i class='bx bx-capsule mr-2.5 text-2xl font-light'></i>
                            <span class="text-base relative underline font-medium">Prescriptions</span>
                        </a>
                        <a href="#"
                            class="flex items-center text-white no-underline mb-4 font-medium p-2.5 rounded-lg hover:bg-white/10 transform hover:translate-x-1 transition-all duration-200">
                            <i class='bx bx-book-medical mr-2.5 text-2xl font-light'></i>
                            <span class="text-base relative underline font-medium">Medical Guidelines</span>
                        </a>
                    </div>
                    <div class="mt-12 text-white/80 text-sm">
                        <p>For medical support, contact Medical Affairs</p>
                        <p class="mt-2">Doctor Portal v1.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePasswordButton.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.textContent = type === 'password' ? 'SHOW' : 'HIDE';
            });
        });
    </script>
</body>

</html>