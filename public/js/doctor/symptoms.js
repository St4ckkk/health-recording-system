// Symptoms functions

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

function handleSymptomsSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const symptomId = formData.get('symptom_id') || generateUniqueId();
    const symptomName = formData.get('symptom_name') || '';
    const severityLevel = formData.get('severity_level') || '';
    const symptomNotes = formData.get('symptom_notes') || '';

    // Get the symptoms container
    const symptomsContainer = document.getElementById('symptoms-container');

    // Remove the "no symptoms" message if it exists
    const noSymptomsMessage = document.getElementById('no-symptoms-message');
    if (noSymptomsMessage) {
        noSymptomsMessage.remove();
    }

    // Create symptom data object
    const symptomData = {
        id: symptomId,
        name: symptomName,
        severity_level: severityLevel,
        notes: symptomNotes,
        created_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing symptoms or create new array
    let pendingSymptoms = [];
    const savedSymptoms = localStorage.getItem('pendingSymptoms_' + patientId);

    if (savedSymptoms) {
        try {
            pendingSymptoms = JSON.parse(savedSymptoms);

            // If editing, update the existing symptom
            const existingIndex = pendingSymptoms.findIndex(symp => symp.id === symptomId);
            if (existingIndex !== -1) {
                pendingSymptoms[existingIndex] = symptomData;
            } else {
                // Otherwise add new symptom
                pendingSymptoms.push(symptomData);
            }
        } catch (e) {
            console.error('Error parsing saved symptoms:', e);
            pendingSymptoms = [symptomData];
        }
    } else {
        pendingSymptoms = [symptomData];
    }

    // Save to localStorage
    localStorage.setItem('pendingSymptoms_' + patientId, JSON.stringify(pendingSymptoms));

    // Display all symptoms
    displaySymptomCards(pendingSymptoms);

    // Close the modal and reset form
    closeModal('add-symptoms-modal');
    form.reset();
    document.getElementById('symptom_id').value = '';
    document.getElementById('symptoms-modal-title').textContent = 'Add Symptom';

    // Show toast notification
    showToast('success', 'Symptom Saved', 'Symptom saved successfully! These will be stored when you complete the checkup.', 'symptoms-toast-container');
}

function editSymptom(id) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored symptoms data
    const savedSymptoms = localStorage.getItem('pendingSymptoms_' + patientId);
    if (!savedSymptoms) {
        alert('Cannot edit this symptom. Please refresh the page and try again.');
        return;
    }

    try {
        const symptomsData = JSON.parse(savedSymptoms);
        const symptom = symptomsData.find(symp => symp.id === id);

        if (!symptom) {
            alert('Symptom not found.');
            return;
        }

        // Open the modal
        openModal('add-symptoms-modal');

        // Change modal title
        document.getElementById('symptoms-modal-title').textContent = 'Edit Symptom';

        // Pre-fill the form with the stored data
        const form = document.getElementById('symptomsForm');

        form.elements['symptom_id'].value = symptom.id;
        form.elements['symptom_name'].value = symptom.name;
        form.elements['severity_level'].value = symptom.severity_level;
        form.elements['symptom_notes'].value = symptom.notes;

    } catch (e) {
        console.error('Error loading symptom for edit:', e);
        alert('Error loading symptom data. Please try again.');
    }
}

function deleteSymptom(id) {
    if (confirm('Are you sure you want to delete this symptom?')) {
        // Get patient ID from the page
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

        // Get the stored symptoms data
        const savedSymptoms = localStorage.getItem('pendingSymptoms_' + patientId);
        if (!savedSymptoms) return;

        try {
            let symptomsData = JSON.parse(savedSymptoms);

            // Filter out the symptom to delete
            symptomsData = symptomsData.filter(symp => symp.id !== id);

            // Save the updated symptoms back to localStorage
            localStorage.setItem('pendingSymptoms_' + patientId, JSON.stringify(symptomsData));

            // Update the display
            if (symptomsData.length === 0) {
                const symptomsContainer = document.getElementById('symptoms-container');
                symptomsContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-symptoms-message">
                        No symptoms recorded yet.
                    </div>
                `;
            } else {
                displaySymptomCards(symptomsData);
            }

            // Show toast notification
            showToast('success', 'Symptom Deleted', 'Symptom has been removed successfully.', 'symptoms-toast-container');

        } catch (e) {
            console.error('Error deleting symptom:', e);
            alert('Error deleting symptom. Please try again.');
        }
    }
}

function loadSavedSymptoms() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedSymptoms = localStorage.getItem('pendingSymptoms_' + patientId);

    if (savedSymptoms) {
        try {
            const symptomsData = JSON.parse(savedSymptoms);
            if (symptomsData.length > 0) {
                displaySymptomCards(symptomsData);
            }
        } catch (e) {
            console.error('Error loading saved symptoms:', e);
        }
    }
}

function displaySymptomCards(symptomsData) {
    // Get the symptoms container
    const symptomsContainer = document.getElementById('symptoms-container');
    if (!symptomsContainer) return;

    // Remove the "no symptoms" message if it exists
    const noSymptomsMessage = document.getElementById('no-symptoms-message');
    if (noSymptomsMessage) {
        noSymptomsMessage.remove();
    }

    // Create HTML for symptom cards
    let symptomsHTML = '';

    symptomsData.forEach(symptom => {
        // Get severity class for color coding
        let severityClass = '';
        switch (symptom.severity_level) {
            case 'Mild':
                severityClass = 'bg-green-100 text-green-800';
                break;
            case 'Moderate':
                severityClass = 'bg-yellow-100 text-yellow-800';
                break;
            case 'Severe':
                severityClass = 'bg-red-100 text-red-800';
                break;
            default:
                severityClass = 'bg-gray-100 text-gray-800';
        }

        symptomsHTML += `
            <div class="col-span-6">
                <div class="symptom-card">
                    <div class="symptom-header">
                        <div class="symptom-title">${symptom.name}</div>
                        <div class="symptom-actions">
                            <button class="action-icon edit" onclick="editSymptom('${symptom.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteSymptom('${symptom.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="symptom-severity">
                        <span class="severity-badge ${severityClass}">${symptom.severity_level}</span>
                    </div>
                    <div class="symptom-description">
                        ${symptom.notes}
                    </div>
                    <div class="symptom-meta">
                        <div class="symptom-date">
                            <i class="bx bx-calendar"></i>
                            <span>${formatDate(symptom.created_at)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Update the symptoms container
    symptomsContainer.innerHTML = symptomsHTML;
}

// Initialize symptoms functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Load saved symptoms on page load
    loadSavedSymptoms();

    // Add event listener to symptoms form if it exists
    const symptomsForm = document.getElementById('symptomsForm');
    if (symptomsForm) {
        symptomsForm.addEventListener('submit', handleSymptomsSubmit);
    }
});

