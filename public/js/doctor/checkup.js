// Helper function to format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

// Helper function to generate unique ID
function generateUniqueId() {
    return 'temp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

// Enhanced toast function to support multiple containers
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

// Modal functionality
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// Close modals when clicking outside
window.addEventListener('click', function (event) {
    document.querySelectorAll('.modal.active').forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('active');
        }
    });
});

// Tab functionality
document.addEventListener('DOMContentLoaded', function () {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    // Set initial active tab
    if (tabButtons.length > 0 && tabContents.length > 0) {
        tabButtons[0].classList.add('active');
        tabContents[0].classList.add('active');
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');

            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to current button and content
            this.classList.add('active');
            const targetTab = document.getElementById(`${tabId}-tab`);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });

    // Load saved data on page load
    if (typeof loadSavedVitals === 'function') loadSavedVitals();
    if (typeof loadSavedMedications === 'function') loadSavedMedications();
    if (typeof loadSavedDiagnoses === 'function') loadSavedDiagnoses();

    // Add event listeners to forms if they exist
    const vitalsForm = document.getElementById('vitalsForm');
    if (vitalsForm && typeof handleVitalsSubmit === 'function') {
        vitalsForm.addEventListener('submit', handleVitalsSubmit);
    }

    const medicationForm = document.getElementById('medicationForm');
    if (medicationForm && typeof handleMedicationSubmit === 'function') {
        medicationForm.addEventListener('submit', handleMedicationSubmit);
    }

    const diagnosisForm = document.getElementById('diagnosisForm');
    if (diagnosisForm && typeof handleDiagnosisSubmit === 'function') {
        diagnosisForm.addEventListener('submit', handleDiagnosisSubmit);
    }
});



// Function to handle complete checkup
// Inside completeCheckup function, update the checkupData structure
function completeCheckup() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const doctorId = document.querySelector('input[name="doctor_id"]')?.value || '0';

    // Get all data from localStorage
    const pendingVitals = JSON.parse(localStorage.getItem('pendingVitals_' + patientId) || 'null');
    const pendingMedications = JSON.parse(localStorage.getItem('pendingMedications_' + patientId) || '[]');
    const pendingDiagnoses = JSON.parse(localStorage.getItem('pendingDiagnoses_' + patientId) || '[]');

    // Update the medications data structure to match the database
    const medications = pendingMedications.map(med => ({
        ...med,
        type: 'prescribed',
        patient_id: patientId,
        prescribed_by: doctorId,
        start_date: med.start_date || new Date().toISOString().split('T')[0],
        quantity: med.quantity || 1,
        purpose: med.purpose || 'Prescribed during checkup',
        remarks: `Prescribed: ${med.dosage} - ${med.frequency}`
    }));

    // Prepare data for submission
    const checkupData = {
        patient_id: patientId,
        doctor_id: doctorId,
        vitals: pendingVitals,
        medications: medications,
        diagnoses: pendingDiagnoses,
        notes: document.getElementById('checkup_notes')?.value || ''
    };

    // Show loading state
    const completeBtn = document.querySelector('.complete-checkup-btn');
    const originalBtnText = completeBtn.innerHTML;
    completeBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
    completeBtn.disabled = true;

    // Send data to server
    fetch('/doctor/save-checkup', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(checkupData)
    })
        .then(response => {
            // First check if response is ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            // Then try to parse JSON
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Invalid JSON response: ' + text);
                }
            });
        })
        .then(data => {
            if (data.success) {
                // Clear localStorage
                localStorage.removeItem('pendingVitals_' + patientId);
                localStorage.removeItem('pendingMedications_' + patientId);
                localStorage.removeItem('pendingDiagnoses_' + patientId);

                // Show success message
                showToast('success', 'Checkup Completed', 'Patient checkup data has been saved successfully!');

                // Redirect to patient view after a short delay
                setTimeout(() => {
                    window.location.href = `/doctor/patientView?id=${patientId}`;
                }, 2000);
            } else {
                throw new Error(data.message || 'Failed to save checkup data');
            }
        })
        .catch(error => {
            console.error('Error saving checkup:', error);
            showToast('error', 'Error', 'An unexpected error occurred. Please try again.');

            // Reset button
            completeBtn.innerHTML = originalBtnText;
            completeBtn.disabled = false;
        });
}

// Function to save draft
function saveDraft() {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Show toast notification
    showToast('success', 'Draft Saved', 'Your checkup data has been saved as a draft. You can continue later.');
}