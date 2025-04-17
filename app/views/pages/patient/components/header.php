<header class="p-8 flex justify-around gap-20 items-center border-b border-gray-200 bg-white">
    <div class="flex items-center">
        <div class="logo">
            <div class="w-12 h-12 flex justify-center items-center font-bold text-blue-600 border-2 border-blue-600 rounded-lg">
                <i class='bx bx-plus-medical text-2xl'></i>
            </div>
        </div>
        <div class="ml-3">
            <div class="text-lg font-semibold text-gray-900">TeleCure</div>
            <div class="text-xs text-gray-500">Patient Portal</div>
        </div>
    </div>

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



