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

    // Get values from form without default values
    const vitalsData = {
        blood_pressure: formData.get('blood_pressure'),
        temperature: formData.get('temperature'),
        heart_rate: formData.get('heart_rate'),
        respiratory_rate: formData.get('respiratory_rate'),
        oxygen_saturation: formData.get('oxygen_saturation'),
        glucose_level: formData.get('glucose_level'),
        weight: formData.get('weight'),
        height: formData.get('height')
    };

    // Validate that at least one vital sign is entered
    if (Object.values(vitalsData).every(value => !value)) {
        showToast('error', 'Validation Error', 'Please enter at least one vital sign.');
        return;
    }

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
        ${vitalsData.blood_pressure ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 120/80 mmHg</div>
                </div>
            </div>
        </div>
        ` : ''}
        
        <!-- Temperature Card -->
        ${vitalsData.temperature ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 36.1-37.2 °C</div>
                </div>
            </div>
        </div>
        ` : ''}
        
        <!-- Heart Rate Card -->
        ${vitalsData.heart_rate ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 60-100 bpm</div>
                </div>
            </div>
        </div>
        ` : ''}
        
        <!-- Respiratory Rate Card -->
        ${vitalsData.respiratory_rate ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 12-20 breaths/min</div>
                </div>
            </div>
        </div>
        ` : ''}
        
        <!-- Oxygen Saturation Card -->
        ${vitalsData.oxygen_saturation ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 95-100%</div>
                </div>
            </div>
        </div>
        ` : ''}
        
        <!-- Glucose Level Card -->
        ${vitalsData.glucose_level ? `
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
                        <span>${new Date().toLocaleString()}</span>
                    </div>
                    <div>Normal: 70-99 mg/dL</div>
                </div>
            </div>
        </div>
        ` : ''}
    `;

    // Update the vitals container
    vitalsContainer.innerHTML = vitalsHTML;

    // Store only the entered vitals data in localStorage
    const cleanVitalsData = {};
    Object.entries(vitalsData).forEach(([key, value]) => {
        if (value) {
            cleanVitalsData[key] = value;
        }
    });

    cleanVitalsData.recorded_at = new Date().toISOString();

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Save to localStorage with patient ID
    localStorage.setItem('pendingVitals_' + patientId, JSON.stringify(cleanVitalsData));

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

// Initialize vitals functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Load saved vitals on page load
    loadSavedVitals();

    // Add event listener to vitals form if it exists
    const vitalsForm = document.getElementById('vitalsForm');
    if (vitalsForm) {
        vitalsForm.addEventListener('submit', handleVitalsSubmit);
    }
});