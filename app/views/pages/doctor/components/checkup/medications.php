<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Medications</h3>
            <p class="card-subtitle">Manage patient's medications and prescriptions</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('add-medication-modal')">
            <i class="bx bx-plus"></i>
            Add Medication
        </button>
    </div>

    <?php if (!empty($medications)): ?>
        <?php foreach ($medications as $medication): ?>
            <div class="medication-item">
                <div class="medication-info">
                    <div class="medication-name"><?= htmlspecialchars($medication->medicine_name) ?></div>
                    <div class="medication-details">
                        <?= htmlspecialchars($medication->dosage) ?> - <?= htmlspecialchars($medication->frequency) ?>
                        <?php if (!empty($medication->purpose)): ?>
                            <span class="text-gray-500"> | Purpose: <?= htmlspecialchars($medication->purpose) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="medication-actions">
                    <button class="action-icon edit" onclick="editMedication(<?= $medication->id ?>)">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button class="action-icon delete" onclick="deleteMedication(<?= $medication->id ?>)">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-6 text-gray-500">
            No medications prescribed yet.
        </div>
    <?php endif; ?>

    <div class="add-item-btn mt-4" onclick="openModal('add-medication-modal')">
        <i class="bx bx-plus"></i>
        Add New Medication
    </div>
</div>