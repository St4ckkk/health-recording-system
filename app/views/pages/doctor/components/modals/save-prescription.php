<!-- Save Prescription Modal -->
<div id="savePrescriptionModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0" id="savePrescriptionModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Save Prescription</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeSavePrescriptionModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                <div class="flex items-start">
                    <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                    <p class="text-sm text-blue-700">
                        Please confirm that you want to save this prescription. This action cannot be undone.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-file text-primary mr-2"></i>
                        <span class="text-sm font-medium">Prescription Details</span>
                    </div>
                    <p class="text-sm text-gray-500">All medication details and instructions will be saved to the patient's record.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelSavePrescriptionBtn" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmSavePrescriptionBtn" class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Save Prescription
            </button>
        </div>
    </div>
</div>

