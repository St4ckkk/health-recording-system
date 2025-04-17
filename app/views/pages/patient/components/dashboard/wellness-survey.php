<!-- Wellness Survey -->
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Weekly Wellness Check</h2>
            <p class="text-sm text-gray-500">Help us monitor your progress</p>
        </div>
        <span class="mt-2 sm:mt-0 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">Due Today</span>
    </div>
    <div class="p-4 bg-amber-50 rounded-lg mb-6">
        <p class="text-amber-800 text-sm">Please complete your weekly wellness survey to help us monitor your progress and provide better care.</p>
    </div>
    <form class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Energy Level (1-5)</label>
            <div class="flex space-x-6">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <label class="flex flex-col items-center">
                        <input type="radio" name="energy_level" value="<?= $i ?>" class="h-4 w-4 text-teal-600">
                        <span class="mt-1 text-sm"><?= $i ?></span>
                        <span class="text-xs text-gray-500 mt-1"><?= $i == 1 ? 'Low' : ($i == 5 ? 'High' : '') ?></span>
                    </label>
                <?php endfor; ?>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sleep Quality</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                    <option>Good</option>
                    <option>Average</option>
                    <option>Poor</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Emotional State</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                    <option>Happy</option>
                    <option>Anxious</option>
                    <option>Sad</option>
                    <option>Angry</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nutrition State</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                <option>Normal</option>
                <option>Reduced</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Any Life Changes?</label>
            <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="Please describe any significant life changes..."></textarea>
        </div>
        <div class="pt-2">
            <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                Submit Weekly Survey
            </button>
        </div>
    </form>
</div>