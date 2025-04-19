<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
    <div class="card-header">
        <div>
            <h3 class="card-title">Allergies</h3>
            <p class="card-subtitle">Record patient's allergies</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('add-allergies-modal')">
            <i class="bx bx-plus"></i>
            Record Allergy
        </button>
    </div>

    <div id="allergies-container" class="grid grid-cols-12 gap-4">
        <div class="col-span-12 text-center py-6 text-gray-500" id="no-allergies-message">
            No allergies recorded yet.
        </div>
    </div>

    <div class="add-item-btn mt-4" onclick="openModal('add-allergies-modal')">
        <i class="bx bx-plus"></i>
        Add New Allergy
    </div>

    <div id="allergies-toast-container" class="fixed top-4 right-4 z-50"></div>
</div>

