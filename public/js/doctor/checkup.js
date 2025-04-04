
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
});

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

// Medication functions
function handleMedicationSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const medicationId = formData.get('medication_id') || generateUniqueId();
    const medicineName = formData.get('medicine_name') || '';
    const dosage = formData.get('dosage') || '';
    const frequency = formData.get('frequency') || '';
    const startDate = formData.get('start_date') || new Date().toISOString().split('T')[0];
    const purpose = formData.get('purpose') || '';

    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create medication data object
    const medicationData = {
        id: medicationId,
        medicine_name: medicineName,
        dosage: dosage,
        frequency: frequency,
        start_date: startDate,
        purpose: purpose,
        created_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing medications or create new array
    let pendingMedications = [];
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            pendingMedications = JSON.parse(savedMedications);

            // If editing, update the existing medication
            const existingIndex = pendingMedications.findIndex(med => med.id === medicationId);
            if (existingIndex !== -1) {
                pendingMedications[existingIndex] = medicationData;
            } else {
                // Otherwise add new medication
                pendingMedications.push(medicationData);
            }
        } catch (e) {
            console.error('Error parsing saved medications:', e);
            pendingMedications = [medicationData];
        }
    } else {
        pendingMedications = [medicationData];
    }

    // Save to localStorage
    localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(pendingMedications));

    // Display all medications
    displayMedicationCards(pendingMedications);

    // Close the modal and reset form
    closeModal('add-medication-modal');
    form.reset();
    document.getElementById('medication_id').value = '';
    document.getElementById('medication-modal-title').textContent = 'Add Medication';

    // Show toast notification
    showToast('success', 'Medication Saved', 'Medication saved successfully! These will be stored when you complete the checkup.', 'medications-toast-container');
}

function editMedication(id) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored medications data
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
    if (!savedMedications) {
        // If no saved medications in localStorage, this might be a server-side medication
        // You would typically fetch from server here
        alert('Cannot edit this medication. Please refresh the page and try again.');
        return;
    }

    try {
        const medicationsData = JSON.parse(savedMedications);
        const medication = medicationsData.find(med => med.id === id);

        if (!medication) {
            alert('Medication not found.');
            return;
        }

        // Open the modal
        openModal('add-medication-modal');

        // Change modal title
        document.getElementById('medication-modal-title').textContent = 'Edit Medication';

        // Pre-fill the form with the stored data
        const form = document.getElementById('medicationForm');

        form.elements['medication_id'].value = medication.id;
        form.elements['medicine_name'].value = medication.medicine_name;
        form.elements['dosage'].value = medication.dosage;
        form.elements['frequency'].value = medication.frequency;
        form.elements['start_date'].value = medication.start_date;
        form.elements['purpose'].value = medication.purpose || '';

    } catch (e) {
        console.error('Error loading medication for edit:', e);
        alert('Error loading medication data. Please try again.');
    }
}

