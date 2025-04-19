<style>
    /* Diagnosis Card Styles */
    .diagnosis-card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .diagnosis-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .diagnosis-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 0.75rem;
    }

    .diagnosis-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #333;
    }

    .diagnosis-actions {
        display: flex;
        gap: 0.5rem;
    }

    .diagnosis-description {
        margin-bottom: 1rem;
        color: #555;
        line-height: 1.5;
    }

    .diagnosis-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #777;
    }

    .diagnosis-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .diagnosis-tag {
        background-color: #f0f4ff;
        color: #4f46e5;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .diagnosis-date {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: #777;
    }

    .diagnosis-date i {
        font-size: 1rem;
        color: #4f46e5;
    }
</style>

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

    <!-- Diagnosis Grid Container -->
    <div class="diagnosis-grid grid grid-cols-12 gap-4 mt-4" id="diagnosis-container">
        <?php if (!empty($diagnoses)): ?>
            <?php foreach ($diagnoses as $diagnosis): ?>
                <div class="col-span-6">
                    <div class="diagnosis-card">
                        <div class="diagnosis-header">
                            <div class="diagnosis-title"><?= htmlspecialchars($diagnosis->title) ?></div>
                            <div class="diagnosis-actions">
                                <button class="action-icon edit" onclick="editDiagnosis(<?= $diagnosis->id ?>)">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="action-icon delete" onclick="deleteDiagnosis(<?= $diagnosis->id ?>)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
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
                            <div class="diagnosis-date">
                                <i class="bx bx-calendar"></i>
                                <span><?= date('M d, Y', strtotime($diagnosis->created_at)) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-12 text-center py-6 text-gray-500" id="no-diagnosis-message">
                No diagnoses recorded yet.
            </div>
        <?php endif; ?>
    </div>

    <div class="add-item-btn mt-4" onclick="openModal('add-diagnosis-modal')">
        <i class="bx bx-plus"></i>
        Add New Diagnosis
    </div>
</div>

<!-- Toast Container for Diagnosis -->
<div id="diagnosis-toast-container" class="fixed top-4 right-4 z-50"></div>