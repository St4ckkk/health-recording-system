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

<body>
    <header>
        <div class="logo">
            <div
                style="border: 2px solid #333; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; font-weight: bold;">
                LOGO</div>
        </div>
        <nav>
            <ul>
                <li><a href="#">Care at Test Clinic <i class='bx bx-chevron-down'></i></a></li>
                <li><a href="#">Health Library<i class='bx bx-chevron-down'></i></a></li>
                <li><a href="#">For Medical Professionals <i class='bx bx-chevron-down'></i></a></li>
                <li><a href="#">Research & Education at Test Clinic <i class='bx bx-chevron-down'></i></a></li>
                <li><a href="#">Giving to Test Clinic <i class='bx bx-chevron-down'></i></a></li>
            </ul>
        </nav>
        <div class="header-right">
            <a href="<?= BASE_URL ?>/appointment/doctor-availability" class="request-link">Request appointment</a>
            <a href="#" class="login-link"><i class='bx bx-user'></i>Log in</a>
            <a href="#" class="search-link"><i class='bx bx-search'></i></a>
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
                <a href="<?= BASE_URL ?>/views/appointment/doctor-availability.html" class="hero-request-btn">Request
                    appointment</a>
            </div>
        </div>
    </section>

</body>

</html>