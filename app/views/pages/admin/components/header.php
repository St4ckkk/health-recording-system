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
    </div>
</header>