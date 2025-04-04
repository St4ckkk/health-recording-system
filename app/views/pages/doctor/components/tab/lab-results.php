<?php if (!empty($patientLabResults)): ?>
    <?php foreach ($patientLabResults as $labResult): ?>
        <div class="border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-medium"><?= htmlspecialchars($labResult->test_name) ?></h3>
                    <p class="text-sm text-gray-500">
                        Dr. <?= htmlspecialchars($labResult->doctor_first_name . ' ' . $labResult->doctor_last_name) ?> •
                        <?= date('Y-m-d', strtotime($labResult->test_date)) ?>
                    </p>
                </div>
                <span
                    class="<?= $labResult->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?> text-xs px-2 py-1 rounded-full">
                    <?= ucfirst(htmlspecialchars(string: $labResult->status)) ?>
                </span>
            </div>

            <div class="overflow-x-auto mb-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference
                                Range</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flag</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-blue-600">
                                <?= htmlspecialchars($labResult->test_name) ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($labResult->result) ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                <?= htmlspecialchars($labResult->reference_range) ?>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                <?php if ($labResult->flag): ?>
                                    <?php
                                    $flagClass = match ($labResult->flag) {
                                        'High' => 'bg-red-100 text-red-800',
                                        'Low' => 'bg-blue-100 text-blue-800',
                                        'Normal' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    ?>
                                    <span class="<?= $flagClass ?> text-xs px-2 py-1 rounded-full">
                                        <?= htmlspecialchars($labResult->flag) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($labResult->notes)): ?>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Notes</h4>
                    <p class="text-sm"><?= htmlspecialchars($labResult->notes) ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center py-8">
        <p class="text-gray-500">No lab results available.</p>
    </div>
<?php endif; ?>