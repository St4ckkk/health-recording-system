<div id="editMedicineModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="editMedicineModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Edit Medicine</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeEditMedicineModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-3 max-h-[60vh] overflow-y-auto">
            <form id="editMedicineForm" class="space-y-3">
                <input type="hidden" id="editMedicineId" name="medicineId">
                <div>
                    <label for="editMedicineName" class="block text-sm font-medium text-gray-700 mb-1">Medicine Name</label>
                    <input type="text" id="editMedicineName" name="medicineName" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="editCategory" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <input type="text" id="editCategory" name="category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter medicine category">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="editForm" class="block text-sm font-medium text-gray-700 mb-1">Form</label>
                        <select id="editForm" name="form" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select Form</option>
                            <option value="Table">Tablet</option>
                            <option value="Capsule">Capsule</option>
                            <option value="Syrup">Syrup</option>
                            <option value="Injection">Injection</option>
                        </select>
                    </div>
                    <div>
                        <label for="editDosage" class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                        <input type="text" id="editDosage" name="dosage" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="editStockLevel" class="block text-sm font-medium text-gray-700 mb-1">Stock Level</label>
                        <input type="number" id="editStockLevel" name="stockLevel" min="0" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label for="editExpiryDate" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                        <input type="date" id="editExpiryDate" name="expiryDate" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="editManufacturer" class="block text-sm font-medium text-gray-700 mb-1">Manufacturer</label>
                        <input type="text" id="editManufacturer" name="manufacturer" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                            placeholder="e.g., Pfizer, Johnson & Johnson">
                    </div>
                    <div>
                        <label for="editSupplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                        <input type="text" id="editSupplier" name="supplier" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Enter supplier name">
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 flex justify-end space-x-3">
            <button type="button" id="cancelEditMedicineBtn"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Cancel
            </button>
            <button type="submit" form="editMedicineForm"
                class="px-4 py-2 bg-purple-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Save Changes
            </button>
        </div>
    </div>
</div>