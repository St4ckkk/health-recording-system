<header class="p-5 flex justify-end items-center border-b border-gray-200 bg-white">
    <div class="flex items-center gap-2">
        <i class='bx bx-bell text-gray-900' style="font-size: 1.4rem;"></i>
        <div class="avatar w-12 h-12">
            <?php if (isset($_SESSION['staff']) && !empty($_SESSION['staff']['profile'])): ?>
                <img src="<?= BASE_URL ?>/<?= $_SESSION['staff']['profile'] ?>" alt="Profile"
                    class="w-full h-full rounded-full object-cover">
            <?php else: ?>
                <i class="bx bx-user text-3xl"></i>
            <?php endif; ?>
        </div>
        <div>
            <?php
            $staff = $_SESSION['staff'] ?? null;
            $staffName = $staff && isset($staff['first_name']) ? $staff['first_name'] . ' ' . $staff['last_name'] : 'Unknown User';
            $staffRole = $staff && isset($staff['role_name']) ? ucfirst($staff['role_name']) : 'Unknown Role';
            ?>
            <div class="text-gray-900 font-medium"><?= $staffName; ?></div>
            <div class="text-gray-400 text-xs"><?= $staffRole; ?></div>
        </div>
        <!-- Changed from direct link to button that triggers modal -->
        <button id="logoutBtn" class="ml-4 text-gray-500 hover:text-gray-700">
            <i class='bx bx-log-out text-xl'></i>
        </button>
    </div>
</header>

<div id="logoutModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div id="logoutModalContent"
        class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Confirm Logout</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeLogoutModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Are you sure you want to log out of your account?</p>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelLogoutBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <a href="<?= BASE_URL ?>/logout"
                class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none">
                Yes, Logout
            </a>
        </div>
    </div>
</div>

<script>
    // Only initialize once by checking if the function already exists
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

        // Add event listeners when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            const logoutBtn = document.getElementById('logoutBtn');
            const logoutModal = document.getElementById('logoutModal');
            const closeLogoutModal = document.getElementById('closeLogoutModal');
            const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

            // Event listeners
            if (logoutBtn) logoutBtn.addEventListener('click', window.openLogoutModal);
            if (closeLogoutModal) closeLogoutModal.addEventListener('click', window.closeLogoutModal);
            if (cancelLogoutBtn) cancelLogoutBtn.addEventListener('click', window.closeLogoutModal);

            // Close when clicking outside the modal
            if (logoutModal) {
                logoutModal.addEventListener('click', function (e) {
                    if (e.target === logoutModal) {
                        window.closeLogoutModal();
                    }
                });
            }
        });
    }
</script>