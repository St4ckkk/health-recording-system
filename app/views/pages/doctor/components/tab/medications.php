<div class="mb-6">
    <div class="text-lg font-medium mb-4">Prescriptions</div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Medications</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Instructions</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Follow Up
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($prescriptions)): ?>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= date('M d, Y', strtotime($prescription->created_at)) ?>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-1">
                                    <?php foreach ($prescription->medications as $med): ?>
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <?= htmlspecialchars($med->medicine_name) ?>
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500 pl-2">
                                                <div>Dosage: <?= htmlspecialchars($med->dosage) ?></div>
                                                <div>Duration: <?= htmlspecialchars($med->duration) ?></div>
                                                <?php if (!empty($med->special_instructions)): ?>
                                                    <div>Note: <?= htmlspecialchars($med->special_instructions) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-gray-900 line-clamp-2">
                                    <?= htmlspecialchars($prescription->advice) ?>
                                </p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full <?= strtotime($prescription->follow_up_date) < time() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?>">
                                    <?= date('M d, Y', strtotime($prescription->follow_up_date)) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex justify-between items-center">
                                <a href="<?= BASE_URL ?>/doctor/prescription/view?id=<?= $prescription->id ?>"
                                    class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                    View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No prescriptions available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div>
    <h3 class="text-lg font-medium mb-4">Prescription History</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Medications</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Instructions</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($prescriptionHistory)): ?>
                    <?php foreach ($prescriptionHistory as $prescription): ?>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= date('M d, Y', strtotime($prescription->created_at)) ?>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-1">
                                    <?php foreach ($prescription->medications as $med): ?>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <?= htmlspecialchars($med->name) ?>
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                <?= htmlspecialchars($med->dosage) ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-gray-900 line-clamp-2">
                                    <?= htmlspecialchars($prescription->advice) ?>
                                </p>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                    <?= ucfirst(htmlspecialchars($prescription->status)) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="<?= BASE_URL ?>/doctor/preview-prescription?id=<?= $prescription->id ?>"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        <i class="bx bx-show"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">No prescription history
                            available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>