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

    <style>
        .bg-pattern {
            background-image: url('<?= BASE_URL ?>/images/healthcare-pattern.svg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .bg-gradient-overlay {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
        }

        .video-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -20;
            overflow: hidden;
        }

        .video-bg {
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(0, 0, 0, 0.6) 100%);
            z-index: -15;
        }

        .content-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -10;
            backdrop-filter: blur(5px);
        }

        .hero-bg {
            background: rgba(0, 57, 99, 0.1);
            backdrop-filter: blur(8px);
        }

        @media (max-width: 768px) {
            .video-bg-container {
                display: none;
            }

            body {
                background: linear-gradient(135deg, rgba(0, 57, 99, 0.1) 0%, rgba(0, 57, 99, 0.05) 100%);
            }
        }
    </style>
</head>

<body class="text-gray-800 font-body leading-normal overflow-x-hidden min-h-screen">
    <!-- Background Video -->
    <div class="video-bg-container">
        <video class="video-bg" autoplay muted loop playsinline>
            <source src="<?= BASE_URL ?>/videos/bg-cover.mp4" type="video/mp4">
            <!-- Fallback for browsers that don't support video -->
            <img src="<?= BASE_URL ?>/images/healthcare-fallback.jpg" alt="Healthcare background">
        </video>
    </div>

    <!-- Video Overlay with brand color -->
    <div class="video-overlay"></div>

    <!-- Content Overlay for readability -->
    <div class="content-overlay"></div>

    <!-- Header with logo -->
    <header class="w-full py-6 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="logo">
                <div class="flex items-center gap-4">
                    <div
                        class="w-[65px] h-[65px] flex justify-center items-center rounded-xl shadow-md hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-500/30">
                        <img src="<?= BASE_URL ?>/images/logo.png" alt="TB Health Recording System"
                            class="w-full h-full object-contain p-2.5">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-emerald-800">Health Recording</span>
                        <span class="text-sm text-emerald-600">System</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 relative z-10">
        <!-- Hero section with glass effect -->
        <div class="rounded-3xl overflow-hidden mb-12 shadow-lg">
            <div class="bg-white/90 p-8 md:p-16 relative">
                <!-- Content -->
                <div class="relative z-10 max-w-3xl mx-auto text-center">
                    <span
                        class="inline-block px-4 py-1 rounded-full bg-primary text-white text-sm font-medium mb-4">Healthcare
                        Staff Portal</span>
                    <h1 class="font-heading text-4xl md:text-5xl font-bold text-primary mb-4">Welcome to Healthcare
                        Portal</h1>
                    <p class="text-lg text-gray-700 max-w-2xl mx-auto">Please select your role to continue with the
                        onboarding process</p>
                </div>
            </div>
        </div>

        <!-- Onboarding progress indicator -->
        <div class="mb-12 max-w-3xl mx-auto rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center">
                        <i class='bx bx-user'></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-primary">Role</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200">
                    <div class="h-full bg-primary w-0"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center">
                        <i class='bx bx-lock-alt'></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-gray-400">Login</span>
                </div>
                <div class="flex-1 h-1 mx-2 bg-gray-200"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center">
                        <i class='bx bx-check'></i>
                    </div>
                    <span class="text-xs mt-2 font-medium text-gray-400">Complete</span>
                </div>
            </div>
        </div>

        <!-- Role selection cards -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Staff Login Option -->
                <div
                    class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition-all duration-normal cursor-pointer group relative overflow-hidden">
                    <!-- Background pattern -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-primary-light opacity-20 rounded-full -mr-16 -mt-16 transition-transform duration-normal group-hover:scale-150">
                    </div>

                    <div class="relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-primary-light flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-normal">
                            <i class='bx bx-user-circle text-3xl text-primary group-hover:text-white'></i>
                        </div>

                        <h3
                            class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-normal">
                            Staff Login</h3>
                        <p class="text-gray-600 mb-8">For receptionists, nurses, and other healthcare staff members.
                            Access patient records and manage appointments.</p>

                        <a href="<?= BASE_URL ?>/staff" class="inline-flex items-center justify-between w-full">
                            <span
                                class="text-primary font-medium group-hover:text-primary-dark transition-colors duration-normal">Login
                                as Staff</span>
                            <span
                                class="w-10 h-10 rounded-full bg-primary-light text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-normal transform group-hover:translate-x-1">
                                <i class='bx bx-right-arrow-alt'></i>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Doctor Login Option -->
                <div
                    class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition-all duration-normal cursor-pointer group relative overflow-hidden">
                    <!-- Background pattern -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-primary-light opacity-20 rounded-full -mr-16 -mt-16 transition-transform duration-normal group-hover:scale-150">
                    </div>

                    <div class="relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-primary-light flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-normal">
                            <i class='bx bx-plus-medical text-3xl text-primary group-hover:text-white'></i>
                        </div>

                        <h3
                            class="text-xl font-semibold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-normal">
                            Doctor Login</h3>
                        <p class="text-gray-600 mb-8">For physicians and medical practitioners. Access patient medical
                            histories and manage treatment plans.</p>

                        <a href="<?= BASE_URL ?>/doctor" class="inline-flex items-center justify-between w-full">
                            <span
                                class="text-primary font-medium group-hover:text-primary-dark transition-colors duration-normal">Login
                                as Doctor</span>
                            <span
                                class="w-10 h-10 rounded-full bg-primary-light text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-normal transform group-hover:translate-x-1">
                                <i class='bx bx-right-arrow-alt'></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional role (optional) -->
            <div class="mt-8 text-center">
                <button
                    class="text-primary hover:text-primary-dark font-medium flex items-center mx-auto bg-white/80 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
                    <i class='bx bx-plus-circle mr-2'></i> Other role options
                </button>
            </div>

            <!-- Help section -->
            <div class="mt-16 text-center">
                <div
                    class="p-6 bg-white/90 backdrop-blur-sm rounded-xl shadow-md max-w-lg mx-auto border border-gray-100">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-info-light flex items-center justify-center text-info">
                            <i class='bx bx-help-circle text-2xl'></i>
                        </div>
                    </div>
                    <h4 class="text-lg font-medium mb-2">Need assistance?</h4>
                    <p class="text-gray-600 mb-4">If you're having trouble accessing the portal, our support team is
                        here to help.</p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="#" class="inline-flex items-center text-info hover:text-info-dark">
                            <i class='bx bx-envelope mr-1'></i> Email Support
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="inline-flex items-center text-info hover:text-info-dark">
                            <i class='bx bx-phone mr-1'></i> Call Helpdesk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer
        class="w-full py-6 px-4 sm:px-6 lg:px-8 bg-white/80 backdrop-blur-sm border-t border-gray-200 relative z-10">
        <div class="max-w-7xl mx-auto text-center text-gray-500 text-sm">
            <p>&copy; <?= date('Y') ?> Healthcare Portal. All rights reserved.</p>
            <div class="mt-2 flex justify-center space-x-4">
                <a href="#" class="hover:text-primary">Privacy Policy</a>
                <a href="#" class="hover:text-primary">Terms of Service</a>
                <a href="#" class="hover:text-primary">Contact</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript to handle video loading and fallback -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.querySelector('.video-bg');

            // Check if the browser supports video
            const isVideoSupported = !!document.createElement('video').canPlayType;

            if (!isVideoSupported) {
                // If video is not supported, add a class to body for fallback styling
                document.body.classList.add('no-video-support');
            }

            // Handle video loading error
            video.addEventListener('error', function () {
                document.body.classList.add('video-error');
            });
        });
    </script>
</body>

</html>