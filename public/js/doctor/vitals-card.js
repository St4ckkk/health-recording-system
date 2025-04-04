// Store form data temporarily
let tempVitalsData = null;

// Mock previous vitals data (in a real app, this would come from the database)
const previousVitals = {
    blood_pressure: "120/80",
    temperature: "36.5",
    heart_rate: "72",
    respiratory_rate: "16",
    oxygen_saturation: "98",
    glucose_level: "90",
    weight: "70",
    height: "170"
};

// Preview vitals before saving
function previewVitals(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Store the form data temporarily
    tempVitalsData = formData;

    // Update preview values for each vital sign
    updateVitalPreview('heart_rate', formData.get('heart_rate'), 'bpm');
    updateVitalPreview('blood_pressure', formData.get('blood_pressure'), 'mmHg');
    updateVitalPreview('temperature', formData.get('temperature'), '°C');
    updateVitalPreview('respiratory_rate', formData.get('respiratory_rate'), 'br/min');
    updateVitalPreview('oxygen_saturation', formData.get('oxygen_saturation'), '%');
    updateVitalPreview('glucose_level', formData.get('glucose_level'), 'mg/dL');

    // Show the preview section
    document.getElementById('vitals-preview').style.display = 'block';

    // Close the modal
    closeModal('add-vitals-modal');
}

// Helper function to update a vital sign preview
function updateVitalPreview(vitalName, value, unit) {
    // Update the value
    const valueElement = document.getElementById(`preview-${vitalName}-value`);
    if (valueElement) valueElement.textContent = value;

    // Update the previous value
    const previousElement = document.getElementById(`preview-${vitalName}-previous`);
    if (previousElement) previousElement.textContent = `Previous: ${previousVitals[vitalName]} ${unit}`;

    // Calculate and update the change
    const changeElement = document.getElementById(`preview-${vitalName}-change`);
    if (changeElement) {
        // For blood pressure, we need special handling
        if (vitalName === 'blood_pressure') {
            // Skip change calculation for blood pressure as it's complex
            changeElement.textContent = '';
            return;
        }

        const currentValue = parseFloat(value);
        const previousValue = parseFloat(previousVitals[vitalName]);

        if (!isNaN(currentValue) && !isNaN(previousValue)) {
            const diff = currentValue - previousValue;
            const sign = diff > 0 ? '+' : '';

            changeElement.textContent = `${sign}${diff.toFixed(1)} from last visit`;

            // Add color class based on change
            changeElement.className = 'vital-change';
            if (diff > 0) {
                changeElement.classList.add('positive');
            } else if (diff < 0) {
                changeElement.classList.add('negative');
            } else {
                changeElement.classList.add('neutral');
            }
        } else {
            changeElement.textContent = '';
        }
    }
}

// Confirm and save vitals
function confirmVitals() {
    if (!tempVitalsData) return;

    // Here you would normally submit the form data to the server
    // For now, we'll just call the existing handleVitalsSubmit function
    const vitalsForm = document.getElementById('vitalsForm');

    // Create a mock event with the stored form data
    const mockEvent = {
        preventDefault: () => { },
        target: vitalsForm
    };

    // Call the existing function to handle the submission
    handleVitalsSubmit(mockEvent);

    // Hide the preview
    document.getElementById('vitals-preview').style.display = 'none';

    // Clear the temporary data
    tempVitalsData = null;
}

// Cancel vitals entry
function cancelVitals() {
    // Hide the preview
    document.getElementById('vitals-preview').style.display = 'none';

    // Clear the temporary data
    tempVitalsData = null;

    // Reset the form
    document.getElementById('vitalsForm').reset();
}

