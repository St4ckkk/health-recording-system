<!-- Consultation Request -->
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Request Consultation</h2>
            <p class="text-sm text-gray-500">Need to speak with your doctor?</p>
        </div>
    </div>
    <form class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Consultation</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                <option>New symptoms</option>
                <option>Medication side effects</option>
                <option>General check-up</option>
                <option>Other</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Details</label>
            <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" placeholder="Please describe your concern in detail..."></textarea>
        </div>
        <div class="pt-2">
            <button type="submit" class="w-full px-4 py-3 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">
                Submit Request
            </button>
        </div>
    </form>
</div>