function deleteMedication(id) {
    if (confirm('Are you sure you want to delete this medication?')) {
        // Get patient ID from the page
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

        // Get the stored medications data
        const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
        if (!savedMedications) return;

        try {
            let medicationsData = JSON.parse(savedMedications);

            // Filter out the medication to delete
            medicationsData = medicationsData.filter(med => med.id !== id);

            // Save the updated medications back to localStorage
            localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(medicationsData));

            // Update the display
            if (medicationsData.length === 0) {
                const medicationsContainer = document.getElementById('medications-container');
                medicationsContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-medications-message">
                        No medications prescribed yet.
                    </div>
                `;
            } else {
                displayMedicationCards(medicationsData);
            }

            // Show toast notification
            showToast('success', 'Medication Deleted', 'Medication has been removed successfully.', 'medications-toast-container');

        } catch (e) {
            console.error('Error deleting medication:', e);
            alert('Error deleting medication. Please try again.');
        }
    }
}

function loadSavedMedications() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            const medicationsData = JSON.parse(savedMedications);
            if (medicationsData.length > 0) {
                displayMedicationCards(medicationsData);
            }
        } catch (e) {
            console.error('Error loading saved medications:', e);
        }
    }
}

function displayMedicationCards(medicationsData) {
    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');
    if (!medicationsContainer) return;

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create HTML for medication cards
    let medicationsHTML = '';

    medicationsData.forEach(medication => {
        medicationsHTML += `
            <div class="col-span-4">
                <div class="medication-card">
                    <div class="medication-header">
                        <div class="medication-title">${medication.medicine_name}</div>
                        <div class="medication-actions">
                            <button class="action-icon edit" onclick="editMedication('${medication.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteMedication('${medication.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="medication-details">
                        <div class="medication-dosage">
                            <i class="bx bx-capsule"></i>
                            <span>${medication.dosage}</span>
                        </div>
                        <div class="medication-frequency">
                            <i class="bx bx-time"></i>
                            <span>${medication.frequency}</span>
                        </div>
                        ${medication.purpose ? `
                            <div class="medication-purpose">
                                <i class="bx bx-info-circle"></i>
                                <span>${medication.purpose}</span>
                            </div>
                        ` : ''}
                        <div class="medication-date">
                            <i class="bx bx-calendar"></i>
                            <span>Started: ${formatDate(medication.start_date)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Update the medications container
    medicationsContainer.innerHTML = medicationsHTML;
}

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

// Helper functions for checking vital signs
function isNormalBloodPressure(bp) {
    const parts = bp.split('/');
    if (parts.length !== 2) return false;

    const systolic = parseInt(parts[0]);
    const diastolic = parseInt(parts[1]);

    return systolic >= 90 && systolic <= 120 && diastolic >= 60 && diastolic <= 80;
}

function isNormalTemperature(temp) {
    const temperature = parseFloat(temp);
    return temperature >= 36.1 && temperature <= 37.2;
}

function isNormalHeartRate(hr) {
    const heartRate = parseInt(hr);
    return heartRate >= 60 && heartRate <= 100;
}

function isNormalRespiratoryRate(rr) {
    const respiratoryRate = parseInt(rr);
    return respiratoryRate >= 12 && respiratoryRate <= 20;
}

function isNormalOxygenSaturation(os) {
    const oxygenSaturation = parseInt(os);
    return oxygenSaturation >= 95 && oxygenSaturation <= 100;
}

function isNormalGlucoseLevel(gl) {
    const glucoseLevel = parseInt(gl);
    return glucoseLevel >= 70 && glucoseLevel <= 99;
}

// Vitals functions
function handleVitalsSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const bloodPressure = formData.get('blood_pressure') || '120/80';
    const temperature = formData.get('temperature') || '36.5';
    const heartRate = formData.get('heart_rate') || '75';
    const respiratoryRate = formData.get('respiratory_rate') || '16';
    const oxygenSaturation = formData.get('oxygen_saturation') || '98';
    const glucoseLevel = formData.get('glucose_level') || '90';
    const weight = formData.get('weight') || '70';
    const height = formData.get('height') || '170';

    // Get the vitals container
    const vitalsContainer = document.getElementById('vitals-container');

    // Remove the "no vitals" message if it exists
    const noVitalsMessage = document.getElementById('no-vitals-message');
    if (noVitalsMessage) {
        noVitalsMessage.remove();
    }

    // Create HTML for vital cards
    const vitalsHTML = `
        <!-- Blood Pressure Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Blood Pressure</div>
                    <button class="action-icon edit" onclick="editVitalField('blood_pressure')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalBloodPressure(bloodPressure) ? 'vital-normal' : 'vital-warning'}">
                    ${bloodPressure} mmHg
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 120/80 mmHg</div>
                </div>
            </div>
        </div>
        
        <!-- Temperature Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Temperature</div>
                    <button class="action-icon edit" onclick="editVitalField('temperature')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalTemperature(temperature) ? 'vital-normal' : 'vital-warning'}">
                    ${temperature} °C
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 36.1-37.2 °C</div>
                </div>
            </div>
        </div>
        
        <!-- Heart Rate Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Heart Rate</div>
                    <button class="action-icon edit" onclick="editVitalField('heart_rate')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalHeartRate(heartRate) ? 'vital-normal' : 'vital-warning'}">
                    ${heartRate} bpm
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 60-100 bpm</div>
                </div>
            </div>
        </div>
        
        <!-- Respiratory Rate Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Respiratory Rate</div>
                    <button class="action-icon edit" onclick="editVitalField('respiratory_rate')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalRespiratoryRate(respiratoryRate) ? 'vital-normal' : 'vital-warning'}">
                    ${respiratoryRate} breaths/min
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 12-20 breaths/min</div>
                </div>
            </div>
        </div>
        
        <!-- Oxygen Saturation Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Oxygen Saturation</div>
                    <button class="action-icon edit" onclick="editVitalField('oxygen_saturation')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalOxygenSaturation(oxygenSaturation) ? 'vital-normal' : 'vital-warning'}">
                    ${oxygenSaturation}%
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 95-100%</div>
                </div>
            </div>
        </div>
        
        <!-- Glucose Level Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Glucose Level</div>
                    <button class="action-icon edit" onclick="editVitalField('glucose_level')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalGlucoseLevel(glucoseLevel) ? 'vital-normal' : 'vital-warning'}">
                    ${glucoseLevel} mg/dL
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 70-99 mg/dL</div>
                </div>
            </div>
        </div>
    `;

    // Update the vitals container
    vitalsContainer.innerHTML = vitalsHTML;

    // Store the vitals data in localStorage for later submission
    const vitalsData = {
        blood_pressure: bloodPressure,
        temperature: temperature,
        heart_rate: heartRate,
        respiratory_rate: respiratoryRate,
        oxygen_saturation: oxygenSaturation,
        glucose_level: glucoseLevel,
        weight: weight,
        height: height,
        recorded_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Save to localStorage with patient ID to keep separate records for different patients
    localStorage.setItem('pendingVitals_' + patientId, JSON.stringify(vitalsData));

    // Close the modal
    closeModal('add-vitals-modal');
    form.reset();

    // Show toast notification
    showToast('success', 'Vitals Saved', 'Vital signs saved successfully! These will be stored when you complete the checkup.');
}

// Function to edit a specific vital field
function editVitalField(fieldName) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored vitals data
    const savedVitals = localStorage.getItem('pendingVitals_' + patientId);
    if (!savedVitals) return;

    const vitalsData = JSON.parse(savedVitals);

    // Open the modal
    openModal('add-vitals-modal');

    // Pre-fill the form with the stored data
    const form = document.getElementById('vitalsForm');

    for (const [key, value] of Object.entries(vitalsData)) {
        const input = form.elements[key];
        if (input && key !== 'recorded_at') {
            input.value = value;
        }
    }
}

function loadSavedVitals() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedVitals = localStorage.getItem('pendingVitals_' + patientId);

    if (savedVitals) {
        try {
            const vitalsData = JSON.parse(savedVitals);
            displayVitalsCards(vitalsData);
        } catch (e) {
            console.error('Error loading saved vitals:', e);
        }
    }
}

function displayVitalsCards(vitalsData) {
    // Get the vitals container
    const vitalsContainer = document.getElementById('vitals-container');
    if (!vitalsContainer) return;

    // Remove the "no vitals" message if it exists
    const noVitalsMessage = document.getElementById('no-vitals-message');
    if (noVitalsMessage) {
        noVitalsMessage.remove();
    }

    // Create HTML for vital cards based on the saved data
    const vitalsHTML = `
        <!-- Blood Pressure Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Blood Pressure</div>
                    <button class="action-icon edit" onclick="editVitalField('blood_pressure')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalBloodPressure(vitalsData.blood_pressure) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.blood_pressure} mmHg
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 120/80 mmHg</div>
                </div>
            </div>
        </div>
        
        <!-- Temperature Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Temperature</div>
                    <button class="action-icon edit" onclick="editVitalField('temperature')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalTemperature(vitalsData.temperature) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.temperature} °C
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 36.1-37.2 °C</div>
                </div>
            </div>
        </div>
        
        <!-- Heart Rate Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Heart Rate</div>
                    <button class="action-icon edit" onclick="editVitalField('heart_rate')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalHeartRate(vitalsData.heart_rate) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.heart_rate} bpm
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 60-100 bpm</div>
                </div>
            </div>
        </div>
        
        <!-- Respiratory Rate Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Respiratory Rate</div>
                    <button class="action-icon edit" onclick="editVitalField('respiratory_rate')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalRespiratoryRate(vitalsData.respiratory_rate) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.respiratory_rate} breaths/min
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 12-20 breaths/min</div>
                </div>
            </div>
        </div>
        
        <!-- Oxygen Saturation Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Oxygen Saturation</div>
                    <button class="action-icon edit" onclick="editVitalField('oxygen_saturation')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalOxygenSaturation(vitalsData.oxygen_saturation) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.oxygen_saturation}%
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 95-100%</div>
                </div>
            </div>
        </div>
        
        <!-- Glucose Level Card -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Glucose Level</div>
                    <button class="action-icon edit" onclick="editVitalField('glucose_level')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value ${isNormalGlucoseLevel(vitalsData.glucose_level) ? 'vital-normal' : 'vital-warning'}">
                    ${vitalsData.glucose_level} mg/dL
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span>${new Date(vitalsData.recorded_at).toLocaleString()}</span>
                    </div>
                    <div>Normal: 70-99 mg/dL</div>
                </div>
            </div>
        </div>
    `;

    // Update the vitals container
    vitalsContainer.innerHTML = vitalsHTML;
}

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

    // Load saved vitals on page load
    loadSavedVitals();
});

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

