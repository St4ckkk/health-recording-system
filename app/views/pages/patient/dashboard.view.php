<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Patient Dashboard' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
</head>

<body class="font-body bg-gray-50">
    <div class="flex">
        <!-- Sidebar would go here if needed -->
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/patient/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-4 md:p-6 max-w-7xl mx-auto">
                    <!-- Dashboard Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Health Monitoring Dashboard</h1>
                                <p class="text-gray-600">Welcome back, <?= htmlspecialchars($patient_name ?? 'Patient') ?>! Track your health journey here.</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <button class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg text-sm flex items-center transition-colors">
                                    <i class="bx bx-download mr-2"></i> Export Health Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Medication Adherence</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">92%</h3>
                                    <p class="text-teal-500 text-xs mt-1 flex items-center">
                                        <i class="bx bx-up-arrow-alt mr-1"></i> 3% from last week
                                    </p>
                                </div>
                                <div class="bg-teal-100 p-3 rounded-full">
                                    <i class="bx bx-capsule text-teal-500 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Symptom Status</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Stable</h3>
                                    <p class="text-indigo-500 text-xs mt-1 flex items-center">
                                        <i class="bx bx-check-circle mr-1"></i> Improving
                                    </p>
                                </div>
                                <div class="bg-indigo-100 p-3 rounded-full">
                                    <i class="bx bx-pulse text-indigo-500 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Wellness Score</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">4.2/5</h3>
                                    <p class="text-purple-500 text-xs mt-1 flex items-center">
                                        <i class="bx bx-up-arrow-alt mr-1"></i> 0.3 from last week
                                    </p>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i class="bx bx-heart text-purple-500 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-500 text-sm font-medium">Next Check-up</p>
                                    <h3 class="text-2xl font-bold text-gray-800 mt-1">3 days</h3>
                                    <p class="text-amber-500 text-xs mt-1 flex items-center">
                                        <i class="bx bx-calendar-event mr-1"></i> May 20, 2023
                                    </p>
                                </div>
                                <div class="bg-amber-100 p-3 rounded-full">
                                    <i class="bx bx-calendar text-amber-500 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Symptom Tracker Chart -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Symptom Trends</h2>
                                        <p class="text-sm text-gray-500">Track your symptoms over time</p>
                                    </div>
                                    <div class="flex space-x-2 mt-2 sm:mt-0">
                                        <button class="px-3 py-1 text-xs bg-teal-100 text-teal-600 rounded-full font-medium">Week</button>
                                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">Month</button>
                                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">Year</button>
                                    </div>
                                </div>
                                <div class="h-72">
                                    <canvas id="symptomChart"></canvas>
                                </div>
                                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-xs">
                                    <div class="p-2 bg-teal-50 rounded-lg">
                                        <p class="text-gray-500">Cough</p>
                                        <p class="font-bold text-teal-600">Mild</p>
                                    </div>
                                    <div class="p-2 bg-indigo-50 rounded-lg">
                                        <p class="text-gray-500">Fatigue</p>
                                        <p class="font-bold text-indigo-600">Level 2</p>
                                    </div>
                                    <div class="p-2 bg-purple-50 rounded-lg">
                                        <p class="text-gray-500">Chest Pain</p>
                                        <p class="font-bold text-purple-600">None</p>
                                    </div>
                                    <div class="p-2 bg-amber-50 rounded-lg">
                                        <p class="text-gray-500">Fever</p>
                                        <p class="font-bold text-amber-600">No</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Medication Log -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Medication Log</h2>
                                        <p class="text-sm text-gray-500">Track your medication adherence</p>
                                    </div>
                                    <button class="mt-2 sm:mt-0 px-4 py-2 bg-teal-500 text-white rounded-lg text-sm flex items-center hover:bg-teal-600 transition-colors">
                                        <i class="bx bx-plus mr-2"></i> Add Entry
                                    </button>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="py-3 px-4 text-sm font-medium">May 15, 2023</td>
                                                <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Taken</span></td>
                                                <td class="py-3 px-4 text-sm">08:30 AM</td>
                                                <td class="py-3 px-4 text-sm">Taken with breakfast</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <button class="text-gray-500 hover:text-teal-500 transition-colors">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="py-3 px-4 text-sm font-medium">May 14, 2023</td>
                                                <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Taken</span></td>
                                                <td class="py-3 px-4 text-sm">08:15 AM</td>
                                                <td class="py-3 px-4 text-sm">-</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <button class="text-gray-500 hover:text-teal-500 transition-colors">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="py-3 px-4 text-sm font-medium">May 13, 2023</td>
                                                <td class="py-3 px-4"><span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Missed</span></td>
                                                <td class="py-3 px-4 text-sm">-</td>
                                                <td class="py-3 px-4 text-sm">Was traveling</td>
                                                <td class="py-3 px-4 text-sm">
                                                    <button class="text-gray-500 hover:text-teal-500 transition-colors">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="#" class="text-teal-500 text-sm font-medium hover:text-teal-600 transition-colors flex items-center justify-end">
                                        View all entries <i class="bx bx-right-arrow-alt ml-1"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Symptom Log Form -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Log Your Symptoms</h2>
                                        <p class="text-sm text-gray-500">Record how you're feeling today</p>
                                    </div>
                                    <div class="mt-2 sm:mt-0">
                                        <input type="date" class="date-picker px-3 py-2 border border-gray-300 rounded-lg text-sm" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Cough</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                            <option>None</option>
                                            <option>Mild</option>
                                            <option>Severe</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fever</label>
                                        <div class="flex items-center space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="fever" value="0" class="h-4 w-4 text-teal-600">
                                                <span class="ml-2 text-sm">No</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="fever" value="1" class="h-4 w-4 text-teal-600">
                                                <span class="ml-2 text-sm">Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Temperature (°F)</label>
                                        <input type="number" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="98.6">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Chest Pain</label>
                                        <div class="flex items-center space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="chest_pain" value="0" class="h-4 w-4 text-teal-600">
                                                <span class="ml-2 text-sm">No</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="chest_pain" value="1" class="h-4 w-4 text-teal-600">
                                                <span class="ml-2 text-sm">Yes</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fatigue Level (1-5)</label>
                                        <div class="flex space-x-4">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <label class="flex flex-col items-center">
                                                    <input type="radio" name="fatigue_level" value="<?= $i ?>" class="h-4 w-4 text-teal-600">
                                                    <span class="mt-1 text-sm"><?= $i ?></span>
                                                </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Appetite Loss</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                            <option>Normal</option>
                                            <option>Slight</option>
                                            <option>Severe</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                            Save Symptom Log
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Wellness Survey -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Weekly Wellness Check</h2>
                                        <p class="text-sm text-gray-500">Help us monitor your progress</p>
                                    </div>
                                    <span class="mt-2 sm:mt-0 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">Due Today</span>
                                </div>
                                <div class="p-4 bg-amber-50 rounded-lg mb-6">
                                    <p class="text-amber-800 text-sm">Please complete your weekly wellness survey to help us monitor your progress and provide better care.</p>
                                </div>
                                <form class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Energy Level (1-5)</label>
                                        <div class="flex space-x-6">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <label class="flex flex-col items-center">
                                                    <input type="radio" name="energy_level" value="<?= $i ?>" class="h-4 w-4 text-teal-600">
                                                    <span class="mt-1 text-sm"><?= $i ?></span>
                                                    <span class="text-xs text-gray-500 mt-1"><?= $i == 1 ? 'Low' : ($i == 5 ? 'High' : '') ?></span>
                                                </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Sleep Quality</label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                                <option>Good</option>
                                                <option>Average</option>
                                                <option>Poor</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Emotional State</label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                                <option>Happy</option>
                                                <option>Anxious</option>
                                                <option>Sad</option>
                                                <option>Angry</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nutrition State</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                            <option>Normal</option>
                                            <option>Reduced</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Any Life Changes?</label>
                                        <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="Please describe any significant life changes..."></textarea>
                                    </div>
                                    <div class="pt-2">
                                        <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                            Submit Weekly Survey
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Notifications -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Notifications</h2>
                                        <p class="text-sm text-gray-500">Your latest updates</p>
                                    </div>
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">3 New</span>
                                </div>
                                <div class="space-y-4">
                                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-blue-800">Medication Reminder</p>
                                            <span class="text-xs text-gray-500">1h ago</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Don't forget to take your evening medication.</p>
                                        <div class="mt-2 flex justify-end">
                                            <button class="text-xs text-blue-600 hover:text-blue-800 transition-colors">Mark as read</button>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-green-800">Achievement Unlocked</p>
                                            <span class="text-xs text-gray-500">1d ago</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">You've earned the "Perfect Week" badge for medication adherence!</p>
                                        <div class="mt-2 flex justify-end">
                                            <button class="text-xs text-green-600 hover:text-green-800 transition-colors">Mark as read</button>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                                        <div class="flex justify-between">
                                            <p class="text-sm font-medium text-purple-800">Doctor's Message</p>
                                            <span class="text-xs text-gray-500">2d ago</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Your lab results look good. Keep up the good work!</p>
                                        <div class="mt-2 flex justify-end">
                                            <button class="text-xs text-purple-600 hover:text-purple-800 transition-colors">Mark as read</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-teal-500 text-sm font-medium hover:text-teal-600 transition-colors">View all notifications</a>
                                </div>
                            </div>

                            <!-- Achievement Badges -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Your Achievements</h2>
                                        <p class="text-sm text-gray-500">Badges you've earned</p>
                                    </div>
                                    <span class="px-2 py-1 bg-teal-100 text-teal-800 rounded-full text-xs font-medium">3 Earned</span>
                                </div>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="p-3 bg-yellow-50 rounded-lg">
                                        <div class="mx-auto w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                                            <i class="bx bx-medal text-yellow-500 text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-medium mt-2">Perfect Week</p>
                                        <p class="text-xs text-gray-500">May 10</p>
                                    </div>
                                    <div class="p-3 bg-blue-50 rounded-lg">
                                        <div class="mx-auto w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="bx bx-calendar-check text-blue-500 text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-medium mt-2">30 Day Streak</p>
                                        <p class="text-xs text-gray-500">Apr 28</p>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg opacity-60">
                                        <div class="mx-auto w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class="bx bx-trending-up text-gray-500 text-2xl"></i>
                                        </div>
                                        <p class="text-xs font-medium mt-2">Symptom Free</p>
                                        <p class="text-xs text-gray-500">Locked</p>
                                    </div>
                                </div>
                                <div class="mt-6 text-center">
                                    <a href="#" class="text-teal-500 text-sm font-medium hover:text-teal-600 transition-colors">View all badges</a>
                                </div>
                            </div>

                            <!-- Consultation Request -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Request Consultation</h2>
                                        <p class="text-sm text-gray-500">Need to speak with your doctor?</p>
                                    </div>
                                </div>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Consultation</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                            <option>New symptoms</option>
                                            <option>Medication side effects</option>
                                            <option>General check-up</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
                                        <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="Please describe your concern in detail..."></textarea>
                                    </div>
                                    <div class="pt-2">
                                        <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                                            Submit Request
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Upcoming Appointments -->
                            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-800">Upcoming Appointments</h2>
                                        <p class="text-sm text-gray-500">Your scheduled visits</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                                        <div class="flex items-start">
                                            <div class="bg-teal-100 p-3 rounded-full mr-4">
                                                <i class="bx bx-calendar text-teal-500 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-medium">Regular Check-up</h3>
                                                <p class="text-sm text-gray-500">May 20, 2023 • 10:30 AM</p>
                                                <p class="text-sm text-gray-500 mt-1">Dr. Johnson • Virtual Visit</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex space-x-2">
                                            <button class="px-3 py-1 text-xs bg-teal-100 text-teal-600 rounded-full font-medium">Join Call</button>
                                            <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">Reschedule</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        // Initialize symptom chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('symptomChart').getContext('2d');
            const symptomChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['May 10', 'May 11', 'May 12', 'May 13', 'May 14', 'May 15', 'May 16'],
                    datasets: [
                        {
                            label: 'Fatigue Level',
                            data: [3, 4, 3, 2, 2, 1, 1],
                            borderColor: 'rgba(79, 209, 197, 1)',
                            backgroundColor: 'rgba(79, 209, 197, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(79, 209, 197, 1)',
                            pointRadius: 4
                        },
                        {
                            label: 'Cough Severity',
                            data: [2, 2, 1, 1, 0, 0, 0],
                            borderColor: 'rgba(129, 140, 248, 1)',
                            backgroundColor: 'rgba(129, 140, 248, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(129, 140, 248, 1)',
                            pointRadius: 4
                        },
                        {
                            label: 'Temperature',
                            data: [99.1, 99.3, 98.9, 98.7, 98.6, 98.6, 98.5],
                            borderColor: 'rgba(245, 158, 11, 1)',
                            backgroundColor: 'rgba(245, 158, 11, 0.2)',
                            tension: 0.4,
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                            pointRadius: 4,
                            hidden: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#111827',
                            bodyColor: '#4B5563',
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            padding: 10,
                            boxPadding: 4
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                color: 'rgba(243, 244, 246, 1)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                color: '#9CA3AF'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#9CA3AF'
                            }
                        }
                    }
                }
            });

            // Initialize flatpickr for any date inputs
            flatpickr(".date-picker", {
                dateFormat: "Y-m-d",
                defaultDate: new Date()
            });
        });
    </script>
</body>

</html>