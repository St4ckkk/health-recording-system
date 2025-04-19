// Allergies functions

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

function handleAllergiesSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const allergyId = formData.get('allergy_id') || generateUniqueId();
    const allergyType = formData.get('allergy_type') || '';
    const allergyName = formData.get('allergy_name') || '';
    const severity = formData.get('severity') || '';
    const reaction = formData.get('reaction') || '';
    const notes = formData.get('notes') || '';

    // Get the allergies container
    const allergiesContainer = document.getElementById('allergies-container');

    // Remove the "no allergies" message if it exists
    const noAllergiesMessage = document.getElementById('no-allergies-message');
    if (noAllergiesMessage) {
        noAllergiesMessage.remove();
    }

    // Create allergy data object
    const allergyData = {
        id: allergyId,
        type: allergyType,
        name: allergyName,
        severity: severity,
        reaction: reaction,
        notes: notes,
        created_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing allergies or create new array
    let pendingAllergies = [];
    const savedAllergies = localStorage.getItem('pendingAllergies_' + patientId);

    if (savedAllergies) {
        try {
            pendingAllergies = JSON.parse(savedAllergies);

            // If editing, update the existing allergy
            const existingIndex = pendingAllergies.findIndex(allergy => allergy.id === allergyId);
            if (existingIndex !== -1) {
                pendingAllergies[existingIndex] = allergyData;
            } else {
                // Otherwise add new allergy
                pendingAllergies.push(allergyData);
            }
        } catch (e) {
            console.error('Error parsing saved allergies:', e);
            pendingAllergies = [allergyData];
        }
    } else {
        pendingAllergies = [allergyData];
    }

    // Save to localStorage
    localStorage.setItem('pendingAllergies_' + patientId, JSON.stringify(pendingAllergies));

    // Display all allergies
    displayAllergyCards(pendingAllergies);

    // Close the modal and reset form
    closeModal('add-allergies-modal');
    form.reset();
    document.getElementById('allergy_id').value = '';
    document.getElementById('allergies-modal-title').textContent = 'Add Allergy';

    // Show toast notification
    showToast('success', 'Allergy Saved', 'Allergy saved successfully! These will be stored when you complete the checkup.', 'allergies-toast-container');
}

function editAllergy(id) {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedAllergies = localStorage.getItem('pendingAllergies_' + patientId);

    if (!savedAllergies) {
        alert('Cannot edit this allergy. Please refresh the page and try again.');
        return;
    }

    try {
        const allergiesData = JSON.parse(savedAllergies);
        const allergy = allergiesData.find(a => a.id === id);

        if (!allergy) {
            alert('Allergy not found.');
            return;
        }

        openModal('add-allergies-modal');
        document.getElementById('allergies-modal-title').textContent = 'Edit Allergy';

        const form = document.getElementById('allergiesForm');
        form.elements['allergy_id'].value = allergy.id;
        form.elements['allergy_type'].value = allergy.type;
        form.elements['allergy_name'].value = allergy.name;
        form.elements['severity'].value = allergy.severity;
        form.elements['reaction'].value = allergy.reaction;
        form.elements['notes'].value = allergy.notes;

    } catch (e) {
        console.error('Error loading allergy for edit:', e);
        alert('Error loading allergy data. Please try again.');
    }
}

function deleteAllergy(id) {
    if (confirm('Are you sure you want to delete this allergy?')) {
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
        const savedAllergies = localStorage.getItem('pendingAllergies_' + patientId);
        if (!savedAllergies) return;

        try {
            let allergiesData = JSON.parse(savedAllergies);
            allergiesData = allergiesData.filter(allergy => allergy.id !== id);
            localStorage.setItem('pendingAllergies_' + patientId, JSON.stringify(allergiesData));

            if (allergiesData.length === 0) {
                const allergiesContainer = document.getElementById('allergies-container');
                allergiesContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-allergies-message">
                        No allergies recorded yet.
                    </div>
                `;
            } else {
                displayAllergyCards(allergiesData);
            }

            showToast('success', 'Allergy Deleted', 'Allergy has been removed successfully.', 'allergies-toast-container');

        } catch (e) {
            console.error('Error deleting allergy:', e);
            alert('Error deleting allergy. Please try again.');
        }
    }
}

function displayAllergyCards(allergiesData) {
    const allergiesContainer = document.getElementById('allergies-container');
    if (!allergiesContainer) return;

    const noAllergiesMessage = document.getElementById('no-allergies-message');
    if (noAllergiesMessage) {
        noAllergiesMessage.remove();
    }

    let allergiesHTML = '';

    allergiesData.forEach(allergy => {
        allergiesHTML += `
            <div class="col-span-6">
                <div class="diagnosis-card">
                    <div class="diagnosis-header">
                        <div class="diagnosis-title">${allergy.name}</div>
                        <div class="diagnosis-actions">
                            <button class="action-icon edit" onclick="editAllergy('${allergy.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteAllergy('${allergy.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="diagnosis-description">
                        <p><strong>Type:</strong> ${allergy.type}</p>
                        <p><strong>Reaction:</strong> ${allergy.reaction}</p>
                        ${allergy.notes ? `<p><strong>Notes:</strong> ${allergy.notes}</p>` : ''}
                    </div>
                    <div class="diagnosis-meta">
                        <div class="diagnosis-tags">
                            <span class="diagnosis-tag ${getSeverityClass(allergy.severity)}">${allergy.severity}</span>
                        </div>
                        <div class="diagnosis-date">
                            <i class="bx bx-calendar"></i>
                            <span>${formatDate(allergy.created_at)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    allergiesContainer.innerHTML = allergiesHTML;
}

function getSeverityClass(severity) {
    switch (severity) {
        case 'Mild':
            return 'bg-green-100 text-green-800';
        case 'Moderate':
            return 'bg-yellow-100 text-yellow-800';
        case 'Severe':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

function initializeAllergies() {
    const allergiesForm = document.getElementById('allergiesForm');
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedAllergies = localStorage.getItem('pendingAllergies_' + patientId);

    if (savedAllergies) {
        try {
            const allergiesData = JSON.parse(savedAllergies);
            if (allergiesData.length > 0) {
                displayAllergyCards(allergiesData);
            }
        } catch (e) {
            console.error('Error loading saved allergies:', e);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initializeAllergies();
});