// Medication functions
function handleMedicationSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const medicationId = formData.get('medication_id') || generateUniqueId();
    const medicineName = formData.get('medicine_name') || '';
    const dosage = formData.get('dosage') || '';
    const frequency = formData.get('frequency') || '';
    const startDate = formData.get('start_date') || new Date().toISOString().split('T')[0];
    const purpose = formData.get('purpose') || '';

    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create medication data object
    const medicationData = {
        id: medicationId,
        medicine_name: medicineName,
        dosage: dosage,
        frequency: frequency,
        start_date: startDate,
        purpose: purpose,
        created_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing medications or create new array
    let pendingMedications = [];
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            pendingMedications = JSON.parse(savedMedications);

            // If editing, update the existing medication
            const existingIndex = pendingMedications.findIndex(med => med.id === medicationId);
            if (existingIndex !== -1) {
                pendingMedications[existingIndex] = medicationData;
            } else {
                // Otherwise add new medication
                pendingMedications.push(medicationData);
            }
        } catch (e) {
            console.error('Error parsing saved medications:', e);
            pendingMedications = [medicationData];
        }
    } else {
        pendingMedications = [medicationData];
    }

    // Save to localStorage
    localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(pendingMedications));

    // Display all medications
    displayMedicationCards(pendingMedications);

    // Close the modal and reset form
    closeModal('add-medication-modal');
    form.reset();
    document.getElementById('medication_id').value = '';
    document.getElementById('medication-modal-title').textContent = 'Add Medication';

    // Show toast notification
    showToast('success', 'Medication Saved', 'Medication saved successfully! These will be stored when you complete the checkup.', 'medications-toast-container');
}

