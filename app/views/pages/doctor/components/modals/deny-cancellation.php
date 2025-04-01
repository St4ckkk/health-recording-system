<!-- Deny Cancellation Modal -->
<div id="denyCancellationModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="denyCancellationModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Deny Cancellation Request</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeDenyCancellationModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Please provide a reason for denying this
                cancellation request:</p>

            <form id="denyCancellationForm" class="space-y-3">
                <input type="hidden" id="denyCancellationAppointmentId" name="appointmentId" value="">

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="denial_reason" value="late_notice" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Late Notice</span>
                                <span class="text-xs text-gray-500">Request received too
                                    late</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="denial_reason" value="policy_violation" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Policy Violation</span>
                                <span class="text-xs text-gray-500">Against clinic policy</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="denial_reason" value="medical_necessity" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Medical Necessity</span>
                                <span class="text-xs text-gray-500">Appointment is
                                    necessary</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="denial_reason" value="other" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Other Reason</span>
                                <span class="text-xs text-gray-500">Please specify below</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" name="send_denial_notification" value="1" class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Send notification to
                                patient</span>
                            <span class="text-xs text-gray-500">Patient will receive an email
                                notification</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="denial_details" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Details:</label>
                    <textarea id="denial_details" name="denial_details" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Please provide additional information about this denial..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelDenialBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmDenialBtn"
                class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-danger-dark focus:outline-none"
                disabled>
                Confirm Denial
            </button>
        </div>
    </div>
</div>