<!-- Symptom Log Form -->
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Log Your Symptoms</h2>
            <p class="text-sm text-gray-500">Record how you're feeling today</p>
        </div>
        <div class="mt-2 sm:mt-0">
            <input type="date" class="date-picker px-3 py-2 border border-gray-300 rounded-lg text-sm" value="<?= date('Y-m-d') ?>">
        </div>
    </div>
    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cough</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                <option>None</option>
                <option>Mild</option>
                <option>Severe</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fever</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="fever" value="0" class="h-4 w-4 text-teal-600">
                    <span class="ml-2 text-sm">No</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="fever" value="1" class="h-4 w-4 text-teal-600">
                    <span class="ml-2 text-sm">Yes</span>
                </label>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Temperature (°F)</label>
            <input type="number" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="98.6">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Chest Pain</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="chest_pain" value="0" class="h-4 w-4 text-teal-600">
                    <span class="ml-2 text-sm">No</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="chest_pain" value="1" class="h-4 w-4 text-teal-600">
                    <span class="ml-2 text-sm">Yes</span>
                </label>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fatigue Level (1-5)</label>
            <div class="flex space-x-4">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <label class="flex flex-col items-center">
                        <input type="radio" name="fatigue_level" value="<?= $i ?>" class="h-4 w-4 text-teal-600">
                        <span class="mt-1 text-sm"><?= $i ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Appetite Loss</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                <option>Normal</option>
                <option>Slight</option>
                <option>Severe</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                Save Symptom Log
            </button>
        </div>
    </form>
</div>