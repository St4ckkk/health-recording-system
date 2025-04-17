<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/doctor/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/doctor/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <!-- Patient Info Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">Treatment Records</h1>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Patient:</span>
                                        <span class="font-semibold">John Doe</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Patient ID:</span>
                                        <span class="font-semibold">P-10045</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">Age:</span>
                                        <span class="font-semibold">42</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-plus mr-1"></i> New Treatment
                                </button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-printer mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Treatments</p>
                                    <h3 class="text-2xl font-bold">12</h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="bx bx-clipboard text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Active Treatments</p>
                                    <h3 class="text-2xl font-bold">3</h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="bx bx-pulse text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Completed</p>
                                    <h3 class="text-2xl font-bold">8</h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">
                                    <i class="bx bx-check-circle text-teal-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Good Adherence</p>
                                    <h3 class="text-2xl font-bold">7</h3>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="bx bx-trending-up text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Timeline and Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Treatment Timeline -->
                        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 lg:col-span-1 fade-in">
                            <h2 class="text-lg font-semibold mb-4">Treatment Timeline</h2>
                            <div class="relative">
                                <div class="absolute h-full w-0.5 bg-gray-200 left-2.5 top-0"></div>
                                
                                <div class="mb-6 relative">
                                    <div class="flex items-start">
                                        <div class="h-5 w-5 rounded-full bg-green-500 z-10 mt-1.5"></div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <h3 class="font-medium">Intensive Phase</h3>
                                                <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Started: May 15, 2023</p>
                                            <p class="text-sm text-gray-600 mt-1">Rifampicin + Isoniazid + Pyrazinamide</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6 relative">
                                    <div class="flex items-start">
                                        <div class="h-5 w-5 rounded-full bg-blue-500 z-10 mt-1.5"></div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <h3 class="font-medium">Continuation Phase</h3>
                                                <span class="ml-2 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">Active</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Apr 10 - Jun 30, 2023</p>
                                            <p class="text-sm text-gray-600 mt-1">Rifampicin + Isoniazid</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6 relative">
                                    <div class="flex items-start">
                                        <div class="h-5 w-5 rounded-full bg-gray-500 z-10 mt-1.5"></div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <h3 class="font-medium">Intensive Phase</h3>
                                                <span class="ml-2 px-2 py-0.5 bg-gray-100 text-gray-800 text-xs rounded-full">Completed</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Jan 5 - Mar 20, 2023</p>
                                            <p class="text-sm text-gray-600 mt-1">Rifampicin + Isoniazid + Ethambutol</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6 relative">
                                    <div class="flex items-start">
                                        <div class="h-5 w-5 rounded-full bg-gray-500 z-10 mt-1.5"></div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <h3 class="font-medium">Other</h3>
                                                <span class="ml-2 px-2 py-0.5 bg-gray-100 text-gray-800 text-xs rounded-full">Discontinued</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Nov 12, 2022 - Jan 15, 2023</p>
                                            <p class="text-sm text-gray-600 mt-1">Metformin 500mg, twice daily</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative">
                                    <div class="flex items-start">
                                        <div class="h-5 w-5 rounded-full bg-gray-500 z-10 mt-1.5"></div>
                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <h3 class="font-medium">Intensive Phase</h3>
                                                <span class="ml-2 px-2 py-0.5 bg-gray-100 text-gray-800 text-xs rounded-full">Completed</span>
                                            </div>
                                            <p class="text-sm text-gray-500">Aug 3 - Oct 5, 2022</p>
                                            <p class="text-sm text-gray-600 mt-1">Rifampicin + Isoniazid + Pyrazinamide</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button class="text-blue-600 text-sm hover:underline">View All History</button>
                            </div>
                        </div>
                        
                        <!-- Charts Section -->
                        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Adherence Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Adherence Status</h2>
                                <div class="h-64">
                                    <canvas id="adherenceChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Treatment Types Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Types</h2>
                                <div class="h-64">
                                    <canvas id="treatmentTypesChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Outcomes Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Outcomes</h2>
                                <div class="h-64">
                                    <canvas id="outcomesChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Status Chart -->
                            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 fade-in">
                                <h2 class="text-lg font-semibold mb-4">Treatment Status</h2>
                                <div class="h-64">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Records Table -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Treatment Records</h2>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <input type="text" placeholder="Search records..." class="pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <i class="bx bx-search absolute left-2.5 top-2.5 text-gray-400"></i>
                                </div>
                                <select class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="discontinued">Discontinued</option>
                                </select>
                                <button class="px-3 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">
                                    <i class="bx bx-filter mr-1"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Treatment Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Regimen</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adherence</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outcome</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TR-001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Intensive Phase</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rifampicin + Isoniazid + Pyrazinamide</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 15, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 29, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Good</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ongoing</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900"><i class="bx bx-edit"></i></button>
                                                <button class="text-gray-600 hover:text-gray-900"><i class="bx bx-detail"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TR-002</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Continuation Phase</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rifampicin + Isoniazid</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Apr 10, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jun 30, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Irregular</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Ongoing</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900"><i class="bx bx-edit"></i></button>
                                                <button class="text-gray-600 hover:text-gray-900"><i class="bx bx-detail"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TR-003</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Intensive Phase</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rifampicin + Isoniazid + Ethambutol</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 5, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mar 20, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Good</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cured</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Completed</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900"><i class="bx bx-edit"></i></button>
                                                <button class="text-gray-600 hover:text-gray-900"><i class="bx bx-detail"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TR-004</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Other</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Metformin 500mg, twice daily</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nov 12, 2022</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 15, 2023</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Poor</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Failed</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Discontinued</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900"><i class="bx bx-edit"></i></button>
                                                <button class="text-gray-600 hover:text-gray-900"><i class="bx bx-detail"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TR-005</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Intensive Phase</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rifampicin + Isoniazid + Pyrazinamide</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Aug 3, 2022</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Oct 5, 2022</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Good</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Completed</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Completed</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-900"><i class="bx bx-edit"></i></button>
                                                <button class="text-gray-600 hover:text-gray-900"><i class="bx bx-detail"></i></button>
                                                <button class="text-red-600 hover:text-red-900"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">12</span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-500 hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-blue-600 text-white hover:bg-blue-700">1</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50">2</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50">3</button>
                                <button class="px-3 py-1 border border-gray-300 rounded-md text-sm bg-white text-gray-700 hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Treatment Details -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mb-6 fade-in">
                        <h2 class="text-lg font-semibold mb-4">Current Treatment Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Treatment Info -->
                            <div class="md:col-span-2">
                                <div class="border-b pb-4 mb-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-medium text-gray-900">Intensive Phase</h3>
                                            <p class="text-sm text-gray-500 mt-1">Started: May 15, 2023 (14 days ago)</p>
                                        </div>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Regimen</h4>
                                        <p class="mt-1">Rifampicin + Isoniazid + Pyrazinamide</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Duration</h4>
                                        <p class="mt-1">2 months (May 15 - Jul 15, 2023)</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Prescribed By</h4>
                                        <p class="mt-1">Dr. Sarah Johnson</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Diagnosis</h4>
                                        <p class="mt-1">Pulmonary Tuberculosis</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Follow-up Notes</h4>
                                    <p class="text-sm text-gray-700">
                                        Patient responding well to treatment. Sputum test shows decreased bacterial load after 10 days. 
                                        Continue current regimen until completion. Schedule follow-up appointment after 1 month for reassessment.
                                    </p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Adherence Tracking</h4>
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width: 95%"></div>
                                    </div>
                                    <div class="flex justify-between mt-1 text-xs text-gray-500">
                                        <span>Poor</span>
                                        <span>Adherence: Good</span>
                                        <span>100%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Side Actions -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900 mb-3">Actions</h3>
                                <div class="space-y-3">
                                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center justify-center">
                                        <i class="bx bx-edit mr-2"></i> Update Treatment
                                    </button>
                                    <button class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors flex items-center justify-center">
                                        <i class="bx bx-check-circle mr-2"></i> Mark as Completed
                                    </button>
                                    <button class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors flex items-center justify-center">
                                        <i class="bx bx-calendar-plus mr-2"></i> Schedule Follow-up
                                    </button>
                                    <button class="w-full px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors flex items-center justify-center">
                                        <i class="bx bx-printer mr-2"></i> Print Details
                                    </button>
                                </div>
                                
                                <div class="mt-6">
                                    <h3 class="font-medium text-gray-900 mb-3">Related Records</h3>
                                    <ul class="space-y-2">
                                        <li>
                                            <a href="#" class="text-blue-600 hover:underline flex items-center">
                                                <i class="bx bx-file mr-2"></i> Lab Results (May 20, 2023)
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-blue-600 hover:underline flex items-center">
                                                <i class="bx bx-file mr-2"></i> Initial Diagnosis (May 15, 2023)
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="text-blue-600 hover:underline flex items-center">
                                                <i class="bx bx-file mr-2"></i> Prescription Details
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Chart.js Initialization -->
    <script>
        // Adherence Chart
        const adherenceCtx = document.getElementById('adherenceChart').getContext('2d');
        const adherenceChart = new Chart(adherenceCtx, {
            type: 'pie',
            data: {
                labels: ['Good', 'Irregular', 'Poor'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for Good
                        'rgba(245, 158, 11, 0.8)',  // Yellow for Irregular
                        'rgba(239, 68, 68, 0.8)'    // Red for Poor
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Treatment Types Chart
        const typesCtx = document.getElementById('treatmentTypesChart').getContext('2d');
        const treatmentTypesChart = new Chart(typesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Intensive Phase', 'Continuation Phase', 'Other'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(156, 163, 175, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Outcomes Chart
        const outcomesCtx = document.getElementById('outcomesChart').getContext('2d');
        const outcomesChart = new Chart(outcomesCtx, {
            type: 'bar',
            data: {
                labels: ['Ongoing', 'Cured', 'Completed', 'Failed', 'Lost to follow-up', 'Died'],
                datasets: [{
                    label: 'Treatment Outcomes',
                    data: [35, 25, 20, 10, 8, 2],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',  // Blue for Ongoing
                        'rgba(16, 185, 129, 0.8)',  // Green for Cured
                        'rgba(79, 70, 229, 0.8)',   // Indigo for Completed
                        'rgba(239, 68, 68, 0.8)',   // Red for Failed
                        'rgba(245, 158, 11, 0.8)',  // Yellow for Lost to follow-up
                        'rgba(107, 114, 128, 0.8)'  // Gray for Died
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Active', 'Completed', 'Discontinued'],
                datasets: [{
                    data: [30, 60, 10],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for Active
                        'rgba(79, 70, 229, 0.8)',   // Indigo for Completed
                        'rgba(239, 68, 68, 0.8)'    // Red for Discontinued
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>

</html>