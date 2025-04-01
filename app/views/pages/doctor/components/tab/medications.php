<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-medium">Patient Medications</h3>
    <div class="flex space-x-2">
        <?php 
            $text = "Add Medication";
            $icon = "bx-capsule";
            $data_modal = "add-medication-modal";
            include(__DIR__ . '/../common/action-button.php'); 
        ?>
        
        <?php 
            $text = "Create E-Prescription";
            $icon = "bx-file-blank";
            $data_modal = "create-prescription-modal";
            include(__DIR__ . '/../common/action-button.php'); 
        ?>
    </div>
</div>

<div class="mb-6">
    <h3 class="text-lg font-medium mb-4">Active Medications</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prescribed By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">Lisinopril</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">10mg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-03-15</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Sarah Johnson</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-600">Hypertension management</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">Metformin</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">500mg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Twice daily</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-03-15</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Sarah Johnson</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-600">Diabetes management</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">Atorvastatin</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">20mg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily at bedtime</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-03-15</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Sarah Johnson</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-600">Cholesterol management</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-blue-600">Aspirin</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">81mg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Once daily</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-03-15</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Emily Rodriguez</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-600">Cardiovascular protection</td>
                </tr>
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prescribed By</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Amoxicillin</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">500mg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2022-01-10</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2022-01-20</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Michael Chen</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Completed</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>