<?php
$current_page = basename($_SERVER['PHP_SELF']);
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
            <a href="dashboard.php">
                <li class="px-sm py-2 rounded-md flex items-center cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"
                    style="<?php echo $current_page == 'dashboard.php' ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-home text-lg mr-2 ml-1'></i> Dashboard
                </li>
            </a>
            <a href="appointments.php">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo $current_page == 'appointments.php' ? 'active' : ''; ?>"
                    style="<?php echo $current_page == 'appointments.php' ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-calendar text-lg mr-2 ml-1'></i> Appointments
                </li>
            </a>
            <a href="notifications.php">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo $current_page == 'notifications.php' ? 'active' : ''; ?>"
                    style="<?php echo $current_page == 'notifications.php' ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
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