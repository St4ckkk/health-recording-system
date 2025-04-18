<style>
    /* Symptom card styles */
    .symptom-card {
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .symptom-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .symptom-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .symptom-title {
        font-weight: 600;
        font-size: 1.125rem;
        color: #111827;
    }

    .symptom-actions {
        display: flex;
        gap: 0.5rem;
    }

    .symptom-actions .action-icon {
        background: none;
        border: none;
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s ease;
    }

    .symptom-actions .action-icon:hover {
        color: #111827;
    }

    .symptom-actions .action-icon.edit:hover {
        color: #3b82f6;
    }

    .symptom-actions .action-icon.delete:hover {
        color: #ef4444;
    }

    .symptom-severity {
        margin-bottom: 0.75rem;
    }

    .severity-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .symptom-description {
        color: #4b5563;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .symptom-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .symptom-date {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
    <div class="card-header">
        <div>
            <h3 class="card-title">Symptoms</h3>
            <p class="card-subtitle">Record patient's symptoms</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('add-symptoms-modal')">
            <i class="bx bx-plus"></i>
            Record Symptoms
        </button>
    </div>

    <div id="symptoms-container" class="grid grid-cols-12 gap-4">
        <div class="col-span-12 text-center py-6 text-gray-500" id="no-symptoms-message">
            No symptoms recorded yet.
        </div>
    </div>

    <!-- Toast container for symptoms notifications -->
    <div id="symptoms-toast-container" class="fixed top-4 right-4 z-50"></div>
</div>