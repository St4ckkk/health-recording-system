<!-- Medication Log -->
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Medication Log</h2>
            <p class="text-sm text-gray-500">Track your medication adherence</p>
        </div>
        <button class="mt-2 sm:mt-0 px-4 py-2 bg-teal-500 text-white rounded-lg text-sm flex items-center hover:bg-teal-600 transition-colors">
            <i class="bx bx-plus mr-2"></i> Add Entry
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-50">
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm font-medium">May 15, 2023</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Taken</span></td>
                    <td class="py-3 px-4 text-sm">08:30 AM</td>
                    <td class="py-3 px-4 text-sm">Taken with breakfast</td>
                    <td class="py-3 px-4 text-sm">
                        <button class="text-gray-500 hover:text-teal-500 transition-colors">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm font-medium">May 14, 2023</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Taken</span></td>
                    <td class="py-3 px-4 text-sm">08:15 AM</td>
                    <td class="py-3 px-4 text-sm">-</td>
                    <td class="py-3 px-4 text-sm">
                        <button class="text-gray-500 hover:text-teal-500 transition-colors">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm font-medium">May 13, 2023</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Missed</span></td>
                    <td class="py-3 px-4 text-sm">-</td>
                    <td class="py-3 px-4 text-sm">Was traveling</td>
                    <td class="py-3 px-4 text-sm">
                        <button class="text-gray-500 hover:text-teal-500 transition-colors">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="#" class="text-teal-500 text-sm font-medium hover:text-teal-600 transition-colors flex items-center justify-end">
            View all entries <i class="bx bx-right-arrow-alt ml-1"></i>
        </a>
    </div>
</div>