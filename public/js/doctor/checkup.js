
// Tab functionality
document.addEventListener('DOMContentLoaded', function () {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    // Set initial active tab
    if (tabButtons.length > 0 && tabContents.length > 0) {
        tabButtons[0].classList.add('active');
        tabContents[0].classList.add('active');
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');

            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to current button and content
            this.classList.add('active');
            const targetTab = document.getElementById(`${tabId}-tab`);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });
});

// Modal functionality
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// Close modals when clicking outside
window.addEventListener('click', function (event) {
    document.querySelectorAll('.modal.active').forEach(modal => {
        if (event.target === modal) {
            modal.classList.remove('active');
        }
    });
});

// Medication functions
function editMedication(id) {
    // Implement edit functionality
    alert('Edit medication with ID: ' + id);
    // In a real implementation, you would fetch the medication data and populate a form
}

function deleteMedication(id) {
    if (confirm('Are you sure you want to delete this medication?')) {
        // Implement delete functionality
        window.location.href = '<?= BASE_URL ?>/doctor/deleteMedication/' + id;
    }
}

// Diagnosis functions
function editDiagnosis(id) {
    // Implement edit functionality
    alert('Edit diagnosis with ID: ' + id);
    // In a real implementation, you would fetch the diagnosis data and populate a form
}

function deleteDiagnosis(id) {
    if (confirm('Are you sure you want to delete this diagnosis?')) {
        // Implement delete functionality
        window.location.href = '<?= BASE_URL ?>/doctor/deleteDiagnosis/' + id;
    }
}
