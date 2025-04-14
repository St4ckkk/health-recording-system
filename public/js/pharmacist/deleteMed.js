function openDeleteModal(medicineId, medicineName) {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    document.getElementById('deleteMedicineId').value = medicineId;
    document.getElementById('deleteMedicineName').textContent = medicineName;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners for modal controls
    document.getElementById('closeDeleteModal').addEventListener('click', closeDeleteModal);
    document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);

    // Handle delete form submission
    document.getElementById('deleteForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const medicineId = document.getElementById('deleteMedicineId').value;

        fetch(`${BASE_URL}/pharmacist/deleteMedicine`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ medicineId: medicineId })
        })
            .then(async response => {
                const text = await response.text();
                try {
                    const data = JSON.parse(text);
                    if (!response.ok) {
                        throw new Error(data.message || `HTTP error! status: ${response.status}`);
                    }
                    return data;
                } catch (e) {
                    throw new Error(`Server error: ${text}`);
                }
            })
            .then(data => {
                if (data.success) {
                    showToast('success', 'Success', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast('error', 'Error', data.message || 'Failed to delete medicine');
                }
            })
            .catch(error => {
                console.error('Delete Error:', error);
                showToast('error', 'Error', error.message);
            });
    });

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
});