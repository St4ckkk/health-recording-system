document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('updateTreatmentModal');
    const modalContent = document.getElementById('updateTreatmentModalContent');
    const openModalBtn = document.getElementById('updateTreatment');
    const closeModalBtn = document.getElementById('closeTreatmentModal');
    const cancelBtn = document.getElementById('cancelTreatmentBtn');
    const updateTreatmentForm = document.getElementById('updateTreatmentForm');

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

    if (openModalBtn) openModalBtn.addEventListener('click', openModal);
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    updateTreatmentForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const saveBtn = document.querySelector('button[type="submit"]');
        const originalBtnText = saveBtn.innerHTML;

        try {
            // Validate dates
            const startDate = new Date(formData.get('start_date'));
            const endDate = formData.get('end_date') ? new Date(formData.get('end_date')) : null;

            if (endDate && endDate < startDate) {
                showToast('error', 'Validation Error', 'End date cannot be earlier than start date');
                return;
            }

            // Show loading state
            saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
            saveBtn.disabled = true;

            const response = await fetch('/doctor/updateTreatment', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                showToast('success', 'Success', data.message || 'Treatment updated successfully');
                closeModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                throw new Error(data.message || 'Failed to update treatment');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('error', 'Error', error.message || 'An unexpected error occurred');
        } finally {
            saveBtn.innerHTML = originalBtnText;
            saveBtn.disabled = false;
        }
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