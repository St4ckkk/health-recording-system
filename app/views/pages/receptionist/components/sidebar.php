<?php
// Get the current request URI
$request_uri = $_SERVER['REQUEST_URI'];
?>

<nav class="bg-white p-4 sidebar border border-gray-200">
    <div class="logo-container text-white p-4 mb-6">
        <div class="mr-3">
            <div class="logo">
                <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
        <ul class="space-y-md">
            <a href="<?= BASE_URL ?>/receptionist/dashboard">
                <li class="px-sm py-2 rounded-md flex items-center cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo strpos($request_uri, '/receptionist/dashboard') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/dashboard') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-home text-lg mr-2 ml-1'></i> Dashboard
                </li>
            </a>
            <a href="<?= BASE_URL ?>/receptionist/appointments">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo strpos($request_uri, '/receptionist/appointments') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/appointments') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-calendar text-lg mr-2 ml-1'></i> Appointments
                </li>
            </a>
            <a href="<?= BASE_URL ?>/receptionist/notifications">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo strpos($request_uri, '/receptionist/notifications') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/notifications') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-bell text-lg mr-2 ml-1'></i> Notifications
                </li>
            </a>
        </ul>
    </div>
    <div class="logout-container">
        <div
            class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1">
            <i class='bx bx-log-out text-lg mr-2 ml-1'></i> Logout
        </div>
    </div>
</nav>