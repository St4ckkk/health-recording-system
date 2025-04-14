<?php if (!empty($visits)): ?>
    <?php foreach ($visits as $visit): ?>
        <div class="border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-medium capitalize">
                        <?= htmlspecialchars(str_replace('_', ' ', $visit->appointment_type) ?? 'Annual Physical') ?>
                    </h3>
                    <p class="text-sm text-gray-500">
                        Dr. <?= htmlspecialchars($visit->doctor_first_name . ' ' . $visit->doctor_last_name) ?> •
                        <?= date('F d, Y', strtotime($visit->appointment_date)) ?>
                    </p>
                </div>

                <?php
                $appointmentDate = new DateTime($visit->appointment_date);
                $currentDate = new DateTime();
                $interval = $currentDate->diff($appointmentDate);

                if ($interval->y > 0) {
                    $followUpText = $interval->y . ' years';
                } elseif ($interval->m > 0) {
                    $followUpText = $interval->m . ' months';
                } elseif ($interval->d > 7) {
                    $followUpText = floor($interval->d / 7) . ' weeks';
                } else {
                    $followUpText = $interval->d . ' days';
                }
                ?>
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    Follow-up: <?= $followUpText ?>
                </span>

            </div>

            <?php if (!empty($visit->diagnosis)): ?>
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Diagnosis</h4>
                    <p class="text-sm"><?= htmlspecialchars($visit->diagnosis) ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($visit->blood_pressure) || !empty($visit->temperature) || !empty($visit->respiratory_rate) || !empty($visit->heart_rate) || !empty($visit->weight)): ?>
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Vitals</h4>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <?php if (!empty($visit->blood_pressure)): ?>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-500">BP</p>
                                <p class="text-lg font-medium"><?= htmlspecialchars($visit->blood_pressure) ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($visit->heart_rate)): ?>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-500">Heart Rate</p>
                                <p class="text-lg font-medium"><?= htmlspecialchars($visit->heart_rate) ?> md/dL</p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($visit->temperature)): ?>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-500">Temp</p>
                                <p class="text-lg font-medium"><?= htmlspecialchars($visit->temperature) ?>°F</p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($visit->respiratory_rate)): ?>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-500">Resp</p>
                                <p class="text-lg font-medium"><?= htmlspecialchars($visit->respiratory_rate) ?>/min</p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($visit->weight)): ?>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-500">Weight</p>
                                <p class="text-lg font-medium"><?= htmlspecialchars($visit->weight) ?> lbs</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($visit->notes)): ?>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                    <p class="text-sm"><?= nl2br(htmlspecialchars($visit->notes)) ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center text-gray-500 py-8">
        <i class='bx bx-calendar-x text-4xl mb-2'></i>
        <p>No visit records found</p>
    </div>
<?php endif; ?>