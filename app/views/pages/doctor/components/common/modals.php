<!-- Add Vitals Modal -->
<div id="add-vitals-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Record Vital Signs</h3>
            <button class="modal-close" onclick="closeModal('add-vitals-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="vitalsForm" onsubmit="handleVitalsSubmit(event)">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?? 0 ?>">
                <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?? 0 ?>">
                <div class="grid">
                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="blood_pressure" class="form-label">Blood Pressure</label>
                            <div class="input-group">
                                <input type="text" id="blood_pressure" name="blood_pressure" class="form-input"
                                    placeholder="120/80">
                                <div class="input-group-append">mmHg</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="temperature" class="form-label">Temperature</label>
                            <div class="input-group">
                                <input type="number" id="temperature" name="temperature" class="form-input" step="0.1"
                                    placeholder="36.5">
                                <div class="input-group-append">°C</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="heart_rate" class="form-label">Heart Rate</label>
                            <div class="input-group">
                                <input type="number" id="heart_rate" name="heart_rate" class="form-input"
                                    placeholder="75">
                                <div class="input-group-append">bpm</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="respiratory_rate" class="form-label">Respiratory Rate</label>
                            <div class="input-group">
                                <input type="number" id="respiratory_rate" name="respiratory_rate" class="form-input"
                                    placeholder="16">
                                <div class="input-group-append">breaths/min</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="oxygen_saturation" class="form-label">Oxygen Saturation</label>
                            <div class="input-group">
                                <input type="number" id="oxygen_saturation" name="oxygen_saturation" class="form-input"
                                    placeholder="98">
                                <div class="input-group-append">%</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="glucose_level" class="form-label">Glucose Level</label>
                            <div class="input-group">
                                <input type="number" id="glucose_level" name="glucose_level" class="form-input"
                                    placeholder="90">
                                <div class="input-group-append">mg/dL</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight</label>
                            <div class="input-group">
                                <input type="number" id="weight" name="weight" class="form-input" step="0.1"
                                    placeholder="70">
                                <div class="input-group-append">kg</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <div class="form-group">
                            <label for="height" class="form-label">Height</label>
                            <div class="input-group">
                                <input type="number" id="height" name="height" class="form-input" placeholder="170">
                                <div class="input-group-append">cm</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('add-vitals-modal')">Cancel</button>
            <button type="submit" class="btn btn-primary" form="vitalsForm">Save Vitals</button>
        </div>
    </div>
</div>

<!-- Add Medication Modal -->
<div id="add-medication-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="medication-modal-title">Add Medication</h3>
            <button class="modal-close" onclick="closeModal('add-medication-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="medicationForm" onsubmit="handleMedicationSubmit(event)">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?? 0 ?>">
                <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?? 0 ?>">
                <input type="hidden" name="medication_id" id="medication_id" value="">
                <input type="hidden" name="medicine_inventory_id" id="medicine_inventory_id" value="">

                <div class="form-group">
                    <label for="medicine_category" class="form-label">Medicine Category</label>
                    <select id="medicine_category" name="medicine_category" class="form-select">
                        <option value="">All Categories</option>
                        <!-- Categories will be loaded via JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="medicine_search" class="form-label">Search Medicine</label>
                    <div class="input-group">
                        <input type="text" id="medicine_search" name="medicine_search" class="form-input"
                            placeholder="Type to search...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary" onclick="searchMedicines()">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="medicine_select" class="form-label">Select Medicine</label>
                    <select id="medicine_select" name="medicine_select" class="form-select" required>
                        <option value="">Select a medicine</option>
                        <!-- Options will be loaded via AJAX -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="medicine_name" class="form-label">Medicine Name</label>
                    <input type="text" id="medicine_name" name="medicine_name" class="form-input"
                        placeholder="Medicine name" readonly>
                </div>

                <div class="form-group">
                    <label for="dosage" class="form-label">Dosage</label>
                    <input type="text" id="dosage" name="dosage" class="form-input" placeholder="1 tablet" required>
                </div>

                <div class="form-group">
                    <label for="frequency" class="form-label">Frequency</label>
                    <input type="text" id="frequency" name="frequency" class="form-input" placeholder="Twice daily"
                        required>
                </div>

                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-input" value="<?= date('Y-m-d') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="purpose" class="form-label">Purpose</label>
                    <input type="text" id="purpose" name="purpose" class="form-input" placeholder="For treating...">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('add-medication-modal')">Cancel</button>
            <button type="submit" class="btn btn-primary" form="medicationForm">Save Medication</button>
        </div>
    </div>
