<!-- Start Appointment Modal -->
<div id="startAppointmentModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="startAppointmentModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Start Appointment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeStartAppointmentModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <div class="px-6 py-4">
            <p class="mb-4 text-sm text-gray-500">Confirm that the patient is ready to see the provider:</p>

            <form id="startAppointmentForm" class="space-y-3">
                <input type="hidden" id="startAppointmentId" name="appointmentId" value="">

                <div class="rounded-md border border-gray-200 p-3 bg-gray-50">
                    <div class="flex items-center mb-2">
                        <i class="bx bx-user-check text-primary mr-2"></i>
                        <span class="text-sm font-medium">Patient Status</span>
                    </div>
                    <p class="text-sm text-gray-500">Patient has been checked in and is ready to see the provider.</p>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="vitals_recorded" name="vitals_recorded" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Vitals Recorded</span>
                            <span class="text-xs text-gray-500">Patient's vital signs have been recorded</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="room_prepared" name="room_prepared" value="1" class="mt-1 mr-2"
                            checked>
                        <div>
                            <span class="block text-sm font-medium">Room Prepared</span>
                            <span class="text-xs text-gray-500">Examination room is ready for the patient</span>
                        </div>
                    </label>
                </div>

                <div class="rounded-md border border-gray-200 p-3 hover:bg-gray-50">
                    <label class="flex cursor-pointer items-start">
                        <input type="checkbox" id="provider_notified" name="provider_notified" value="1"
                            class="mt-1 mr-2" checked>
                        <div>
                            <span class="block text-sm font-medium">Provider Notified</span>
                            <span class="text-xs text-gray-500">Healthcare provider has been notified</span>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="room_number" class="block text-sm font-medium text-gray-700 mb-1">Room Number:</label>
                    <select id="room_number" name="room_number"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">Select a room</option>
                        <option value="1">Room 1</option>
                        <option value="2">Room 2</option>
                        <option value="3">Room 3</option>
                        <option value="4">Room 4</option>
                        <option value="5">Room 5</option>
                    </select>
                </div>

                <div>
                    <label for="start_appointment_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional
                        Notes:</label>
                    <textarea id="start_appointment_notes" name="start_appointment_notes" rows="2"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Add any notes for the provider..."></textarea>
                </div>
            </form>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
            <button type="button" id="cancelStartAppointmentBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                Cancel
            </button>
            <button type="button" id="confirmStartAppointmentBtn"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                Start Appointment
            </button>
        </div>
    </div>
</div>