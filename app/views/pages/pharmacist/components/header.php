<header class="p-5 flex justify-end items-center border-b border-gray-200 bg-white">
    <div class="flex items-center gap-2">
        <i class='bx bx-bell text-gray-900' style="font-size: 1.4rem;"></i>
        <div class="avatar w-12 h-12">
            <?php if (isset($_SESSION['doctor']) && !empty($_SESSION['doctor']['profile'])): ?>
                <img src="<?= BASE_URL ?>/<?= $_SESSION['doctor']['profile'] ?>" alt="Profile"
                    class="w-full h-full rounded-full object-cover">
            <?php else: ?>
                <i class="bx bx-user text-3xl"></i>
            <?php endif; ?>
        </div>
        <div>
            <?php
            $doctor = $_SESSION['doctor'] ?? null;
            $doctorName = $doctor ? $doctor['first_name'] . ' ' . $doctor['last_name'] : 'Unknown User';
            $specialization = $doctor ? $doctor['specialization'] : 'Doctor';
            ?>
            <div class="text-gray-900 font-medium"><?= $doctorName; ?></div>
            <div class="text-gray-400 text-xs capitalize"><?= $specialization; ?></div>
        </div>
     
    </div>
</header>



