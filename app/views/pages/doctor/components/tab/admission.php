<div class="overflow-x-auto">
<div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Admission History</h3>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ward</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bed No.</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discharge Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($admissionHistory)): ?>
                <?php foreach ($admissionHistory as $admission): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->diagnosis_name ?? 'No diagnosis') ?>
                            <?php if (!empty($admission->diagnosis_notes)): ?>
                                <span class="block text-xs text-gray-400"><?= htmlspecialchars($admission->diagnosis_notes) ?></span>
                            <?php endif; ?>
                        </td>
                       
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->ward) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->bed_no) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= date('Y-m-d', strtotime($admission->admission_date)) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= $admission->discharge_date ? date('Y-m-d', strtotime($admission->discharge_date)) : 'Not discharged' ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                <?= $admission->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($admission->status === 'discharged' ? 'bg-gray-100 text-gray-800' : 
                                   'bg-yellow-100 text-yellow-800') ?>">
                                <?= htmlspecialchars($admission->status) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex justify-between items-center">
                                <a href="<?= BASE_URL ?>/doctor/admission/view?id=<?= $admission->id ?>"
                                    class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                    View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="px-4 py-3 text-center text-sm text-gray-500">
                        No admission records found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>