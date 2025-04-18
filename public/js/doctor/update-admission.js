document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('updateStatusModal');
    const modalContent = document.getElementById('updateStatusModalContent');
    const openModalBtn = document.getElementById('updateStatusBtn');
    const closeModalBtn = document.getElementById('closeStatusModal');
    const cancelBtn = document.getElementById('cancelStatusBtn');
    const statusSelect = document.getElementById('status');
    const dischargeDateContainer = document.getElementById('dischargeDateContainer');
    const updateStatusForm = document.getElementById('updateStatusForm');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    statusSelect.addEventListener('change', function () {
        const dateLabel = document.getElementById('dateLabel');
        const referralContainer = document.getElementById('referralContainer');
        const transferContainer = document.getElementById('transferContainer');

        dischargeDateContainer.classList.add('hidden');
        referralContainer.classList.add('hidden');
        transferContainer.classList.add('hidden');

        switch (this.value) {
            case 'discharged':
                dischargeDateContainer.classList.remove('hidden');
                dateLabel.textContent = 'Discharge Date';
                break;
            case 'referred':
                dischargeDateContainer.classList.remove('hidden');
                referralContainer.classList.remove('hidden');
                dateLabel.textContent = 'Referral Date';
                break;
            case 'transferred':
                dischargeDateContainer.classList.remove('hidden');
                transferContainer.classList.remove('hidden');
                dateLabel.textContent = 'Transfer Date';
                break;
        }
    });

    openModalBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    updateStatusForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(updateStatusForm);
        const saveBtn = document.getElementById('saveStatusBtn');
        const originalBtnText = saveBtn.innerHTML;
        
        saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
        saveBtn.disabled = true;

        fetch('/doctor/updateAdmissionStatus', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', 'Status Updated', 'Admission status has been updated successfully!');
                closeModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            showToast('error', 'Error', error.message || 'An unexpected error occurred');
            saveBtn.innerHTML = originalBtnText;
            saveBtn.disabled = false;
        });
    });

    function showToast(type, title, message) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow`;
        
        toast.innerHTML = type === 'success' 
            ? `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <i class="bx bx-check text-xl"></i>
               </div>`
            : `<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <i class="bx bx-x text-xl"></i>
               </div>`;
        
        toast.innerHTML += `
            <div class="ml-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                <div class="mb-2 text-sm">${message}</div>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8">
                <i class="bx bx-x text-lg"></i>
            </button>`;

        document.body.appendChild(toast);
        
        toast.querySelector('button').addEventListener('click', () => toast.remove());
        setTimeout(() => toast.remove(), 5000);
    }
});
