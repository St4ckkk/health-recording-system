<!-- Cancellation Modal -->
<div id="cancellationModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="modalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Cancel Appointment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Please select a reason for cancellation:</p>

            <form id="cancellationForm" class="space-y-3">
                <input type="hidden" id="appointmentId" name="appointmentId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="cancellation_reason" value="schedule_conflict" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Schedule Conflict</span>
                                <span class="text-xs text-gray-500">Patient has another
                                    appointment</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="cancellation_reason" value="patient_request" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Patient Request</span>
                                <span class="text-xs text-gray-500">Patient requested to
                                    cancel</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="cancellation_reason" value="doctor_unavailable" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Doctor
                                    Unavailable</span>
                                <span class="text-xs text-gray-500">Doctor not available</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="cancellation_reason" value="medical_reason" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Medical Reason</span>
                                <span class="text-xs text-gray-500">Medical circumstances</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="radio" name="cancellation_reason" value="other" class="mt-1 mr-2">
                        <div>
                            <span class="block text-sm font-medium">Other Reason</span>
                            <span class="text-xs text-gray-500">Please specify in details</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="cancellation_details" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Details:</label>
                    <textarea id="cancellation_details" name="cancellation_details" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Please provide any additional information..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelModalBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmCancelBtn"
                class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none"
                disabled>
                Confirm Cancellation
            </button>
        </div>
    </div>
</div>