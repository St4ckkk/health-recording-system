<!-- Monitoring Request Modal -->
<div id="monitoringRequestModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0" id="monitoringRequestModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Send Monitoring Request</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeMonitoringRequestModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                <div class="flex items-start">
                    <i class="bx bx-heart-circle text-blue-500 text-lg mr-2"></i>
                    <p class="text-sm text-blue-700">
                        A monitoring link will be sent to the patient's email address for daily health logging.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="include_symptoms" name="include_symptoms" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Include Symptom Tracking</span>
                            <span class="text-xs text-gray-500">Allow patient to log symptoms and vital signs</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="include_wellness" name="include_wellness" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Include Wellness Survey</span>
                            <span class="text-xs text-gray-500">Track patient's overall well-being</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="monitoring_duration" class="block text-sm font-medium text-gray-700 mb-1">Monitoring Duration:</label>
                    <select id="monitoring_duration" name="monitoring_duration" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="7">7 days</option>
                        <option value="14">14 days</option>
                        <option value="30">30 days</option>
                        <option value="60">60 days</option>
                    </select>
                </div>

                <div>
                    <label for="monitoring_message" class="block text-sm font-medium text-gray-700 mb-1">Instructions for Patient:</label>
                    <textarea id="monitoring_message" name="monitoring_message" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" placeholder="Add instructions for the patient..."></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelMonitoringRequestBtn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmMonitoringRequestBtn" class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Send Request
            </button>
        </div>
    </div>
</div>