
document.addEventListener('DOMContentLoaded', function() {
    // Add toast container if not exists
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-50';
        document.body.appendChild(toastContainer);
    }

    // Modal elements for both modals
    const savePrescriptionModal = document.getElementById('savePrescriptionModal');
    const emailPrescriptionModal = document.getElementById('emailPrescriptionModal');
    const savePrescriptionContent = document.getElementById('savePrescriptionModalContent');
    const emailPrescriptionContent = document.getElementById('emailPrescriptionModalContent');

    function showModal(modal, content) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function hideModal(modal, content) {
        if (!modal || !content) return;
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    // Save Prescription functionality
    window.savePrescription = function() {
        showModal(savePrescriptionModal, savePrescriptionContent);
    };

    // Close button (X) handler for save modal
    document.getElementById('closeSavePrescriptionModal').addEventListener('click', () => {
        hideModal(savePrescriptionModal, savePrescriptionContent);
    });

    // Cancel button handler for save modal
    document.getElementById('cancelSavePrescriptionBtn').addEventListener('click', () => {
        hideModal(savePrescriptionModal, savePrescriptionContent);
    });

    // Confirm save button handler
    document.getElementById('confirmSavePrescriptionBtn').addEventListener('click', () => {
        hideModal(savePrescriptionModal, savePrescriptionContent);
        proceedWithSave();
    });

    // Email Prescription functionality
    window.emailPrescription = function() {
        showModal(emailPrescriptionModal, emailPrescriptionContent);
    };

    // Close button (X) handler for email modal
    document.getElementById('closeEmailPrescriptionModal').addEventListener('click', () => {
        hideModal(emailPrescriptionModal, emailPrescriptionContent);
    });

    // Cancel button handler for email modal
    document.getElementById('cancelEmailPrescriptionBtn').addEventListener('click', () => {
        hideModal(emailPrescriptionModal, emailPrescriptionContent);
    });

    // Confirm email button handler
    document.getElementById('confirmEmailPrescriptionBtn').addEventListener('click', () => {
        hideModal(emailPrescriptionModal, emailPrescriptionContent);
        proceedWithEmail();
    });

    function proceedWithEmail() {
        const element = document.querySelector('.print-container');
        try {
            const prescriptionData = JSON.parse(document.getElementById('prescription-data').value);
            const includeInstructions = document.getElementById('include_instructions').checked;
            const additionalMessage = document.getElementById('email_message').value;
            
            html2canvas(element).then(canvas => {
                const imageData = canvas.toDataURL('image/png');
                
                return fetch(`${BASE_URL}/doctor/email-prescription`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        patientId: prescriptionData.patientId,
                        prescriptionImage: imageData,
                        includeInstructions,
                        additionalMessage
                    })
                });
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Success', 'Prescription has been emailed to the patient.');
                } else {
                    throw new Error(data.message || 'Failed to send email');
                }
            })
            .catch(error => {
                console.error('Email error:', error);
                showToast('error', 'Error', error.message || 'Failed to send email. Please try again.');
            });
        } catch (error) {
            console.error('Prescription data parsing error:', error);
            showToast('error', 'Error', 'Invalid prescription data');
        }
    }

    function proceedWithSave() {
        const element = document.querySelector('.print-container');
        if (!element) {
            showToast('error', 'Error', 'Print container not found');
            return;
        }
    
        // Get prescription data from the hidden input
        const prescriptionDataElement = document.getElementById('prescription-data');
        const prescriptionData = JSON.parse(prescriptionDataElement.value);
    
        // Format the follow-up date
        let followUpDate = prescriptionData.followUpDate || document.querySelector('.followup-date')?.textContent.trim() || '';
        if (followUpDate) {
            // Convert the date to YYYY-MM-DD format
            const dateObj = new Date(followUpDate);
            if (dateObj instanceof Date && !isNaN(dateObj)) {
                followUpDate = dateObj.toISOString().split('T')[0];
            }
        }
    
        // Prepare prescription data
        const data = {
            patientId: prescriptionData.patientId,
            medications: Array.from(document.querySelectorAll('tr')).slice(1).map(row => ({
                medicine_name: row.cells[0].textContent.replace(/^\d+\)\s*/, '').trim(),
                dosage: row.cells[1].textContent.trim(),
                duration: row.cells[2].textContent.trim(),
                special_instructions: row.cells[3]?.textContent.trim() || ''
            })).filter(med => med.medicine_name),
            advice: prescriptionData.advice || document.querySelector('.advice-text')?.textContent.trim() || '',
            followUpDate: followUpDate,
            vitalsId: prescriptionData.vitalsId || document.querySelector('[name="vitals_id"]')?.value || null,
            diagnosis: prescriptionData.diagnosis || ''
        };

        // Rest of the save functionality remains the same
        fetch(`${BASE_URL}/doctor/save-prescription`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Server response:', text);
                throw new Error('Server returned an invalid response');
            }
            
            if (data.success) {
                showToast('success', 'Success', 'Prescription has been saved successfully.');
                setTimeout(() => {
                    window.location.href = `${BASE_URL}/doctor/patientView?id=${prescriptionData.patientId}`;
                }, 2000);
            } else {
                throw new Error(data.message || 'Failed to save prescription');
            }
        })
        .catch(error => {
            console.error('Prescription save error:', error);
            showToast('error', 'Error', error.message || 'An error occurred while saving the prescription');
        });
    }
});

// The showToast function remains unchanged
window.downloadPrescription = function() {
    const element = document.querySelector('.print-container');
    const prescriptionData = JSON.parse(document.getElementById('prescription-data').value);
    
    html2canvas(element).then(canvas => {
        const link = document.createElement('a');
        link.download = `prescription-${prescriptionData.patientId}.png`;
        link.href = canvas.toDataURL();
        link.click();
    });
};

function showToast(type, title, message, containerId = 'toast-container') {
    let toastContainer = document.getElementById(containerId);
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = containerId;
        toastContainer.className = 'fixed top-4 right-4 z-50';
        document.body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    toast.className = `flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow`;

    if (type === 'success') {
        toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <i class="bx bx-check text-xl"></i>
            </div>
            <div class="ml-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                <div class="mb-2 text-sm">${message}</div>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" aria-label="Close">
                <i class="bx bx-x text-lg"></i>
            </button>
        `;
    } else {
        toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <i class="bx bx-x text-xl"></i>
            </div>
            <div class="ml-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900">${title}</span>
                <div class="mb-2 text-sm">${message}</div>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" aria-label="Close">
                <i class="bx bx-x text-lg"></i>
            </button>
        `;
    }

    toastContainer.appendChild(toast);

    toast.querySelector('button').addEventListener('click', () => {
        toast.remove();
    });

    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.remove();
        }
    }, 5000);
}
