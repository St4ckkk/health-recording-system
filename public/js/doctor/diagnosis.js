// Diagnosis functions
function handleDiagnosisSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const diagnosisId = formData.get('diagnosis_id') || generateUniqueId();
    const diagnosisTitle = formData.get('diagnosis_title') || '';
    const diagnosisDescription = formData.get('diagnosis_description') || '';
    const diagnosisTags = formData.get('diagnosis_tags') || '';
    const diagnosisDate = formData.get('diagnosis_date') || new Date().toISOString().split('T')[0];

    // Get the diagnosis container
    const diagnosisContainer = document.getElementById('diagnosis-container');

    // Remove the "no diagnosis" message if it exists
    const noDiagnosisMessage = document.getElementById('no-diagnosis-message');
    if (noDiagnosisMessage) {
        noDiagnosisMessage.remove();
    }

    // Create diagnosis data object
    const diagnosisData = {
        id: diagnosisId,
        title: diagnosisTitle,
        description: diagnosisDescription,
        tags: diagnosisTags,
        created_at: diagnosisDate,
        updated_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing diagnoses or create new array
    let pendingDiagnoses = [];
    const savedDiagnoses = localStorage.getItem('pendingDiagnoses_' + patientId);

    if (savedDiagnoses) {
        try {
            pendingDiagnoses = JSON.parse(savedDiagnoses);

            // If editing, update the existing diagnosis
            const existingIndex = pendingDiagnoses.findIndex(diag => diag.id === diagnosisId);
            if (existingIndex !== -1) {
                pendingDiagnoses[existingIndex] = diagnosisData;
            } else {
                // Otherwise add new diagnosis
                pendingDiagnoses.push(diagnosisData);
            }
        } catch (e) {
            console.error('Error parsing saved diagnoses:', e);
            pendingDiagnoses = [diagnosisData];
        }
    } else {
        pendingDiagnoses = [diagnosisData];
    }

    // Save to localStorage
    localStorage.setItem('pendingDiagnoses_' + patientId, JSON.stringify(pendingDiagnoses));

    // Display all diagnoses
    displayDiagnosisCards(pendingDiagnoses);

    // Close the modal and reset form
    closeModal('add-diagnosis-modal');
    form.reset();
    document.getElementById('diagnosis_id').value = '';
    document.getElementById('diagnosis-modal-title').textContent = 'Add Diagnosis';

    // Show toast notification
    showToast('success', 'Diagnosis Saved', 'Diagnosis saved successfully! These will be stored when you complete the checkup.', 'diagnosis-toast-container');
}

function editDiagnosis(id) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored diagnoses data
    const savedDiagnoses = localStorage.getItem('pendingDiagnoses_' + patientId);
    if (!savedDiagnoses) {
        // If no saved diagnoses in localStorage, this might be a server-side diagnosis
        alert('Cannot edit this diagnosis. Please refresh the page and try again.');
        return;
    }

    try {
        const diagnosesData = JSON.parse(savedDiagnoses);
        const diagnosis = diagnosesData.find(diag => diag.id === id);

        if (!diagnosis) {
            alert('Diagnosis not found.');
            return;
        }

        // Open the modal
        openModal('add-diagnosis-modal');

        // Change modal title
        document.getElementById('diagnosis-modal-title').textContent = 'Edit Diagnosis';

        // Pre-fill the form with the stored data
        const form = document.getElementById('diagnosisForm');

        form.elements['diagnosis_id'].value = diagnosis.id;
        form.elements['diagnosis_title'].value = diagnosis.title;
        form.elements['diagnosis_description'].value = diagnosis.description;
        form.elements['diagnosis_tags'].value = diagnosis.tags;
        form.elements['diagnosis_date'].value = diagnosis.created_at.split('T')[0];

    } catch (e) {
        console.error('Error loading diagnosis for edit:', e);
        alert('Error loading diagnosis data. Please try again.');
    }
}

function deleteDiagnosis(id) {
    if (confirm('Are you sure you want to delete this diagnosis?')) {
        // Get patient ID from the page
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

        // Get the stored diagnoses data
        const savedDiagnoses = localStorage.getItem('pendingDiagnoses_' + patientId);
        if (!savedDiagnoses) return;

        try {
            let diagnosesData = JSON.parse(savedDiagnoses);

            // Filter out the diagnosis to delete
            diagnosesData = diagnosesData.filter(diag => diag.id !== id);

            // Save the updated diagnoses back to localStorage
            localStorage.setItem('pendingDiagnoses_' + patientId, JSON.stringify(diagnosesData));

            // Update the display
            if (diagnosesData.length === 0) {
                const diagnosisContainer = document.getElementById('diagnosis-container');
                diagnosisContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-diagnosis-message">
                        No diagnoses recorded yet.
                    </div>
                `;
            } else {
                displayDiagnosisCards(diagnosesData);
            }

            // Show toast notification
            showToast('success', 'Diagnosis Deleted', 'Diagnosis has been removed successfully.', 'diagnosis-toast-container');

        } catch (e) {
            console.error('Error deleting diagnosis:', e);
            alert('Error deleting diagnosis. Please try again.');
        }
    }
}

function loadSavedDiagnoses() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedDiagnoses = localStorage.getItem('pendingDiagnoses_' + patientId);

    if (savedDiagnoses) {
        try {
            const diagnosesData = JSON.parse(savedDiagnoses);
            if (diagnosesData.length > 0) {
                displayDiagnosisCards(diagnosesData);
            }
        } catch (e) {
            console.error('Error loading saved diagnoses:', e);
        }
    }
}

function displayDiagnosisCards(diagnosesData) {
    // Get the diagnosis container
    const diagnosisContainer = document.getElementById('diagnosis-container');
    if (!diagnosisContainer) return;

    // Remove the "no diagnosis" message if it exists
    const noDiagnosisMessage = document.getElementById('no-diagnosis-message');
    if (noDiagnosisMessage) {
        noDiagnosisMessage.remove();
    }

    // Create HTML for diagnosis cards
    let diagnosisHTML = '';

    diagnosesData.forEach(diagnosis => {
        // Create tag elements
        let tagElements = '';
        if (diagnosis.tags) {
            const tags = diagnosis.tags.split(',');
            tags.forEach(tag => {
                if (tag.trim()) {
                    tagElements += `<span class="diagnosis-tag">${tag.trim()}</span>`;
                }
            });
        }

        diagnosisHTML += `
            <div class="col-span-6">
                <div class="diagnosis-card">
                    <div class="diagnosis-header">
                        <div class="diagnosis-title">${diagnosis.title}</div>
                        <div class="diagnosis-actions">
                            <button class="action-icon edit" onclick="editDiagnosis('${diagnosis.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteDiagnosis('${diagnosis.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="diagnosis-description">
                        ${diagnosis.description}
                    </div>
                    <div class="diagnosis-meta">
                        <div class="diagnosis-tags">
                            ${tagElements}
                        </div>
                        <div class="diagnosis-date">
                            <i class="bx bx-calendar"></i>
                            <span>${formatDate(diagnosis.created_at)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Update the diagnosis container
    diagnosisContainer.innerHTML = diagnosisHTML;
}

// Initialize diagnosis functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Load saved diagnoses on page load
    loadSavedDiagnoses();

    // Add event listener to diagnosis form if it exists
    const diagnosisForm = document.getElementById('diagnosisForm');
    if (diagnosisForm) {
        diagnosisForm.addEventListener('submit', handleDiagnosisSubmit);
    }
});