<div id="approveRescheduleModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="approveRescheduleModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Approve Reschedule Request</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeApproveRescheduleModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Review and approve the requested reschedule:</p>

            <form id="approveRescheduleForm" class="space-y-3">
                <input type="hidden" id="approveRescheduleAppointmentId" name="appointmentId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="requested_date" class="block text-sm font-medium text-gray-700 mb-1">Requested
                            Date:</label>
                        <div class="relative">
                            <input type="text" id="requested_date" name="requested_date" readonly
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                    </div>
                    <div>
                        <label for="requested_time" class="block text-sm font-medium text-gray-700 mb-1">Requested
                            Time:</label>
                        <div class="relative">
                            <input type="text" id="requested_time" name="requested_time" readonly
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="new_date" class="block text-sm font-medium text-gray-700 mb-1">New Date:</label>
                        <div class="relative">
                            <input type="text" id="new_date" name="new_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="bx bx-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="new_time" class="block text-sm font-medium text-gray-700 mb-1">New Time:</label>
                        <div class="relative">
                            <input type="text" id="new_time" name="new_time"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="bx bx-time text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="use_requested_datetime" name="use_requested_datetime" value="1"
                            class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Use requested date and time</span>
                            <span class="text-xs text-gray-500">Uncheck to specify a different date/time</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" name="send_reschedule_confirmation" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Send confirmation to patient</span>
                            <span class="text-xs text-gray-500">Patient will receive an email notification</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="reschedule_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="reschedule_notes" name="reschedule_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes about this reschedule..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelApproveRescheduleBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmApproveRescheduleBtn"
                class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                Approve Reschedule
            </button>
        </div>
    </div>
</div>