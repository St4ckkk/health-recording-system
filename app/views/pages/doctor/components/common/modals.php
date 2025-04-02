<!-- Add Vitals Modal -->
<div id="add-vitals-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Record Vital Signs</h3>
            <button class="modal-close" onclick="closeModal('add-vitals-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="vitals-form" action="<?= BASE_URL ?>/doctor/recordVitals" method="POST">
                <!-- <input type="hidden" name="patient_id" value="<?= $patient->id ?>"> -->

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
            <button class="btn btn-secondary" onclick="closeModal('add-vitals-modal')">Cancel</button>
            <button class="btn btn-primary" onclick="document.getElementById('vitals-form').submit()">Save
                Vitals</button>
        </div>
    </div>
</div>

<!-- Add Medication Modal -->
<div id="add-medication-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add Medication</h3>
            <button class="modal-close" onclick="closeModal('add-medication-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="medication-form" action="<?= BASE_URL ?>/doctor/addMedication" method="POST">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label for="medicine_id" class="form-label">Medicine</label>
                    <select id="medicine_id" name="medicine_id" class="form-select" required>
                        <option value="">Select Medicine</option>
                        <?php foreach ($medicines as $medicine): ?>
                            <option value="<?= $medicine->id ?>"><?= htmlspecialchars($medicine->name) ?>
                                (<?= htmlspecialchars($medicine->form) ?> - <?= htmlspecialchars($medicine->dosage) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
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
            <button class="btn btn-secondary" onclick="closeModal('add-medication-modal')">Cancel</button>
            <button class="btn btn-primary" onclick="document.getElementById('medication-form').submit()">Add
                Medication</button>
        </div>
    </div>
</div>

<!-- Add Diagnosis Modal -->
<div id="add-diagnosis-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Add Diagnosis</h3>
            <button class="modal-close" onclick="closeModal('add-diagnosis-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="diagnosis-form" action="<?= BASE_URL ?>/doctor/addDiagnosis" method="POST">
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label for="title" class="form-label">Diagnosis Title</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="e.g., Hypertension"
                        required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-textarea"
                        placeholder="Detailed diagnosis description..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="tags" class="form-label">Tags (comma separated)</label>
                    <input type="text" id="tags" name="tags" class="form-input"
                        placeholder="e.g., chronic, cardiovascular">
                </div>

                <div class="form-group">
                    <label for="treatment_plan" class="form-label">Treatment Plan</label>
                    <textarea id="treatment_plan" name="treatment_plan" class="form-textarea"
                        placeholder="Recommended treatment plan..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('add-diagnosis-modal')">Cancel</button>
            <button class="btn btn-primary" onclick="document.getElementById('diagnosis-form').submit()">Add
                Diagnosis</button>
        </div>
    </div>
</div>