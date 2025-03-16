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
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            border: 3px solid white;
        }

        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        /* Enhanced doctor card header */
        .doctor-card-header {
            height: 100px;
            position: relative;
            overflow: hidden;
        }

        .doctor-card-header-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .doctor-card-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .doctor-card-header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 2;
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

        .doctor-card-header-icon {
            position: absolute;
            top: 8px;
            left: 12px;
            color: white;
            font-size: 20px;
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
        }

        .image-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
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
    <div class="w-64 h-16 mb-12">
        <div class="logo-container text-white p-4 inline-flex items-center">
            <div class="mr-2">
                <div class="logo">
                    <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
                </div>
            </div>
            <span class="text-2xl font-bold">Test Clinic</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <!-- Image Header Section -->
        <div class="image-header">
            <img src="<?= BASE_URL ?>/images/image-header.jpg" class="image-header-bg" alt="Doctors Team">
            <div class="image-header-overlay"></div>
            <div class="image-header-pattern"></div>
            <div class="image-header-content mt-2">
                <h1 class="image-header-title">Expert Medical Care From Our Professional Doctors</h1>
                <p class="image-header-subtitle">Schedule appointments with top specialists in various medical fields
                </p>

                <div class="image-header-stats">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Specialists</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Specialties</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="mb-8">
            <div class="search-container border border-gray-300">
                <h2 class="text-lg font-semibold  mb-2">Search Doctors</h2>
                <p class="text-sm text-gray-400 mb-4">Find doctor by name and speciality</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative w-full sm:w-[42.5%]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="bx bx-search text-gray-400"></i>
                        </span>
                        <input type="text" placeholder="Search by name, specialty, or hospital..."
                            class="search-input w-full">
                    </div>
                    <select class="select-input w-full sm:w-[42.5%]">
                        <option>All Specialties</option>
                        <option>Cardiology</option>
                        <option>Neurology</option>
                        <option>Pediatrics</option>
                    </select>
                    <button class="btn-primary w-full sm:w-[15%] bg-gray-800 hover:bg-gray-900">
                        Search
                    </button>
                </div>
            </div>
            <!-- View toggle buttons moved to right side -->
            <div class="flex items-center space-x-2 mt-4 justify-end">
                <button id="cardView" class="view-btn active">
                    <i class="bx bxs-grid-alt mr-1"></i> Card View
                </button>
                <button id="listView" class="view-btn">
                    <i class="bx bx-list-ul mr-1"></i> List View
                </button>
            </div>
        </div>

        <!-- Doctor Cards Section - Card View (Default) -->
        <div id="doctorCardView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 fade-in">
            <!-- Doctor Card 1 -->
            <div class="card bg-white">
                <div class="doctor-card-header">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        class="doctor-card-header-img" alt="Cardiology">
                    <div class="doctor-card-header-overlay"></div>
                    <div class="doctor-card-header-pattern"></div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="flex flex-col items-start">
                        <div class="avatar-wrapper">
                            <div class="avatar w-20 h-20">
                                <i class="bx bx-user text-3xl"></i>
                            </div>
                        </div>
                        <div class="text-center w-full">
                            <h3 class="font-semibold text-gray-800">Dr. Abdul Marot</h3>
                            <p class="text-gray-600 text-sm mb-3">Cardio Specialist</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                            <i class="bx bx-calendar text-primary"></i>
                            <span>Monday, Wednesday, Friday</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-4">
                            <i class="bx bx-check-circle text-success"></i>
                            <span>Available</span>
                        </div>
                        <button class="schedule-btn w-full">
                            Schedule Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Doctor Card 2 -->
            <div class="card bg-white">
                <div class="doctor-card-header">
                    <img src="https://images.unsplash.com/photo-1559757175-7cb036e0159b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        class="doctor-card-header-img" alt="Neurology">
                    <div class="doctor-card-header-overlay"></div>
                    <div class="doctor-card-header-pattern"></div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="flex flex-col items-start">
                        <div class="avatar-wrapper">
                            <div class="avatar w-20 h-20">
                                <i class="bx bx-user text-3xl"></i>
                            </div>
                        </div>
                        <div class="text-center w-full">
                            <h3 class="font-semibold text-gray-800">Dr. Sarah Johnson</h3>
                            <p class="text-gray-600 text-sm mb-3">Neurologist</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                            <i class="bx bx-calendar text-primary"></i>
                            <span>Tuesday, Thursday</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-4">
                            <i class="bx bx-check-circle text-success"></i>
                            <span>Available</span>
                        </div>
                        <button class="schedule-btn w-full">
                            Schedule Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Doctor Card 3 -->
            <div class="card bg-white">
                <div class="doctor-card-header">
                    <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        class="doctor-card-header-img" alt="Pediatrics">
                    <div class="doctor-card-header-overlay"></div>
                    <div class="doctor-card-header-pattern"></div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="flex flex-col items-start">
                        <div class="avatar-wrapper">
                            <div class="avatar w-20 h-20">
                                <i class="bx bx-user text-3xl"></i>
                            </div>
                        </div>
                        <div class="text-center w-full">
                            <h3 class="font-semibold text-gray-800">Dr. Michael Chen</h3>
                            <p class="text-gray-600 text-sm mb-3">Pediatrician</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                            <i class="bx bx-calendar text-primary"></i>
                            <span>Monday, Tuesday, Friday</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-4">
                            <i class="bx bx-check-circle text-success"></i>
                            <span>Available</span>
                        </div>
                        <button class="schedule-btn w-full">
                            Schedule Appointment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Doctor Card 4 -->
            <div class="card bg-white">
                <div class="doctor-card-header">
                    <img src="https://images.unsplash.com/photo-1505751172876-fa1923c5c528?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        class="doctor-card-header-img" alt="Dermatology">
                    <div class="doctor-card-header-overlay"></div>
                    <div class="doctor-card-header-pattern"></div>
                </div>
                <!-- Card Body -->
                <div class="p-6">
                    <div class="flex flex-col items-start">
                        <div class="avatar-wrapper">
                            <div class="avatar w-20 h-20">
                                <i class="bx bx-user text-3xl"></i>
                            </div>
                        </div>
                        <div class="text-center w-full">
                            <h3 class="font-semibold text-gray-800">Dr. Emily Rodriguez</h3>
                            <p class="text-gray-600 text-sm mb-3">Dermatologist</p>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-2">
                            <i class="bx bx-calendar text-primary"></i>
                            <span>Wednesday, Thursday</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-700 mb-4">
                            <i class="bx bx-check-circle text-success"></i>
                            <span>Available</span>
                        </div>
                        <button class="schedule-btn w-full">
                            Schedule Appointment
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor List View (Hidden by default) -->
        <div id="doctorListView" class="hidden flex flex-col gap-4 fade-in">
            <!-- Doctor List Item 1 -->
            <div class="list-item card bg-white">
                <div class="p-4 flex items-center">
                    <div class="avatar w-16 h-16 mr-4 shrink-0">
                        <i class="bx bx-user text-2xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div>
                                <h3 class="font-semibold text-gray-800">Dr. Abdul Marot</h3>
                                <p class="text-gray-600 text-sm">Cardio Specialist</p>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-calendar text-primary"></i>
                                    <span class="hidden sm:inline">Monday, Wednesday, Friday</span>
                                    <span class="sm:hidden">Mon, Wed, Fri</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-check-circle text-success"></i>
                                    <span>Available</span>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                                <button class="schedule-btn">
                                    Schedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor List Item 2 -->
            <div class="list-item card bg-white">
                <div class="p-4 flex items-center">
                    <div class="avatar w-16 h-16 mr-4 shrink-0">
                        <i class="bx bx-user text-2xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div>
                                <h3 class="font-semibold text-gray-800">Dr. Sarah Johnson</h3>
                                <p class="text-gray-600 text-sm">Neurologist</p>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-calendar text-primary"></i>
                                    <span class="hidden sm:inline">Tuesday, Thursday</span>
                                    <span class="sm:hidden">Tue, Thu</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-check-circle text-success"></i>
                                    <span>Available</span>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                                <button class="schedule-btn">
                                    Schedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor List Item 3 -->
            <div class="list-item card bg-white">
                <div class="p-4 flex items-center">
                    <div class="avatar w-16 h-16 mr-4 shrink-0">
                        <i class="bx bx-user text-2xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div>
                                <h3 class="font-semibold text-gray-800">Dr. Michael Chen</h3>
                                <p class="text-gray-600 text-sm">Pediatrician</p>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-calendar text-primary"></i>
                                    <span class="hidden sm:inline">Monday, Tuesday, Friday</span>
                                    <span class="sm:hidden">Mon, Tue, Fri</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-check-circle text-success"></i>
                                    <span>Available</span>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                                <button class="schedule-btn">
                                    Schedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor List Item 4 -->
            <div class="list-item card bg-white">
                <div class="p-4 flex items-center">
                    <div class="avatar w-16 h-16 mr-4 shrink-0">
                        <i class="bx bx-user text-2xl"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div>
                                <h3 class="font-semibold text-gray-800">Dr. Emily Rodriguez</h3>
                                <p class="text-gray-600 text-sm">Dermatologist</p>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-calendar text-primary"></i>
                                    <span class="hidden sm:inline">Wednesday, Thursday</span>
                                    <span class="sm:hidden">Wed, Thu</span>
                                </div>
                                <div class="flex items-center space-x-2 text-sm text-gray-700 mr-4">
                                    <i class="bx bx-check-circle text-success"></i>
                                    <span>Available</span>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0 flex flex-wrap gap-2 items-center">
                                <button class="schedule-btn">
                                    Schedule
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for view switching -->
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