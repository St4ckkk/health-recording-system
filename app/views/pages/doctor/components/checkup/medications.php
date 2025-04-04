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

    <!-- Medications Grid Container -->
    <div class="medications-grid grid grid-cols-12 gap-4 mt-4" id="medications-container">
        <?php if (!empty($medications)): ?>
            <?php foreach ($medications as $medication): ?>
                <div class="col-span-4">
                    <div class="medication-card">
                        <div class="medication-header">
                            <div class="medication-title"><?= htmlspecialchars($medication->medicine_name) ?></div>
                            <div class="medication-actions">
                                <button class="action-icon edit" onclick="editMedication(<?= $medication->id ?>)">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="action-icon delete" onclick="deleteMedication(<?= $medication->id ?>)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="medication-details">
                            <div class="medication-dosage">
                                <i class="bx bx-capsule"></i>
                                <span><?= htmlspecialchars($medication->dosage) ?></span>
                            </div>
                            <div class="medication-frequency">
                                <i class="bx bx-time"></i>
                                <span><?= htmlspecialchars($medication->frequency) ?></span>
                            </div>
                            <?php if (!empty($medication->purpose)): ?>
                                <div class="medication-purpose">
                                    <i class="bx bx-info-circle"></i>
                                    <span><?= htmlspecialchars($medication->purpose) ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($medication->start_date)): ?>
                                <div class="medication-date">
                                    <i class="bx bx-calendar"></i>
                                    <span>Started: <?= date('M d, Y', strtotime($medication->start_date)) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-12 text-center py-6 text-gray-500" id="no-medications-message">
                No medications prescribed yet.
            </div>
        <?php endif; ?>
    </div>

    <div class="add-item-btn mt-4" onclick="openModal('add-medication-modal')">
        <i class="bx bx-plus"></i>
        Add New Medication
    </div>
</div>

<!-- Toast Container for Medications -->
<div id="medications-toast-container" class="fixed top-4 right-4 z-50"></div>

<script>
    // Load saved medications from localStorage on page load
    document.addEventListener('DOMContentLoaded', function () {
        loadSavedMedications();
    });
</script>