</div>

<!-- Add Diagnosis Modal -->
<div id="add-diagnosis-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="diagnosis-modal-title">Add Diagnosis</h3>
            <button class="modal-close" onclick="closeModal('add-diagnosis-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="diagnosisForm" onsubmit="handleDiagnosisSubmit(event)">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?? 0 ?>">
                <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?? 0 ?>">
                <input type="hidden" name="diagnosis_id" id="diagnosis_id" value="">

                <div class="form-group">
                    <label for="diagnosis_title" class="form-label">Diagnosis Title</label>
                    <input type="text" id="diagnosis_title" name="diagnosis_title" class="form-input"
                        placeholder="e.g. Hypertension, Type 2 Diabetes" required>
                </div>

                <div class="form-group">
                    <label for="diagnosis_description" class="form-label">Description</label>
                    <textarea id="diagnosis_description" name="diagnosis_description" class="form-textarea" rows="4"
                        placeholder="Detailed description of the diagnosis" required></textarea>
                </div>

                <div class="form-group">
                    <label for="diagnosis_date" class="form-label">Date</label>
                    <input type="date" id="diagnosis_date" name="diagnosis_date" class="form-input"
                        value="<?= date('Y-m-d') ?>" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('add-diagnosis-modal')">Cancel</button>
            <button type="submit" class="btn btn-primary" form="diagnosisForm">Save Diagnosis</button>
        </div>
    </div>
</div>


<!-- Add Symptoms Modal -->
<div id="add-symptoms-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="symptoms-modal-title">Add Symptom</h3>
            <button class="modal-close" onclick="closeModal('add-symptoms-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="symptomsForm" onsubmit="handleSymptomsSubmit(event)">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?? 0 ?>">
                <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?? 0 ?>">
                <input type="hidden" name="symptom_id" id="symptom_id" value="">

                <div class="form-group">
                    <label for="symptom_name" class="form-label">Symptom Name</label>
                    <input type="text" id="symptom_name" name="symptom_name" class="form-input"
                        placeholder="e.g. Headache, Fever, Cough" required>
                </div>

                <div class="form-group">
                    <label for="severity_level" class="form-label">Severity Level</label>
                    <select id="severity_level" name="severity_level" class="form-select" required>
                        <option value="">Select severity</option>
                        <option value="Mild">Mild</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Severe">Severe</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="symptom_notes" class="form-label">Notes</label>
                    <textarea id="symptom_notes" name="symptom_notes" class="form-textarea" rows="4"
                        placeholder="Additional details about the symptom" required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('add-symptoms-modal')">Cancel</button>
            <button type="submit" class="btn btn-primary" form="symptomsForm">Save Symptom</button>
        </div>
    </div>
</div>

<!-- Add Allergies Modal -->
<div id="add-allergies-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="allergies-modal-title">Add Allergy</h3>
            <button class="modal-close" onclick="closeModal('add-allergies-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="allergiesForm" onsubmit="handleAllergiesSubmit(event)">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?? 0 ?>">
                <input type="hidden" name="doctor_id" value="<?= $_SESSION['doctor_id'] ?? 0 ?>">
                <input type="hidden" name="allergy_id" id="allergy_id" value="">

                <div class="form-group">
                    <label for="allergy_type" class="form-label">Allergy Type</label>
                    <input type="text" id="allergy_type" name="allergy_type" class="form-input"
                        placeholder="e.g. Food, Drug, Environmental" required>
                </div>

                <div class="form-group">
                    <label for="allergy_name" class="form-label">Allergy Name</label>
                    <input type="text" id="allergy_name" name="allergy_name" class="form-input"
                        placeholder="e.g. Peanuts, Penicillin, Pollen" required>
                </div>

                <div class="form-group">
                    <label for="severity" class="form-label">Severity</label>
                    <select id="severity" name="severity" class="form-select" required>
                        <option value="">Select Severity</option>
                        <option value="Mild">Mild</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Severe">Severe</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reaction" class="form-label">Reaction</label>
                    <input type="text" id="reaction" name="reaction" class="form-input"
                        placeholder="e.g. Rash, Swelling, Difficulty Breathing" required>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="4"
                        placeholder="Additional details about the allergy"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('add-allergies-modal')">Cancel</button>
            <button type="submit" class="btn btn-primary" form="allergiesForm">Save Allergy</button>
        </div>
    </div>
</div>