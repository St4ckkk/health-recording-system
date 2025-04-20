function openDispenseModal(medicine) {
    const modal = document.getElementById('dispenseMedicineModal');
    const modalContent = document.getElementById('dispenseMedicineModalContent');

    // Populate form fields with medicine data
    document.getElementById('dispenseMedicineId').value = medicine.id;
    document.getElementById('dispenseMedicineName').textContent = medicine.name;
    document.getElementById('currentStock').value = medicine.stock_level;
    document.getElementById('displayCurrentStock').textContent = medicine.stock_level;

    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDispenseModal() {
    const modal = document.getElementById('dispenseMedicineModal');
    const modalContent = document.getElementById('dispenseMedicineModalContent');
    const form = document.getElementById('dispenseMedicineForm');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        form.reset();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('closeDispenseMedicineModal').addEventListener('click', closeDispenseModal);
    document.getElementById('cancelDispenseMedicineBtn').addEventListener('click', closeDispenseModal);

    document.getElementById('dispenseMedicineForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const currentStock = parseInt(formData.get('currentStock'));
        const dispenseQuantity = parseInt(formData.get('quantity'));

        if (dispenseQuantity > currentStock) {
            showToast('error', 'Error', 'Dispense quantity cannot exceed current stock');
            return;
        }

        const data = {
            medicineId: formData.get('medicineId'),
            quantity: dispenseQuantity,
            remarks: formData.get('remarks')
        };

        fetch(`${BASE_URL}/pharmacist/dispenseMedicine`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Success', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast('error', 'Error', data.message || 'Failed to dispense medicine');
                }
            })
            .catch(error => {
                console.error('Dispense Error:', error);
                showToast('error', 'Error', error.message);
            });
    });
});