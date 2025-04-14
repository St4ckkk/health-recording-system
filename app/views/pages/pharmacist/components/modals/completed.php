<!-- Completed Appointment Modal -->
<div id="completedModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="completedModalContent">
        <!-- Fixed Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Complete Appointment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeCompletedModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-3 max-h-[60vh] overflow-y-auto">
            <form id="completedForm" class="space-y-3">
                <input type="hidden" id="completedAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-green-50">
                    <div class="flex items-start">
                        <i class="bx bx-check-circle text-green-500 text-lg mr-2"></i>
                        <p class="text-xs text-green-700">
                            Mark this appointment as completed. This action cannot be undone.
                        </p>
                    </div>
                </div>

                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center">
                        <input id="scheduleFollowUp" type="checkbox"
                            class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <label for="scheduleFollowUp" class="ml-2 block text-sm font-medium text-gray-900">
                            Schedule a follow-up appointment
                        </label>
                    </div>
                </div>


                <div id="followUpDetails" class="space-y-3 hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="followUpDate" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="text" id="followUpDate" name="followUpDate"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                                placeholder="Select date">
                        </div>
                        <div>
                            <label for="followUpTime" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <input type="text" id="followUpTime" name="followUpTime"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                                placeholder="Select time">
                        </div>
                    </div>

                    <div>
                        <label for="followUpType" class="block text-sm font-medium text-gray-700 mb-1">Appointment
                            Type</label>
                        <select id="followUpType" name="followUpType"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="follow_up">Follow-up</option>
                            <option value="checkup">Checkup</option>
                            <option value="consultation">Consultation</option>
                            <option value="treatment">Treatment</option>
                            <option value="specialist">Specialist</option>
                            <option value="vaccination">Vaccination</option>
                            <option value="laboratory_test">Laboratory Test</option>
                            <option value="medical_clearance">Medical Clearance</option>
                        </select>
                    </div>

                    <div>
                        <label for="followUpReason" class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                        <textarea id="followUpReason" name="followUpReason" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                            placeholder="Reason for follow-up appointment">Follow-up appointment</textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Fixed Footer with Actions -->
        <div class="border-t border-gray-200 px-6 py-3 flex justify-end space-x-3">
            <button type="button" id="cancelCompletedBtn"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Cancel
            </button>
            <button type="button" id="confirmCompletedBtn"
                class="px-4 py-2 bg-primary border border-transparent rounded-md text-sm font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Complete Appointment
            </button>
        </div>
    </div>
</div>