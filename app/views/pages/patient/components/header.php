<header class="p-8 flex justify-around gap-20 items-center border-b border-gray-200 bg-white">
    <div class="flex items-center">
        <div class="logo">
            <img src="<?= BASE_URL ?>/images/icons/patient.png" alt="TB Health Recording System" class="object-contain"
                style="height: 50px; width: 50px">
        </div>
        <div class="ml-3">
            <div class="text-lg font-semibold text-gray-900">HRS</div>
            <div class="text-xs text-gray-500">Patient Portal</div>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <i class='bx bx-bell text-gray-900' style="font-size: 1.4rem;"></i>
        <div class="avatar w-12 h-12">
            <?php if (isset($_SESSION['patient']) && !empty($_SESSION['patient']['profile'])): ?>
                <img src="<?= BASE_URL ?>/<?= $_SESSION['patient']['profile'] ?>" alt="Profile"
                    class="w-full h-full rounded-full object-cover">
            <?php else: ?>
                <i class="bx bx-user text-3xl"></i>
            <?php endif; ?>
        </div>
        <div>
            <?php
            $patient = $_SESSION['patient'] ?? null;
            $patientName = $patient ? ($patient['first_name'] . ' ' . $patient['last_name']) : 'Patient';
            ?>
            <div class="text-gray-900 font-medium"><?= htmlspecialchars($patientName) ?></div>
            <div class="text-gray-400 text-xs capitalize">Patient</div>
        </div>
    </div>
</header>