<div class="overflow-x-auto">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Admission History</h3>
        <button id="openAdmissionModalBtn"
            class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition-colors">
            <i class='bx bx-plus mr-1'></i> Add
        </button>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ward</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bed No.</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission
                    Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discharge
                    Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($admissionHistory)): ?>
                <?php foreach ($admissionHistory as $admission): ?>
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->diagnosis_name ?? 'No diagnosis') ?>
                            <?php if (!empty($admission->diagnosis_notes)): ?>
                                <span
                                    class="block text-xs text-gray-400"><?= htmlspecialchars($admission->diagnosis_notes) ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->ward) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($admission->bed_no) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= date('Y-m-d', strtotime($admission->admission_date)) ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?= $admission->discharge_date ? date('Y-m-d', strtotime($admission->discharge_date)) : 'Not discharged' ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                <?= $admission->status === 'active' ? 'bg-green-100 text-green-800' :
                                    ($admission->status === 'discharged' ? 'bg-gray-100 text-gray-800' :
                                        'bg-yellow-100 text-yellow-800') ?>">
                                <?= htmlspecialchars($admission->status) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2 items-center">
                                <a href="<?= BASE_URL ?>/doctor/admission/view?id=<?= $admission->id ?>"
                                    class="text-blue-600 text-sm inline-flex items-center hover:text-blue-900">
                                    View Details <i class='bx bx-right-arrow-alt ml-1'></i>
                                </a>

                                <?php if ($admission->status === 'active'): ?>
                                    <a href="<?= BASE_URL ?>/doctor/admission/update?id=<?= $admission->id ?>"
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium hover:bg-yellow-200">
                                        Update
                                    </a>
                                    <a href="<?= BASE_URL ?>/doctor/admission/discharge?id=<?= $admission->id ?>"
                                        class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium hover:bg-green-200">
                                        Discharge
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="px-4 py-3 text-center text-sm text-gray-500">
                        No admission records found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Admission Modal -->
<div id="addAdmissionModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="addAdmissionModalContent">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Add New Admission</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeAdmissionModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <form id="admissionForm">
            <div class="px-6 py-4">
                <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                    <div class="flex items-start">
                        <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                        <p class="text-sm text-blue-700">
                            Please fill in the admission details for this patient.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="hidden" name="patient_id" value="<?= $patient->id ?>">
                    <input type="hidden" name="admitted_by" value="<?= $_SESSION['doctor_id'] ?>">

                    <div class="mb-3">
                        <label for="diagnosis_id" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                        <select id="diagnosis_id" name="diagnosis_id"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="">Select Diagnosis</option>
                            <?php if (!empty($patientDiagnosis)): ?>
                                <?php foreach ($patientDiagnosis as $diagnosis): ?>
                                    <option value="<?= $diagnosis->id ?>">
                                        <?= htmlspecialchars($diagnosis->diagnosis) ?>
                                        <?php if (!empty($diagnosis->diagnosed_at)): ?>
                                            (<?= date('Y-m-d', strtotime($diagnosis->diagnosed_at)) ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-3">
                            <label for="ward" class="block text-sm font-medium text-gray-700 mb-1">Ward</label>
                            <select id="ward" name="ward"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                                required>
                                <option value="">Select Ward</option>
                                <option value="General">General Ward</option>
                                <option value="ICU">ICU</option>
                                <option value="Emergency">Emergency</option>
                                <option value="Pediatric">Pediatric</option>
                                <option value="Maternity">Maternity</option>
                                <option value="Surgery">Surgery</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bed_no" class="block text-sm font-medium text-gray-700 mb-1">Bed Number</label>
                            <input type="text" id="bed_no" name="bed_no"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="admission_date" class="block text-sm font-medium text-gray-700 mb-1">Admission
                            Date</label>
                        <input type="date" id="admission_date" name="admission_date" value="<?= date('Y-m-d') ?>"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for
                            Admission</label>
                        <textarea id="reason" name="reason" rows="2"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            required></textarea>
                    </div>

                    <input type="hidden" name="status" value="active">
                </div>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                <button type="button" id="cancelAdmissionBtn"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    Cancel
                </button>
                <button type="submit" id="saveAdmissionBtn"
                    class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-dark focus:outline-none">
                    Save Admission
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal elements
        const modal = document.getElementById('addAdmissionModal');
        const modalContent = document.getElementById('addAdmissionModalContent');
        const openModalBtn = document.getElementById('openAdmissionModalBtn');
        const closeModalBtn = document.getElementById('closeAdmissionModal');
        const cancelBtn = document.getElementById('cancelAdmissionBtn');
        const admissionForm = document.getElementById('admissionForm');

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
        admissionForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(admissionForm);

            // Show loading state
            const saveBtn = document.getElementById('saveAdmissionBtn');
            const originalBtnText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
            saveBtn.disabled = true;

            // Send data to server
            fetch('<?= BASE_URL ?>/doctor/saveAdmission', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast
                        showToast('success', 'Admission Added', 'Patient admission has been recorded successfully!');

                        // Close modal
                        closeModal();

                        // Reload page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        throw new Error(data.message || 'Failed to save admission');
                    }
                })
                .catch(error => {
                    console.error('Error saving admission:', error);
                    showToast('error', 'Error', 'An unexpected error occurred. Please try again.');

                    // Reset button
                    saveBtn.innerHTML = originalBtnText;
                    saveBtn.disabled = false;
                });
        });

        // Toast function from checkup.js
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