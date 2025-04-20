<div id="toast-container" class="fixed top-4 right-4 z-50"></div>

<div id="confirmationModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="confirmModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Confirm Appointment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeConfirmModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Are you sure you want to confirm this
                appointment?</p>

            <form id="confirmationForm" class="space-y-3">
                <input type="hidden" id="confirmAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" name="send_confirmation" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Send confirmation to
                                patient</span>
                            <span class="text-xs text-gray-500">Patient will receive an email
                                notification</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="confirmation_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="confirmation_notes" name="confirmation_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any special instructions or notes..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelConfirmBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmAppointmentBtn"
                class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                Confirm Appointment
            </button>
        </div>
    </div>
</div>