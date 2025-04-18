<div class="space-y-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Treatment Records</h3>
        <button id="openTreatmentModalBtn"
            class="flex items-center gap-1 px-3 py-1.5 text-blue-600 rounded-md text-sm hover:bg-blue-50 transition-colors">
            <i class='bx bx-plus'></i>
            <span>New Treatment</span>
        </button>
    </div>

    <?php if (!empty($treatmentRecords)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Summary
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($treatmentRecords as $record): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('M d, Y', strtotime($record->start_date)) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($record->treatment_type) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Dr. <?= htmlspecialchars($record->doctor_first_name . ' ' . $record->doctor_last_name) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?= htmlspecialchars($record->regimen_summary) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusClass = match (strtolower($record->status)) {
                                    'completed' => 'bg-green-100 text-green-800',
                                    'active' => 'bg-blue-100 text-blue-800',
                                    'discontinued' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                    <?= ucfirst(htmlspecialchars($record->status)) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex justify-between items-center">
                                    <a href="<?= BASE_URL ?>/doctor/treatment-records/view?id=<?= $record->id ?>"
                                        class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                        View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-4">
            <p class="text-gray-500">No treatment records found.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Add Treatment Modal -->
<div id="addTreatmentModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="addTreatmentModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Add New Treatment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeTreatmentModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <form id="treatmentForm">
            <div class="px-6 py-4">
                <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                    <div class="flex items-start">
                        <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                        <p class="text-sm text-blue-700">
                            Please fill in the treatment details for this patient.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

                    <div class="mb-3">
                        <label for="treatment_type" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                            Type</label>
                        <select id="treatment_type" name="treatment_type"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                            <option value="">Select Treatment Type</option>
                            <option value="Intensive Phase">Intensive Phase</option>
                            <option value="Continuation Phase">Continuation Phase</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="regimen_summary" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                            Summary</label>
                        <textarea id="regimen_summary" name="regimen_summary" rows="3"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start
                                Date</label>
                            <input type="date" id="start_date" name="start_date" value="<?= date('Y-m-d') ?>"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date (if
                                known)</label>
                            <input type="date" id="end_date" name="end_date"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="outcome" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                            Outcome</label>
                        <select id="outcome" name="outcome"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="">Select Outcome</option>
                            <option value="ongoing">OnGoing</option>
                            <option value="cured">Cured</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="lost to follow-up">Lost to Follow-Up</option>
                            <option value="died">Died</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="adherence_status" class="block text-sm font-medium text-gray-700 mb-1">Adherence
                            Status</label>
                        <select id="adherence_status" name="adherence_status"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="">Select Adherence Status</option>
                            <option value="good">Good</option>
                            <option value="irregular">Irregular</option>
                            <option value="poor">Poor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="follow_up_notes" class="block text-sm font-medium text-gray-700 mb-1">Follow-up
                            Notes</label>
                        <textarea id="follow_up_notes" name="follow_up_notes" rows="2"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="discontinued">Discontinued</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                <button type="button" id="cancelTreatmentBtn"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    Cancel
                </button>
                <button type="submit" id="saveTreatmentBtn"
                    class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                    Save Treatment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal elements
        const modal = document.getElementById('addTreatmentModal');
        const modalContent = document.getElementById('addTreatmentModalContent');
        const openModalBtn = document.getElementById('openTreatmentModalBtn');
        const closeModalBtn = document.getElementById('closeTreatmentModal');
        const cancelBtn = document.getElementById('cancelTreatmentBtn');
        const treatmentForm = document.getElementById('treatmentForm');

        // Function to open modal
        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Function to close modal
        function closeModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Event listeners
        if (openModalBtn) {
            openModalBtn.addEventListener('click', openModal);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Form submission
        if (treatmentForm) {
            treatmentForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Get form data
                const formData = new FormData(treatmentForm);

                // Show loading state
                const saveBtn = document.getElementById('saveTreatmentBtn');
                const originalBtnText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
                saveBtn.disabled = true;

                // Send data to server
                fetch('<?= BASE_URL ?>/doctor/saveTreatment', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast
                            showToast('success', 'Treatment Added', 'Patient treatment has been recorded successfully!');

                            // Close modal
                            closeModal();

                            // Reload page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            throw new Error(data.message || 'Failed to save treatment');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving treatment:', error);
                        showToast('error', 'Error', error.message || 'An unexpected error occurred. Please try again.');

                        // Reset button
                        saveBtn.innerHTML = originalBtnText;
                        saveBtn.disabled = false;
                    });
            });
        }

        // Toast function
        function showToast(type, title, message, containerId = 'toast-container') {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById(containerId);
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = containerId;
                toastContainer.className = 'fixed top-4 right-4 z-50';
                document.body.appendChild(toastContainer);
            }

            // Create toast element
            const toast = document.createElement('div');
            toast.className = `flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow`;

            // Set toast content based on type
            if (type === 'success') {
                toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <i class="bx bx-check text-xl"></i>
                </div>
                <div class="ml-3 text-sm font-normal">
                    <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                    <div class="mb-2 text-sm">${message}</div>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" aria-label="Close">
                    <i class="bx bx-x text-lg"></i>
                </button>
            `;
            } else {
                toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <i class="bx bx-x text-xl"></i>
                </div>
                <div class="ml-3 text-sm font-normal">
                    <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                    <div class="mb-2 text-sm">${message}</div>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" aria-label="Close">
                    <i class="bx bx-x text-lg"></i>
                </button>
            `;
            }

            // Add toast to container
            toastContainer.appendChild(toast);

            // Add click event to close button
            toast.querySelector('button').addEventListener('click', () => {
                toast.remove();
            });

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.remove();
                }
            }, 5000);
        }
    });
</script>