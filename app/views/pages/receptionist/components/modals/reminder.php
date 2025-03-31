<!-- Appointment Reminder Modal -->
<div id="reminderModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="reminderModalContent">
        <!-- Fixed Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Appointment Reminder</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeReminderModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Scrollable Content Area -->
        <div class="px-6 py-3 max-h-[60vh] overflow-y-auto">
            <form id="reminderForm" class="space-y-3">
                <input type="hidden" id="reminderAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-blue-50">
                    <div class="flex items-start">
                        <i class="bx bx-bell text-blue-500 text-lg mr-2"></i>
                        <p class="text-xs text-blue-700">
                            Send an email reminder about the upcoming appointment
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="rounded-md border border-gray-200 p-2 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reminder_type" value="standard" class="mt-1 mr-2" checked>
                            <div>
                                <span class="block text-sm font-medium">Standard</span>
                                <span class="text-xs text-gray-500">Basic details</span>
                            </div>
                        </label>
                    </div>

                    <div class="rounded-md border border-gray-200 p-2 hover:bg-gray-50">
                        <label class="flex cursor-pointer items-start">
                            <input type="radio" name="reminder_type" value="detailed" class="mt-1 mr-2">
                            <div>
                                <span class="block text-sm font-medium">Detailed</span>
                                <span class="text-xs text-gray-500">With instructions</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="reminder_message" class="block text-sm font-medium text-gray-700 mb-1">Message:</label>
                    <textarea id="reminder_message" name="reminder_message" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any additional information..."></textarea>
                </div>

                <div class="rounded-md border border-gray-200 p-2 bg-gray-50">
                    <div class="flex items-center">
                        <input id="send_email" name="send_email" type="checkbox" checked
                            class="h-4 w-4 text-primary border-gray-300 rounded">
                        <label for="send_email" class="ml-2 text-sm text-gray-700">Send via email</label>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Footer -->
        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelReminderBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="sendReminderBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Send
            </button>
        </div>
    </div>
</div>