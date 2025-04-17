<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immunization
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Administrator
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lot Number
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Due</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($immunizationHistory)): ?>
                <?php foreach ($immunizationHistory as $immunization): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($immunization->vaccine_name) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= date('Y-m-d', strtotime($immunization->immunization_date)) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($immunization->administrator) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($immunization->lot_number) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= $immunization->next_due ? date('Y-m', strtotime($immunization->next_due)) : 'N/A' ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex justify-between items-center">
                                <a href="<?= BASE_URL ?>/doctor/immunization/view?id=<?= $immunization->id ?>"
                                    class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                    View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                        No immunization records found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>