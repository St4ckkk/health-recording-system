<div class="overflow-x-auto">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Immunization History</h3>
        <button id="openImmunizationModalBtn"
            class="flex items-center gap-1 px-3 py-1.5 text-blue-600 rounded-md text-sm hover:bg-blue-50 transition-colors">
            <i class='bx bx-plus'></i>
            <span>New Immunization</span>
        </button>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immunization
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Administrator
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lot Number
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Due</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($immunizationHistory)): ?>
                <?php foreach ($immunizationHistory as $immunization): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($immunization->vaccine_name) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= date('Y-m-d', strtotime($immunization->immunization_date)) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($immunization->administrator) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($immunization->lot_number) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= $immunization->next_due ? date('Y-m', strtotime($immunization->next_due)) : 'N/A' ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex justify-between items-center">
                                <a href="<?= BASE_URL ?>/doctor/immunization/view?id=<?= $immunization->id ?>"
                                    class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                    View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-sm text-gray-500">
                        No immunization records found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Immunization Modal -->
<div id="addImmunizationModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="addImmunizationModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Add New Immunization</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                id="closeImmunizationModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <form id="immunizationForm">
            <div class="px-6 py-4">
                <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                    <div class="flex items-start">
                        <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                        <p class="text-sm text-blue-700">
                            Please fill in the immunization details for this patient.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="hidden" name="patient_id" value="<?= $patient->id ?>">
                    <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?>">

                    <div class="mb-3">
                        <label for="vaccine_id" class="block text-sm font-medium text-gray-700 mb-1">Vaccine</label>
                        <select id="vaccine_id" name="vaccine_id"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                            <option value="">Select Vaccine</option>
                            <?php if (!empty($vaccines)): ?>
                                <?php foreach ($vaccines as $vaccine): ?>
                                    <option value="<?= $vaccine->id ?>">
                                        <?= htmlspecialchars($vaccine->name) ?>
                                        <?php if (!empty($vaccine->manufacturer)): ?>
                                            (<?= htmlspecialchars($vaccine->manufacturer) ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="immunization_date" class="block text-sm font-medium text-gray-700 mb-1">Immunization
                            Date</label>
                        <input type="date" id="immunization_date" name="immunization_date" value="<?= date('Y-m-d') ?>"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="administrator"
                            class="block text-sm font-medium text-gray-700 mb-1">Administrator</label>
                        <input type="text" id="administrator" name="administrator"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="lot_number" class="block text-sm font-medium text-gray-700 mb-1">Lot Number</label>
                        <input type="text" id="lot_number" name="lot_number"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="next_date" class="block text-sm font-medium text-gray-700 mb-1">Next Due
                            Date</label>
                        <input type="date" id="next_date" name="next_date"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea id="notes" name="notes" rows="2"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                <button type="button" id="cancelImmunizationBtn"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    Cancel
                </button>
                <button type="submit" id="saveImmunizationBtn"
                    class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                    Save Immunization
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal elements
        const modal = document.getElementById('addImmunizationModal');
        const modalContent = document.getElementById('addImmunizationModalContent');
        const openModalBtn = document.getElementById('openImmunizationModalBtn');
        const closeModalBtn = document.getElementById('closeImmunizationModal');
        const cancelBtn = document.getElementById('cancelImmunizationBtn');
        const immunizationForm = document.getElementById('immunizationForm');

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
        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Form submission
        immunizationForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(immunizationForm);

            // Show loading state
            const saveBtn = document.getElementById('saveImmunizationBtn');
            const originalBtnText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
            saveBtn.disabled = true;

            // Send data to server
            fetch('<?= BASE_URL ?>/doctor/saveImmunization', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast
                        showToast('success', 'Immunization Added', 'Patient immunization has been recorded successfully!');

                        // Close modal
                        closeModal();

                        // Reload page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        throw new Error(data.message || 'Failed to save immunization');
                    }
                })
                .catch(error => {
                    console.error('Error saving immunization:', error);
                    showToast('error', 'Error', error.message || 'An unexpected error occurred. Please try again.');

                    // Reset button
                    saveBtn.innerHTML = originalBtnText;
                    saveBtn.disabled = false;
                });
        });

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