// Modify the existing handleVitalsSubmit function to work with our preview
function handleVitalsSubmit(event) {
    event.preventDefault();
    const form = event.target;
    let formData;

    // Use the stored data if available, otherwise get it from the form
    if (tempVitalsData) {
        formData = tempVitalsData;
    } else {
        formData = new FormData(form);
    }

    // Create vitals display element
    const vitalsContainer = document.querySelector('#vitals-tab .card');
    const newVitalsItem = createVitalsDisplay(formData);

    // Insert after the header
    const cardHeader = vitalsContainer.querySelector('.card-header');
    cardHeader.insertAdjacentHTML('afterend', newVitalsItem);

    // Remove "no vitals" message if it exists
    const noVitalsMessage = vitalsContainer.querySelector('.text-center.py-6');
    if (noVitalsMessage) {
        noVitalsMessage.remove();
    }

    // Reset form and temporary data
    form.reset();
    tempVitalsData = null;

    // Hide the preview if it's visible
    document.getElementById('vitals-preview').style.display = 'none';

    // Update the previous vitals data for next time
    previousVitals.blood_pressure = formData.get('blood_pressure');
    previousVitals.temperature = formData.get('temperature');
    previousVitals.heart_rate = formData.get('heart_rate');
    previousVitals.respiratory_rate = formData.get('respiratory_rate');
    previousVitals.oxygen_saturation = formData.get('oxygen_saturation');
    previousVitals.glucose_level = formData.get('glucose_level');
    previousVitals.weight = formData.get('weight');
    previousVitals.height = formData.get('height');
}

// Create a saved vitals display with the card design
function createVitalsDisplay(formData) {
    const date = new Date().toLocaleString();

    // Create a container for all vital cards
    let html = `
        <div class="saved-vitals-container">
            <div class="saved-vitals-header">
                <div class="saved-vitals-title">Vital Signs - ${date}</div>
            </div>
            <div class="vitals-cards-grid">
    `;

    // Add heart rate card
    html += createVitalCard(
        'heart-rate',
        'Heart Rate',
        formData.get('heart_rate'),
        'bpm',
        previousVitals.heart_rate,
        'bx-heart'
    );

    // Add blood pressure card
    html += createVitalCard(
        'blood-pressure',
        'Blood Pressure',
        formData.get('blood_pressure'),
        'mmHg',
        previousVitals.blood_pressure,
        'bx-pulse'
    );

    // Add temperature card
    html += createVitalCard(
        'temperature',
        'Temperature',
        formData.get('temperature'),
        '°C',
        previousVitals.temperature,
        'bx-hot'
    );

    // Add respiratory rate card
    html += createVitalCard(
        'respiratory',
        'Respiratory Rate',
        formData.get('respiratory_rate'),
        'br/min',
        previousVitals.respiratory_rate,
        'bx-wind'
    );

    // Add oxygen saturation card
    html += createVitalCard(
        'oxygen',
        'Oxygen Saturation',
        formData.get('oxygen_saturation'),
        '%',
        previousVitals.oxygen_saturation,
        'bx-donate-blood'
    );

    // Add glucose level card
    html += createVitalCard(
        'glucose',
        'Glucose Level',
        formData.get('glucose_level'),
        'mg/dL',
        previousVitals.glucose_level,
        'bx-test-tube'
    );

    // Close the container
    html += `
            </div>
            <div class="saved-vitals-actions">
                <button class="btn btn-sm btn-secondary" onclick="editVitals(0)">
                    <i class="bx bx-edit"></i> Edit
                </button>
            </div>
        </div>
    `;

    return html;
}

// Helper function to create a single vital card
function createVitalCard(type, name, value, unit, previousValue, icon) {
    // Calculate change
    let changeHtml = '';
    if (type !== 'blood-pressure') {
        const currentValue = parseFloat(value);
        const prevValue = parseFloat(previousValue);

        if (!isNaN(currentValue) && !isNaN(prevValue)) {
            const diff = currentValue - prevValue;
            const sign = diff > 0 ? '+' : '';
            const changeClass = diff > 0 ? 'positive' : (diff < 0 ? 'negative' : 'neutral');

            changeHtml = `<div class="vital-change ${changeClass}">${sign}${diff.toFixed(1)} from last visit</div>`;
        }
    }

    return `
        <div class="vital-card">
            <div class="vital-icon ${type}">
                <i class="bx ${icon}"></i>
            </div>
            <div class="vital-previous">Previous: ${previousValue} ${unit}</div>
            <div class="vital-value-container">
                <div class="vital-value">${value}</div>
                <div class="vital-unit">${unit}</div>
            </div>
            <div class="vital-name">${name}</div>
            ${changeHtml}
        </div>
    `;
}