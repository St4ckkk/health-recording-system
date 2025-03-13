<div id="appointmentDetails" class="card bg-white shadow-sm rounded-lg p-6 flex-1 fade-in">
    <div id="david-details" class="patient-details">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-md font-medium text-gray-900">David Wilson</h3>
                <p class="text-sm text-gray-400">Appointment Details</p>
            </div>
            <div class="flex gap-2">
                <span class="appointment-type checkup px-2 py-2">Checkup</span>
                <span
                    class="appointment-type border border-success px-1 py-1 rounded text-sm text-success status">Completed</span>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-section">
                <p class="detail-label font-medium">Appointment ID</p>
                <p class="detail-value">A1005</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Patient ID</p>
                <p class="detail-value">P12349</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Date</p>
                <p class="detail-value">Friday, May 19, 2023</p>
            </div>
            <div class="detail-section">
                <p class="detail-label">Time</p>
                <p class="detail-value">03:30 PM</p>
            </div>
        </div>

        <hr class="border-gray-200 my-6 mt-5 mb-4 space">

        <div class="">
            <p class="text-sm mb-2 font-medium">Appointment Information</p>
            <div class="ml-1">
                <table class="w-full border-collapse">
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Reason
                        </td>
                        <td class="text-sm text-gray-900 py-2">Annual physical examination</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Location
                        </td>
                        <td class="text-sm text-gray-900 py-2">Main Clinic, Room 101</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Notes</td>
                        <td class="text-sm text-gray-900 py-2">Patient has history of
                            hypertension</td>
                    </tr>
                    <tr class="">
                        <td class="text-sm font-medium text-gray-900 py-2 pl-5 w-1/3">Insurance
                        </td>
                        <td class="text-sm text-gray-900 py-2">Blue Cross #BC987654</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="border-gray-200 my-4">

        <div class="mb-6">
            <p class="text-sm mb-2 font-medium mb-2">Patient Contact Information</p>

            <div class="space-y-2">
                <p class="contact-info">
                    <i class="bx bx-phone text-gray-500 mr-2"></i>
                    (555) 567-8901
                </p>
                <p class="contact-info">
                    <i class="bx bx-envelope text-gray-500 mr-2"></i>
                    david.wilson@example.com
                </p>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <div class="flex-1">
                <button class="action-button border border-danger text-danger">
                    <i class="bx bx-x-circle text-danger mr-2 text-md"></i>
                    Cancel Appointment
                </button>
            </div>
            <button class="action-button secondary">
                <i class="bx bx-check-circle mr-2 text-md"></i>
                Confirm
            </button>
            <button class="action-button secondary">
                <i class="bx bx-calendar mr-2 text-md"></i>
                Reschedule
            </button>
            <button class="action-button bg-gray-900">
                <i class="bx bx-file mr-2 text-white text-md"></i>
                <span class="text-white">
                    Patient Record
                </span>
            </button>
        </div>
    </div>
</div>