<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Vital Signs</h3>
            <p class="card-subtitle">Record patient's vital signs</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('add-vitals-modal')">
            <i class="bx bx-plus"></i>
            Record Vitals
        </button>
    </div>

    <!-- Vitals Grid Container -->
    <div class="vitals-grid grid grid-cols-12 gap-4 mt-4" id="vitals-container">
        <!-- Vital cards will be displayed here -->
        <div class="col-span-12 text-center py-6 text-gray-500" id="no-vitals-message">
            No vital signs recorded yet.
        </div>
    </div>

    <div class="add-item-btn mt-4" onclick="openModal('add-vitals-modal')">
        <i class="bx bx-plus"></i>
        Record New Vitals
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50"></div>

<script>
    // Load saved vitals from localStorage on page load
    document.addEventListener('DOMContentLoaded', function () {
        loadSavedVitals();
    });

    function loadSavedVitals() {
        const patientId = '<?= $patient->id ?? 0 ?>';
        const savedVitals = localStorage.getItem('pendingVitals_' + patientId);

        if (savedVitals) {
            const vitalsData = JSON.parse(savedVitals);
            displayVitalsCards(vitalsData);
        }
    }

    function displayVitalsCards(vitalsData) {
        // Get the vitals container
        const vitalsContainer = document.getElementById('vitals-container');
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
        `;

        // Update the vitals container
        vitalsContainer.innerHTML = vitalsHTML;
    }
</script>