<div id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="deleteModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Delete Medicine</h3>
            <button type="button"
                class="text-gray-400 hover:text-gray-500 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-gray-100"
                id="closeDeleteModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-4">
            <form id="deleteForm">
                <input type="hidden" id="deleteMedicineId">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete <span id="deleteMedicineName" class="font-semibold"></span>?
                    This action cannot be undone.
                </p>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 flex justify-end space-x-3">
            <button type="button" id="cancelDeleteBtn"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Cancel
            </button>
            <button type="submit" form="deleteForm"
                class="px-4 py-2 bg-danger border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i class='bx bx-trash mr-2'></i>
                Delete
            </button>
        </div>
    </div>
</div>