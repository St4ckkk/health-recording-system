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
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .search-container {
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .search-input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .select-input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }

        .select-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .view-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .view-btn.active {
            background-color: var(--primary);
            color: white;
        }

        .view-btn:not(.active) {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .view-btn:not(.active):hover {
            background-color: var(--gray-300);
        }

        .avatar {
            background: var(--primary);
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            border: 3px solid white;
        }



        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .doctor-card-header {
            height: 100px;
            position: relative;
            overflow: hidden;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .doctor-card-header-icon {
            color: white;
            font-size: 24px;
            opacity: 0.8;
        }

        .doctor-card-header-specialty {
            position: absolute;
            bottom: 8px;
            right: 12px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            z-index: 3;
        }

        .schedule-btn {
            background-color: var(--primary);
            color: white;
            border-radius: 9999px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .schedule-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .list-item {
            transition: all 0.2s ease;
        }

        .list-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Avatar positioning for overlap with header */
        .avatar-wrapper {
            margin-top: -60px;
            margin-bottom: 16px;
            display: flex;
            justify-content: center;
            position: relative;
        }

        /* Image header styling */
        .image-header {
            position: relative;
            height: 300px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            background-color: rg;
        }

        .image-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
        }

        .image-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-header-content {
            position: relative;
            z-index: 3;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 3rem;
            color: white;
        }

        .image-header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
            max-width: 600px;
        }

        .image-header-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            max-width: 500px;
            opacity: 0.9;
        }

        .image-header-stats {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            padding: 1rem;
            border-radius: 0.5rem;
            min-width: 120px;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .image-header {
                height: 400px;
            }

            .image-header-content {
                padding: 1.5rem;
            }

            .image-header-title {
                font-size: 2rem;
            }

            .image-header-subtitle {
                font-size: 1rem;
            }

            .image-header-stats {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .stat-item {
                min-width: 100px;
            }
        }

        @media (max-width: 640px) {
            .image-header {
                height: 450px;
            }

            .image-header-title {
                font-size: 1.75rem;
            }

            .stat-item {
                min-width: 90px;
                padding: 0.75rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body class="p-5">
    <div class="inline-flex items-center mb-6">
        <div class="mr-2">
            <div class="w-20 h-20">
                <div class="flex justify-center items-center">
                    <img src="<?= BASE_URL ?>/images/logo.png" alt="Health Recording System Logo"
                        class="w-full h-full object-contain">
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="image-header">
            <img src="<?= BASE_URL ?>/images/image-header.jpg" class="image-header-bg" alt="Doctors Team">
            <div class="image-header-overlay"></div>
            <div class="image-header-pattern"></div>
            <div class="image-header-content mt-2">
                <h1 class="image-header-title">Expert Medical Care From Our Professional Doctors</h1>
                <p class="image-header-subtitle">Schedule appointments with top specialists in various medical
                    fields
                </p>

                <div class="flex gap-8 mt-4">
                    <div
                        class="flex flex-col items-center bg-white bg-opacity-15 backdrop-blur-sm p-4 rounded-lg min-w-[120px]">
                        <div class="text-3xl font-bold mb-1"><?= count($data['doctors']) ?>+</div>
                        <div class="text-sm opacity-90">Doctors</div>
                    </div>
                    <div
                        class="flex flex-col items-center bg-white bg-opacity-15 backdrop-blur-sm p-4 rounded-lg min-w-[120px]">
                        <div class="text-3xl font-bold mb-1"><?= count($data['specializations']) ?>+</div>
                        <div class="text-sm opacity-90">Specialties</div>
                    </div>
                    <div
                        class="flex flex-col items-center bg-white bg-opacity-15 backdrop-blur-sm p-4 rounded-lg min-w-[120px]">
                        <div class="text-3xl font-bold mb-1">24/7</div>
                        <div class="text-sm opacity-90">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="mb-8">
            <div class="rounded-2xl border border-gray-300 p-6">
                <h2 class="text-lg font-semibold mb-2">Search Doctors</h2>
                <p class="text-sm text-gray-400 mb-4">Find doctor by name and speciality</p>

                <form action="<?= BASE_URL ?>/appointment/search" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative w-full sm:w-[42.5%]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="bx bx-search text-gray-400"></i>
                        </span>
                        <input type="text" name="search" placeholder="Search by name, specialty, or hospital..."
                            class="w-full rounded-lg py-3 px-10 border border-gray-300 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 outline-none"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <select name="specialization"
                        class="w-full sm:w-[42.5%] rounded-lg py-3 px-4 border border-gray-300 transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 outline-none appearance-none bg-[right_0.75rem_center] bg-no-repeat bg-[length:1rem] bg-[url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%236b7280%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27%3E%3C/path%3E%3C/svg%3E')]">
                        <option>All Specialties</option>
                        <?php

                        $specializations = array_unique(array_column($data['doctors'], 'specialization'));
                        foreach ($specializations as $specialization):
                            ?>
                            <option value="<?= $specialization ?>" <?= (isset($_GET['specialization']) && $_GET['specialization'] == $specialization) ? 'selected' : '' ?>>
                                <?= $specialization ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit"
                        class="w-full sm:w-[15%] bg-gray-800 hover:bg-gray-900 text-white transition-all duration-200 rounded-lg py-2 px-4 font-medium">
                        Search
                    </button>
                </form>
            </div>
            <div class="flex items-center space-x-2 mt-4 justify-end">
                <button id="cardView"
                    class="py-2 px-4 rounded-lg font-medium transition-all duration-200 flex items-center bg-primary text-white">
                    <i class="bx bxs-grid-alt mr-1"></i> Card View
                </button>
                <button id="listView"
                    class="py-2 px-4 rounded-lg font-medium transition-all duration-200 flex items-center bg-gray-200 text-gray-700 hover:bg-gray-300">
                    <i class="bx bx-list-ul mr-1"></i> List View
                </button>
            </div>
        </div>

        <!-- Doctor Cards Section - Card View (Default) -->
        <div id="doctorCardView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 fade-in">
            <?php if (empty($data['doctors'])): ?>
                <div class="col-span-full text-center py-8">
                    <i class="bx bx-search-alt text-5xl text-gray-400 mb-2"></i>
                    <h3 class="text-xl font-semibold text-gray-700">No doctors found</h3>
                    <p class="text-gray-500">Try adjusting your search criteria</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['doctors'] as $doctor): ?>
                    <!-- Doctor Card -->
                    <div class="card bg-white">
                        <!-- Replaced image header with solid primary color background -->
                        <div class="doctor-card-header">
                        </div>
                        <!-- Card Body -->
                        <div class="p-6 flex flex-col h-full relative pb-16">
                            <div class="flex flex-col items-start">
                                <div class="avatar-wrapper">
                                    <div class="avatar w-20 h-20">
                                        <?php if (!empty($doctor->profile)): ?>
                                            <img src="<?= BASE_URL . '/' . $doctor->profile ?>"
                                                class="w-full h-full object-cover rounded-full"
                                                alt="Dr. <?= $data['doctorModel']->getFullName($doctor) ?>">
                                        <?php else: ?>
                                            <i class="bx bx-user text-3xl"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-center w-full">
                                    <h3 class="font-semibold text-gray-800">Dr.
                                        <?= $data['doctorModel']->getFullName($doctor) ?>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-3 capitalize"><?= $doctor->specialization ?></p>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                                    <i class="bx bx-calendar text-primary"></i>
                                    <span><?= $data['timeSlotModel']->formatAvailableDays($data['timeSlotModel']->getDoctorAvailableDays($doctor->id)) ?></span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4 mb-3">
                                    <?php if ($doctor->status === 'available'): ?>
                                        <i class="bx bx-check-circle text-success"></i>
                                        <span>Available</span>
                                    <?php else: ?>
                                        <i class="bx bx-x-circle text-gray-400"></i>
                                        <span>Not Available</span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= BASE_URL ?>/appointment/scheduling?doctor_id=<?= $doctor->id ?>"
                                    class="schedule-btn w-full text-center">
                                    Schedule Appointment
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Doctor List View (Hidden by default) -->
        <div id="doctorListView" class="hidden flex flex-col gap-4 fade-in">
            <?php if (empty($data['doctors'])): ?>
                <div class="text-center py-8">
                    <i class="bx bx-search-alt text-5xl text-gray-400 mb-2"></i>
                    <h3 class="text-xl font-semibold text-gray-700">No doctors found</h3>
                    <p class="text-gray-500">Try adjusting your search criteria</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['doctors'] as $doctor): ?>
                    <!-- Doctor List Item -->
                    <div class="list-item card bg-white">
                        <div class="p-4 flex items-center">
                            <div class="avatar w-16 h-16 mr-4 shrink-0">
                                <?php if (!empty($doctor->profile)): ?>
                                    <img src="<?= BASE_URL . '/' . $doctor->profile ?>"
                                        class="w-full h-full object-cover rounded-full"
                                        alt="Dr. <?= $data['doctorModel']->getFullName($doctor) ?>">
                                <?php else: ?>
                                    <i class="bx bx-user text-2xl"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">Dr.
                                            <?= $data['doctorModel']->getFullName($doctor) ?>
                                        </h3>
                                        <p class="text-gray-600 text-sm"><?= $doctor->specialization ?></p>
                                        <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                            <i class="bx bx-calendar text-primary"></i>
                                            <span
                                                class=""><?= substr($data['timeSlotModel']->formatAvailableDays($data['timeSlotModel']->getDoctorAvailableDays($doctor->id)), 0, 15) ?>...</span>
                                        </div>
                                        <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                            <?php if ($doctor->status === 'available'): ?>
                                                <i class="bx bx-check-circle text-success"></i>
                                                <span>Available</span>
                                            <?php else: ?>
                                                <i class="bx bx-x-circle text-gray-400"></i>
                                                <span>Not Available</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                                        <a href="<?= BASE_URL ?>/appointment/scheduling?doctor_id=<?= $doctor->id ?>"
                                            class="schedule-btn">
                                            Schedule
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardViewBtn = document.getElementById('cardView');
            const listViewBtn = document.getElementById('listView');
            const cardView = document.getElementById('doctorCardView');
            const listView = document.getElementById('doctorListView');

            cardViewBtn.addEventListener('click', function () {
                cardView.classList.remove('hidden');
                listView.classList.add('hidden');
                cardViewBtn.classList.add('active');
                listViewBtn.classList.remove('active');
            });

            listViewBtn.addEventListener('click', function () {
                listView.classList.remove('hidden');
                cardView.classList.add('hidden');
                listViewBtn.classList.add('active');
                cardViewBtn.classList.remove('active');
            });
        });
    </script>
</body>

</html>