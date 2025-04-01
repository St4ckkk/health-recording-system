
<div id="checkInModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="checkInModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Check-In Patient</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeCheckInModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Confirm patient arrival and check-in details:</p>

            <form id="checkInForm" class="space-y-3">
                <input type="hidden" id="checkInAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-time text-primary mr-2"></i>
                        <span class="text-sm font-medium">Arrival Time</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-2">Current time will be recorded as the check-in time.</p>
                    <div class="text-sm font-medium" id="currentCheckInTime"></div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="verify_insurance" name="verify_insurance" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Insurance Verified</span>
                            <span class="text-xs text-gray-500">Confirm patient's insurance information is valid</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="verify_id" name="verify_id" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">ID Verified</span>
                            <span class="text-xs text-gray-500">Confirm patient's identity has been verified</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="forms_completed" name="forms_completed" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Forms Completed</span>
                            <span class="text-xs text-gray-500">Patient has completed all required paperwork</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="notify_provider" name="notify_provider" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Notify Provider</span>
                            <span class="text-xs text-gray-500">Send notification to the healthcare provider</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="check_in_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="check_in_notes" name="check_in_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes about this check-in..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelCheckInBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmCheckInBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Complete Check-In
            </button>
        </div>
    </div>
</div>