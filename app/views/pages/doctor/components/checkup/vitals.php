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

    <div class="grid">
        <!-- Blood Pressure -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Blood Pressure</div>
                    <button class="action-icon edit" onclick="openModal('edit-bp-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->blood_pressure ?? '120/80') === '120/80' ? 'vital-normal' : 'vital-warning' ?>">
                    <?= htmlspecialchars($patient->vitals->blood_pressure ?? '120/80') ?> mmHg
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->blood_pressure_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: 120/80 mmHg</div>
                </div>
            </div>
        </div>

        <!-- Temperature -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Temperature</div>
                    <button class="action-icon edit" onclick="openModal('edit-temp-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->temperature ?? '36.5') <= 37.5 ? 'vital-normal' : 'vital-danger' ?>">
                    <?= htmlspecialchars($patient->vitals->temperature ?? '36.5') ?> °C
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->temperature_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: 36.1-37.2 °C</div>
                </div>
            </div>
        </div>

        <!-- Heart Rate -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Heart Rate</div>
                    <button class="action-icon edit" onclick="openModal('edit-hr-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->heart_rate ?? '75') <= 100 && ($patient->vitals->heart_rate ?? '75') >= 60 ? 'vital-normal' : 'vital-warning' ?>">
                    <?= htmlspecialchars($patient->vitals->heart_rate ?? '75') ?> bpm
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->heart_rate_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: 60-100 bpm</div>
                </div>
            </div>
        </div>

        <!-- Respiratory Rate -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Respiratory Rate</div>
                    <button class="action-icon edit" onclick="openModal('edit-rr-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->respiratory_rate ?? '16') <= 20 && ($patient->vitals->respiratory_rate ?? '16') >= 12 ? 'vital-normal' : 'vital-warning' ?>">
                    <?= htmlspecialchars($patient->vitals->respiratory_rate ?? '16') ?> breaths/min
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->respiratory_rate_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: 12-20 breaths/min</div>
                </div>
            </div>
        </div>

        <!-- Oxygen Saturation -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Oxygen Saturation</div>
                    <button class="action-icon edit" onclick="openModal('edit-o2-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->oxygen_saturation ?? '98') >= 95 ? 'vital-normal' : 'vital-danger' ?>">
                    <?= htmlspecialchars($patient->vitals->oxygen_saturation ?? '98') ?>%
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->oxygen_saturation_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: ≥ 95%</div>
                </div>
            </div>
        </div>

        <!-- Glucose Level -->
        <div class="col-span-4">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Glucose Level</div>
                    <button class="action-icon edit" onclick="openModal('edit-glucose-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div
                    class="vital-value <?= ($patient->vitals->glucose_level ?? '90') <= 140 && ($patient->vitals->glucose_level ?? '90') >= 70 ? 'vital-normal' : 'vital-warning' ?>">
                    <?= htmlspecialchars($patient->vitals->glucose_level ?? '90') ?> mg/dL
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->glucose_date ?? 'now')) ?></span>
                    </div>
                    <div>Normal: 70-140 mg/dL</div>
                </div>
            </div>
        </div>

        <!-- Weight -->
        <div class="col-span-6">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Weight</div>
                    <button class="action-icon edit" onclick="openModal('edit-weight-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value">
                    <?= htmlspecialchars($patient->vitals->weight ?? '70') ?> kg
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->weight_date ?? 'now')) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Height -->
        <div class="col-span-6">
            <div class="vital-card">
                <div class="vital-header">
                    <div class="vital-title">Height</div>
                    <button class="action-icon edit" onclick="openModal('edit-height-modal')">
                        <i class="bx bx-edit"></i>
                    </button>
                </div>
                <div class="vital-value">
                    <?= htmlspecialchars($patient->vitals->height ?? '170') ?> cm
                </div>
                <div class="vital-meta">
                    <div class="vital-date">
                        <i class="bx bx-calendar"></i>
                        <span><?= date('M d, Y h:i A', strtotime($patient->vitals->height_date ?? 'now')) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>