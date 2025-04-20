<div id="dispenseMedicineModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="dispenseMedicineModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Dispense Medicine</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeDispenseMedicineModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-3">
            <form id="dispenseMedicineForm" class="space-y-3">
                <input type="hidden" id="dispenseMedicineId" name="medicineId">
                <input type="hidden" id="currentStock" name="currentStock">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name</label>
                    <p id="dispenseMedicineName" class="text-gray-900"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Stock</label>
                    <p id="displayCurrentStock" class="text-gray-900"></p>
                </div>

                <div>
                    <label for="dispenseQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity to Dispense</label>
                    <input type="number" id="dispenseQuantity" name="quantity" required min="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 flex justify-end space-x-3">
            <button type="button" id="cancelDispenseMedicineBtn"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Cancel
            </button>
            <button type="submit" form="dispenseMedicineForm"
                class="px-4 py-2 bg-purple-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Dispense
            </button>
        </div>
    </div>
</div>