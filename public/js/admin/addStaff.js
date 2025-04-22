// Add Staff Modal Functions
function openAddStaffModal() {
    const modal = document.getElementById('addStaffModal');
    const modalContent = document.getElementById('addStaffModalContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeAddStaffModal() {
    const modal = document.getElementById('addStaffModal');
    const modalContent = document.getElementById('addStaffModalContent');
    const form = document.getElementById('addStaffForm');

    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        form.reset();
        resetProfilePreview();
    }, 300);
}

function resetProfilePreview() {
    const preview = document.getElementById('profilePreview');
    const placeholder = document.getElementById('uploadPlaceholder');

    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    preview.src = `${BASE_URL}/img/default-avatar.png`;
}

function handleProfileImagePreview(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            showToast('error', 'Error', 'Image size exceeds 2MB limit');
            input.value = '';
            return;
        }

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            showToast('error', 'Error', 'Only JPG, PNG and GIF files are allowed');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            const preview = document.getElementById('profilePreview');
            const placeholder = document.getElementById('uploadPlaceholder');

            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }
}

function viewStaff(staffId) {
    // Implement view staff functionality
    console.log('View staff with ID:', staffId);
    // You can redirect to a staff details page or show a modal
}

function editStaff(staffId) {
    // Implement edit staff functionality
    console.log('Edit staff with ID:', staffId);
    // You can redirect to an edit page or show a modal with pre-filled data
}

function deleteStaff(staffId, staffName) {
    if (confirm(`Are you sure you want to delete ${staffName}?`)) {
        fetch(`${BASE_URL}/admin/deleteStaff`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ staffId: staffId })
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
                    showToast('error', 'Error', data.message || 'Failed to delete staff');
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                showToast('error', 'Error', `Failed to delete staff: ${error.message}`);
            });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Add event listener for add staff button
    const addStaffBtn = document.querySelector('.add-staff-btn');
    if (addStaffBtn) {
        addStaffBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openAddStaffModal();
        });
    }

    // Add event listeners for modal controls
    const closeModalBtn = document.getElementById('closeAddStaffModal');
    const cancelBtn = document.getElementById('cancelAddStaffBtn');

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeAddStaffModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeAddStaffModal);
    }

    // Set up profile picture selection
    const selectImageBtn = document.getElementById('selectImageBtn');
    const profilePictureInput = document.getElementById('profilePicture');

    if (selectImageBtn && profilePictureInput) {
        selectImageBtn.addEventListener('click', function () {
            profilePictureInput.click();
        });

        profilePictureInput.addEventListener('change', function () {
            handleProfileImagePreview(this);
        });
    }

    // Handle form submission
    const addStaffForm = document.getElementById('addStaffForm');
    if (addStaffForm) {
        addStaffForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate form fields
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const roleId = document.getElementById('roleId').value;

            if (!firstName) {
                showToast('error', 'Error', 'First name is required');
                return;
            }
            if (!lastName) {
                showToast('error', 'Error', 'Last name is required');
                return;
            }
            if (!email) {
                showToast('error', 'Error', 'Email is required');
                return;
            }
            if (!password) {
                showToast('error', 'Error', 'Password is required');
                return;
            }
            if (!roleId) {
                showToast('error', 'Error', 'Role is required');
                return;
            }

            // Show loading state
            const submitBtn = document.querySelector('button[type="submit"][form="addStaffForm"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Processing...';

                const formData = new FormData(this);

                // Debug form data
                console.log("Form data being sent:");
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                fetch(`${BASE_URL}/admin/addStaff`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;

                        if (data.success) {
                            showToast('success', 'Success', data.message);
                            closeAddStaffModal();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            console.error('Server Error:', data);
                            showToast('error', 'Error', data.message || 'Failed to add staff');
                        }
                    })
                    .catch(error => {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;

                        console.error('Fetch Error:', error);
                        showToast('error', 'Error', `Failed to add staff: ${error.message}`);
                    });
            } else {
                // If button not found, still submit the form
                const formData = new FormData(this);

                fetch(`${BASE_URL}/admin/addStaff`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', 'Success', data.message);
                            closeAddStaffModal();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            console.error('Server Error:', data);
                            showToast('error', 'Error', data.message || 'Failed to add staff');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        showToast('error', 'Error', `Failed to add staff: ${error.message}`);
                    });
            }
        });
    }
});

// Toast notification function
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