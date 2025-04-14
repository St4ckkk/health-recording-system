// Dispense modal functions
function openDispenseModal(medicineId, medicineName) {
    document.getElementById('medicineId').value = medicineId;
    document.getElementById('medicineName').value = medicineName;
    document.getElementById('dispenseModal').classList.remove('hidden');
}

function closeDispenseModal() {
    document.getElementById('dispenseForm').reset();
    document.getElementById('dispenseModal').classList.add('hidden');
}

// Add Medicine Modal Functions
function openAddMedicineModal() {
    const modal = document.getElementById('addMedicineModal');
    const modalContent = document.getElementById('addMedicineModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}


document.querySelector('.add-medicine-btn').onclick = function (e) {
    e.preventDefault();
    openAddMedicineModal();
};

document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners for modal controls
    document.getElementById('closeAddMedicineModal').addEventListener('click', closeAddMedicineModal);
    document.getElementById('cancelAddMedicineBtn').addEventListener('click', closeAddMedicineModal);

    // Handle form submission
    document.getElementById('addMedicineForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        fetch(`${BASE_URL}/pharmacist/addMedicine`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('success', 'Success', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    console.error('Server Error:', data);
                    showToast('error', 'Error', data.message || 'Failed to add medicine');
                }
            })
            .catch(error => {
                console.error('Fetch Error:', {
                    message: error.message,
                    error: error,
                    requestData: data
                });
                showToast('error', 'Error', `Failed to add medicine: ${error.message}`);
            });
    });
});

// Add Toast notification function
window.showToast = (type, title, message) => {
    const toast = document.createElement('div')
    toast.className = `fixed top-4 right-4 z-50 flex items-start p-4 mb-4 w-full max-w-xs rounded-lg shadow-lg ${type === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'} fade-in`

    toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-800'}">
            <i class="bx ${type === 'success' ? 'bx-check' : 'bx-x'} text-xl"></i>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="mb-1 text-sm font-semibold">${title}</span>
            <div class="mb-2 text-sm">${message}</div>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ${type === 'success' ? 'text-green-500 hover:bg-green-100' : 'text-red-500 hover:bg-red-100'}" aria-label="Close">
            <i class="bx bx-x text-lg"></i>
        </button>
    `

    document.body.appendChild(toast)

    // Add click event to close button
    toast.querySelector('button').addEventListener('click', () => {
        toast.remove()
    })

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.classList.add('fade-out')
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.remove()
                }
            }, 300)
        }
    }, 5000)
}

// Add event listener for expiry date to prevent past dates
document.getElementById('expiryDate').addEventListener('change', function () {
    const selectedDate = new Date(this.value);
    const today = new Date();

    if (selectedDate < today) {
        alert('Expiry date cannot be in the past');
        this.value = '';
    }
});

function closeAddMedicineModal() {
    const modal = document.getElementById('addMedicineModal');
    const modalContent = document.getElementById('addMedicineModalContent');
    const form = document.getElementById('addMedicineForm');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        form.reset();
    }, 300);
}
