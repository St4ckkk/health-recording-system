<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Active Medications</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                        Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Prescribed By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($activeMedications)): ?>
                    <?php foreach ($activeMedications as $medication): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">
                                <?= htmlspecialchars($medication->medication_name) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($medication->dosage) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($medication->frequency) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= date('Y-m-d', strtotime($medication->start_date)) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                Dr. <?= htmlspecialchars($medication->doctor_name) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-600">
                                <?= htmlspecialchars($medication->purpose) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">No active medications</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div>
    <h3 class="text-lg font-medium mb-4">Medication History</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                        Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Prescribed By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($medicationHistory)): ?>
                    <?php foreach ($medicationHistory as $medication): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($medication->medication_name) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($medication->dosage) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= date('Y-m-d', strtotime($medication->start_date)) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                Dr. <?= htmlspecialchars($medication->doctor_name) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($medication->purpose) ?>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <?php
                                $statusClass = match ($medication->status) {
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-yellow-100 text-yellow-800',
                                    'discontinued' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <span class="<?= $statusClass ?> text-xs px-2 py-1 rounded-full">
                                    <?= ucfirst(htmlspecialchars($medication->status)) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">No medication history available
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>