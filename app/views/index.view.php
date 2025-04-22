<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Health Recording System' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
</head>
<style>
    .bot-icon {
        animation: bounce 2s infinite;
    }

    .group:hover .bot-icon {
        animation: none;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .typing-animation {
        display: inline-block;
    }

    .typing-text {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        border-right: 2px solid #333;
        width: 0;
        animation: typing 3.5s steps(40, end) forwards,
            blink-caret 0.75s step-end infinite;
    }

    @keyframes typing {
        from {
            width: 0
        }

        to {
            width: 100%
        }
    }

    @keyframes blink-caret {

        from,
        to {
            border-color: transparent
        }

        50% {
            border-color: #333
        }
    }

    .group:hover .typing-text {
        animation: typing 3.5s steps(40, end) forwards,
            blink-caret 0.75s step-end infinite;
    }
</style>

<body>
    <header>
        <div class="logo">
            <div
                style="border: 2px solid #333; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; font-weight: bold;">
                LOGO</div>
        </div>
        <div class="header-right">
            <a href="<?= BASE_URL ?>/onBoarding" class="login-link"><i class='bx bx-user'></i>Log in</a>
        </div>
    </header>

    <section class="hero">
        <video class="hero-video" autoplay loop muted>
            <source src="<?= BASE_URL ?>/videos/bg-cover.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Transforming your care</h1>
            <div class="hero-actions">
                <a href="#" class="learn-more">Learn how we drive innovation <i class='bx bx-right-arrow-alt'></i></a>
                <div class="appointment-buttons">
                    <a href="<?= BASE_URL ?>/appointment/doctor-availability" class="hero-request-btn">Request
                        appointment</a>
                    <a href="<?= BASE_URL ?>/appointment/appointment-tracking" class="hero-track-btn"><i
                            class='bx bx-calendar-check'></i>Track appointment</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating AI Symptom Checker -->
    <div class="fixed bottom-6 right-6 z-50 group">
        <div class="absolute bottom-16 right-0 mb-2 hidden transform group-hover:block">
            <div class="bg-white rounded-lg shadow-lg p-4 text-sm text-gray-700 whitespace-nowrap relative">
                <div class="typing-animation">
                    <span class="typing-text">Hello! Would you like to check your symptoms?</span>
                </div>
                <div class="absolute -bottom-2 right-5 w-4 h-4 bg-white transform rotate-45"></div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>/symptoms-checker" 
            class="bot-icon flex items-center justify-center w-14 h-14 bg-primary rounded-full shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-300">
            <img src="<?= BASE_URL ?>/images/icons/bot.png" alt="AI Bot" class="w-8 h-8">
        </a>
    </div>



</body>

</html>