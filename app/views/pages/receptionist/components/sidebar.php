<?php
// Get the current request URI
$request_uri = $_SERVER['REQUEST_URI'];

// Static notification count for testing
$notification_count = 3;
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
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2 <?php echo strpos($request_uri, '/receptionist/dashboard') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/dashboard') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-home text-lg mr-2 ml-1'></i> Dashboard
                </li>
            </a>
            <a href="<?= BASE_URL ?>/receptionist/appointments">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2 <?php echo strpos($request_uri, '/receptionist/appointments') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/appointments') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-calendar text-lg mr-2 ml-1'></i> Appointments
                </li>
            </a>
            <a href="<?= BASE_URL ?>/receptionist/doctor_schedules">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2 <?php echo strpos($request_uri, '/receptionist/doctor_schedules') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/doctor_schedules') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-user-circle text-lg mr-2 ml-1'></i> Doctor Schedules
                </li>
            </a>
            <a href="<?= BASE_URL ?>/receptionist/notification">
                <li class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 <?php echo strpos($request_uri, '/receptionist/notification') !== false ? 'active' : ''; ?>"
                    style="<?php echo strpos($request_uri, '/receptionist/notification') !== false ? 'background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;' : ''; ?>">
                    <i class='bx bx-bell text-lg mr-2 ml-1'></i>
                    <div class="flex items-center">
                        Notifications
                        <?php if ($notification_count > 0): ?>
                            <span
                                class="ml-2 inline-flex items-center justify-center px-1.5 py-0.6 text-xs font-medium text-white bg-gray-900 rounded">
                                <?php echo $notification_count; ?> new
                            </span>
                        <?php endif; ?>
                    </div>
                </li>
            </a>
        </ul>
    </div>
    <div class="logout-container">
        <!-- Changed from direct link to button that triggers modal -->
        <div id="sidebarLogoutBtn"
            class="px-sm py-2 rounded-md hover:bg-primary-light flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1">
            <i class='bx bx-log-out text-lg mr-2 ml-1'></i> Logout
        </div>
    </div>
</nav>

<script>
    // Only initialize if the function doesn't already exist (to avoid conflicts with header.php)
    if (typeof window.openLogoutModal === 'undefined') {
        // Define functions in the global scope
        window.openLogoutModal = function () {
            const logoutModal = document.getElementById('logoutModal');
            const logoutModalContent = document.getElementById('logoutModalContent');

            logoutModal.classList.remove('hidden');
            logoutModal.classList.add('flex');

            // Animate in
            setTimeout(() => {
                logoutModalContent.classList.remove('scale-95', 'opacity-0');
                logoutModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
        };

        window.closeLogoutModal = function () {
            const logoutModal = document.getElementById('logoutModal');
            const logoutModalContent = document.getElementById('logoutModalContent');

            // Animate out
            logoutModalContent.classList.remove('scale-100', 'opacity-100');
            logoutModalContent.classList.add('scale-95', 'opacity-0');

            // Wait for animation to complete
            setTimeout(() => {
                logoutModal.classList.remove('flex');
                logoutModal.classList.add('hidden');

                // Restore body scrolling
                document.body.style.overflow = '';
            }, 300);
        };
    }

    // Add event listener for the sidebar logout button
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarLogoutBtn = document.getElementById('sidebarLogoutBtn');
        if (sidebarLogoutBtn) {
            sidebarLogoutBtn.addEventListener('click', window.openLogoutModal);
        }
    });
</script>