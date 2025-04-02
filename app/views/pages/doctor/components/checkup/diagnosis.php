<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Diagnosis</h3>
            <p class="card-subtitle">Record and manage patient's diagnoses</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('add-diagnosis-modal')">
            <i class="bx bx-plus"></i>
            Add Diagnosis
        </button>
    </div>

    <?php if (!empty($diagnoses)): ?>
        <?php foreach ($diagnoses as $diagnosis): ?>
            <div class="diagnosis-item">
                <div class="diagnosis-header">
                    <div class="diagnosis-title"><?= htmlspecialchars($diagnosis->title) ?></div>
                    <div class="diagnosis-date"><?= date('M d, Y', strtotime($diagnosis->created_at)) ?></div>
                </div>
                <div class="diagnosis-description">
                    <?= htmlspecialchars($diagnosis->description) ?>
                </div>
                <div class="diagnosis-meta">
                    <?php if (!empty($diagnosis->tags)): ?>
                        <?php foreach (explode(',', $diagnosis->tags) as $tag): ?>
                            <span class="diagnosis-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="diagnosis-actions mt-2">
                    <button class="action-icon edit" onclick="editDiagnosis(<?= $diagnosis->id ?>)">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button class="action-icon delete" onclick="deleteDiagnosis(<?= $diagnosis->id ?>)">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-6 text-gray-500">
            No diagnoses recorded yet.
        </div>
    <?php endif; ?>

    <div class="add-item-btn mt-4" onclick="openModal('add-diagnosis-modal')">
        <i class="bx bx-plus"></i>
        Add New Diagnosis
    </div>
</div>