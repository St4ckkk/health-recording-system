<?php
// Get the current request URI
$request_uri = $_SERVER['REQUEST_URI'];


$notification_count = 3;
?>

<nav class="p-4 sidebar border border-gray-200">
    <div class=" p-4 mb-6 bg-green-600 rounded-lg">
        <div class="flex items-center">
            <div class="logo">
                <div class="w-12 h-12 flex justify-center items-center font-bold text-white border-2 border-white rounded-lg">
                    <span class="text-xl">TC</span>
                </div>
            </div>
            <div class="ml-3 text-white">
                <div class="text-lg font-semibold">TeleCure</div>
                <div class="text-xs opacity-80">Doctor Portal</div>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
        <ul class="space-y-md">
            <a href="<?= BASE_URL ?>/doctor/dashboard">
                <li class="px-sm py-2 rounded-md hover:bg-green-600 hover:text-white flex items-center cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2"
                    style="<?php echo strpos($request_uri, '/doctor/dashboard') !== false ? 'background-color: rgb(22 163 74); color: white;' : ''; ?>">
                    <i class='bx bx-home text-lg mr-2 ml-1'></i> Dashboard
                </li>
            </a>

            <a href="<?= BASE_URL ?>/doctor/patients">
                <li class="px-sm py-2 rounded-md hover:bg-green-600 hover:text-white flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2"
                    style="<?php echo strpos($request_uri, '/doctor/patients') !== false ? 'background-color: rgb(22 163 74); color: white;' : ''; ?>">
                    <i class='bx bx-user-circle text-lg mr-2 ml-1'></i> Patients
                </li>
            </a>

            <a href="<?= BASE_URL ?>/doctor/inventory">
                <li class="px-sm py-2 rounded-md hover:bg-green-600 hover:text-white flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 mb-2"
                    style="<?php echo strpos($request_uri, '/doctor/inventory') !== false ? 'background-color: rgb(22 163 74); color: white;' : ''; ?>">
                    <i class='bx bx-capsule text-lg mr-2 ml-1'></i> Medicine Inventory
                </li>
            </a>

            <a href="<?= BASE_URL ?>/doctor/notification">
                <li class="px-sm py-2 rounded-md hover:bg-green-600 hover:text-white flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1"
                    style="<?php echo strpos($request_uri, '/doctor/notification') !== false ? 'background-color: rgb(22 163 74); color: white;' : ''; ?>">
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
    <div class="logout-container mt-auto">
        
        <button id="sidebarLogoutBtn"
            class="px-sm py-2 rounded-md hover:bg-green-600 flex items-center text-gray-900 cursor-pointer transition-all duration-200 hover:translate-x-1 hover:text-white">
            <i class='bx bx-log-out text-lg mr-2 ml-1'></i> Logout
        </button>
        
        <!-- Doctor Profile Section -->
      
    </div>
</nav>

<!-- Logout Confirmation Modal -->
<div id="sidebarLogoutModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div id="sidebarLogoutModalContent"
        class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Confirm Logout</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeSidebarLogoutModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Are you sure you want to log out of your account?</p>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelSidebarLogoutBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <a href="<?= BASE_URL ?>/doctor/logout"
                class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none">
                Yes, Logout
            </a>
        </div>
    </div>
</div>

<script>
    // Only initialize once by checking if the function already exists
    if (typeof window.openSidebarLogoutModal === 'undefined') {
        window.openSidebarLogoutModal = function() {
            const modal = document.getElementById('sidebarLogoutModal');
            const modalContent = document.getElementById('sidebarLogoutModalContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        };

        window.closeSidebarLogoutModal = function() {
            const modal = document.getElementById('sidebarLogoutModal');
            const modalContent = document.getElementById('sidebarLogoutModalContent');

            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        };

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('sidebarLogoutBtn');
            const modal = document.getElementById('sidebarLogoutModal');
            const closeModal = document.getElementById('closeSidebarLogoutModal');
            const cancelBtn = document.getElementById('cancelSidebarLogoutBtn');

            if (logoutBtn) logoutBtn.addEventListener('click', window.openSidebarLogoutModal);
            if (closeModal) closeModal.addEventListener('click', window.closeSidebarLogoutModal);
            if (cancelBtn) cancelBtn.addEventListener('click', window.closeSidebarLogoutModal);

            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        window.closeSidebarLogoutModal();
                    }
                });
            }
        });
    }
</script>