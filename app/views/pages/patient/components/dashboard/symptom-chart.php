<!-- Symptom Tracker Chart -->
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Symptom Trends</h2>
            <p class="text-sm text-gray-500">Track your symptoms over time</p>
        </div>
        <div class="flex space-x-2 mt-2 sm:mt-0">
            <button class="px-3 py-1 text-xs bg-teal-100 text-teal-600 rounded-full font-medium">Week</button>
            <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">Month</button>
            <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">Year</button>
        </div>
    </div>
    <div class="h-72">
        <canvas id="symptomChart"></canvas>
    </div>
    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-xs">
        <div class="p-2 bg-teal-50 rounded-lg">
            <p class="text-gray-500">Cough</p>
            <p class="font-bold text-teal-600">Mild</p>
        </div>
        <div class="p-2 bg-indigo-50 rounded-lg">
            <p class="text-gray-500">Fatigue</p>
            <p class="font-bold text-indigo-600">Level 2</p>
        </div>
        <div class="p-2 bg-purple-50 rounded-lg">
            <p class="text-gray-500">Chest Pain</p>
            <p class="font-bold text-purple-600">None</p>
        </div>
        <div class="p-2 bg-amber-50 rounded-lg">
            <p class="text-gray-500">Fever</p>
            <p class="font-bold text-amber-600">No</p>
        </div>
    </div>
</div>