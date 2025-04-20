function openEditModal(medicine) {
    const modal = document.getElementById('editMedicineModal');
    const modalContent = document.getElementById('editMedicineModalContent');

    // Populate form fields with medicine data
    document.getElementById('editMedicineId').value = medicine.id;
    document.getElementById('editMedicineName').value = medicine.name;
    document.getElementById('editCategory').value = medicine.category;
    document.getElementById('editForm').value = medicine.form;
    document.getElementById('editDosage').value = medicine.dosage;
    document.getElementById('editStockLevel').value = medicine.stock_level;
    document.getElementById('editExpiryDate').value = medicine.expiry_date;
    document.getElementById('editManufacturer').value = medicine.manufacturer;
    document.getElementById('editSupplier').value = medicine.supplier;
    const editUnitPrice = document.getElementById('editUnitPrice');
    editUnitPrice.value = medicine.unit_price;
    editUnitPrice.setAttribute('data-original-price', medicine.unit_price);

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editMedicineModal');
    const modalContent = document.getElementById('editMedicineModalContent');
    const form = document.getElementById('editMedicineForm');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        form.reset();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners for modal controls
    document.getElementById('closeEditMedicineModal').addEventListener('click', closeEditModal);
    document.getElementById('cancelEditMedicineBtn').addEventListener('click', closeEditModal);

    // Handle edit form submission
    // In the form submission handler
    document.getElementById('editMedicineForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = {
            medicineId: formData.get('medicineId'),
            medicineName: formData.get('medicineName'),
            category: formData.get('category'),
            form: formData.get('form'),
            dosage: formData.get('dosage'),
            stockLevel: parseInt(formData.get('stockLevel')),
            expiryDate: formData.get('expiryDate'),
            supplier: formData.get('supplier'),
            unitPrice: parseFloat(formData.get('unitPrice')), // Changed to parseFloat
            manufacturer: formData.get('manufacturer'),
            currentUnitPrice: parseFloat(document.getElementById('editUnitPrice').getAttribute('data-original-price')) // Add original price tracking
        };

        // Validate unit price
        if (isNaN(data.unitPrice)) {
            showToast('error', 'Error', 'Invalid unit price');
            return;
        }

        fetch(`${BASE_URL}/pharmacist/updateMedicine`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
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
                    showToast('error', 'Error', data.message || 'Failed to update medicine');
                }
            })
            .catch(error => {
                console.error('Update Error:', error);
                showToast('error', 'Error', error.message);
            });
    });

    // Close modal when clicking outside
    document.getElementById('editMedicineModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Prevent past dates in expiry date field
    document.getElementById('editExpiryDate').addEventListener('change', function () {
        const selectedDate = new Date(this.value);
        const today = new Date();

        if (selectedDate < today) {
            alert('Expiry date cannot be in the past');
            this.value = '';
        }
    });
});