function editMedication(id) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored medications data
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
    if (!savedMedications) {
        // If no saved medications in localStorage, this might be a server-side medication
        // You would typically fetch from server here
        alert('Cannot edit this medication. Please refresh the page and try again.');
        return;
    }

    try {
        const medicationsData = JSON.parse(savedMedications);
        const medication = medicationsData.find(med => med.id === id);

        if (!medication) {
            alert('Medication not found.');
            return;
        }

        // Open the modal
        openModal('add-medication-modal');

        // Change modal title
        document.getElementById('medication-modal-title').textContent = 'Edit Medication';

        // Pre-fill the form with the stored data
        const form = document.getElementById('medicationForm');

        form.elements['medication_id'].value = medication.id;
        form.elements['medicine_name'].value = medication.medicine_name;
        form.elements['dosage'].value = medication.dosage;
        form.elements['frequency'].value = medication.frequency;
        form.elements['start_date'].value = medication.start_date;
        form.elements['purpose'].value = medication.purpose || '';

    } catch (e) {
        console.error('Error loading medication for edit:', e);
        alert('Error loading medication data. Please try again.');
    }
}

function deleteMedication(id) {
    if (confirm('Are you sure you want to delete this medication?')) {
        // Get patient ID from the page
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

        // Get the stored medications data
        const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
        if (!savedMedications) return;

        try {
            let medicationsData = JSON.parse(savedMedications);

            // Filter out the medication to delete
            medicationsData = medicationsData.filter(med => med.id !== id);

            // Save the updated medications back to localStorage
            localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(medicationsData));

            // Update the display
            if (medicationsData.length === 0) {
                const medicationsContainer = document.getElementById('medications-container');
                medicationsContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-medications-message">
                        No medications prescribed yet.
                    </div>
                `;
            } else {
                displayMedicationCards(medicationsData);
            }

            // Show toast notification
            showToast('success', 'Medication Deleted', 'Medication has been removed successfully.', 'medications-toast-container');

        } catch (e) {
            console.error('Error deleting medication:', e);
            alert('Error deleting medication. Please try again.');
        }
    }
}

function loadSavedMedications() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            const medicationsData = JSON.parse(savedMedications);
            if (medicationsData.length > 0) {
                displayMedicationCards(medicationsData);
            }
        } catch (e) {
            console.error('Error loading saved medications:', e);
        }
    }
}

function displayMedicationCards(medicationsData) {
    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');
    if (!medicationsContainer) return;

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create HTML for medication cards
    let medicationsHTML = '';

    medicationsData.forEach(medication => {
        medicationsHTML += `
            <div class="col-span-4">
                <div class="medication-card">
                    <div class="medication-header">
                        <div class="medication-title">${medication.medicine_name}</div>
                        <div class="medication-actions">
                            <button class="action-icon edit" onclick="editMedication('${medication.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteMedication('${medication.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="medication-details">
                        <div class="medication-dosage">
                            <i class="bx bx-capsule"></i>
                            <span>${medication.dosage}</span>
                        </div>
                        <div class="medication-frequency">
                            <i class="bx bx-time"></i>
                            <span>${medication.frequency}</span>
                        </div>
                        ${medication.purpose ? `
                            <div class="medication-purpose">
                                <i class="bx bx-info-circle"></i>
                                <span>${medication.purpose}</span>
                            </div>
                        ` : ''}
                        <div class="medication-date">
                            <i class="bx bx-calendar"></i>
                            <span>Started: ${formatDate(medication.start_date)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Update the medications container
    medicationsContainer.innerHTML = medicationsHTML;
}

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
        // You would typically fetch from server here
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

// Update the DOMContentLoaded event to also load diagnoses
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
    loadSavedVitals();
    loadSavedMedications();
    loadSavedDiagnoses();
});
