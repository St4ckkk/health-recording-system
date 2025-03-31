// Complete appointment process
window.completeAppointment = (appointmentId) => {
    if (!appointmentId) return;

    const modal = document.getElementById("completedModal");
    const modalContent = document.getElementById("completedModalContent");

    if (!modal || !modalContent) return;

    // Set the appointment ID in the hidden field
    document.getElementById("completedAppointmentId").value = appointmentId;

    // Reset the form
    document.getElementById("completedForm").reset();
    document.getElementById("followUpDetails").classList.add("hidden");

    // Show the modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Animate in
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);

    // Prevent body scrolling
    document.body.style.overflow = "hidden";
};

document.addEventListener("DOMContentLoaded", () => {
    // Completed Modal Functionality
    const completedModal = document.getElementById("completedModal");
    const completedModalContent = document.getElementById("completedModalContent");
    const closeCompletedModal = document.getElementById("closeCompletedModal");
    const cancelCompletedBtn = document.getElementById("cancelCompletedBtn");
    const confirmCompletedBtn = document.getElementById("confirmCompletedBtn");
    const completedForm = document.getElementById("completedForm");
    const scheduleFollowUp = document.getElementById("scheduleFollowUp");
    const followUpDetails = document.getElementById("followUpDetails");

    // Initialize date and time pickers if they exist
    if (typeof flatpickr !== 'undefined') {
        flatpickr("#followUpDate", {
            dateFormat: "Y-m-d",
            minDate: "today",
            disableMobile: "true"
        });

        flatpickr("#followUpTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
            minuteIncrement: 15,
            disableMobile: "true"
        });
    }

    // Toggle follow-up details section
    if (scheduleFollowUp) {
        scheduleFollowUp.addEventListener("change", () => {
            if (scheduleFollowUp.checked) {
                followUpDetails.classList.remove("hidden");
            } else {
                followUpDetails.classList.add("hidden");
            }
        });
    }

    // Close modal functions
    const closeCompletedModalFunction = () => {
        if (!completedModal || !completedModalContent) return;

        // Animate out
        completedModalContent.classList.remove("scale-100", "opacity-100");
        completedModalContent.classList.add("scale-95", "opacity-0");

        // Hide after animation
        setTimeout(() => {
            completedModal.classList.remove("flex");
            completedModal.classList.add("hidden");
            document.body.style.overflow = "auto"; // Re-enable scrolling
        }, 300);
    };

    // Add event listeners for closing the modal
    if (closeCompletedModal) {
        closeCompletedModal.addEventListener("click", closeCompletedModalFunction);
    }

    if (cancelCompletedBtn) {
        cancelCompletedBtn.addEventListener("click", closeCompletedModalFunction);
    }

    // Handle form submission
    if (confirmCompletedBtn) {
        confirmCompletedBtn.addEventListener("click", () => {
            const appointmentId = document.getElementById("completedAppointmentId").value;
            const needsFollowUp = scheduleFollowUp.checked;

            console.log('Completing appointment:', appointmentId);
            console.log('Follow-up needed:', needsFollowUp);

            // Show loading state
            confirmCompletedBtn.disabled = true;
            confirmCompletedBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Processing...';

            // Create form data
            const formData = new FormData(completedForm);

            // Log form data for debugging
            console.log('Form data for completion:', [...formData.entries()]);

            // Use window.BASE_URL if defined, otherwise fallback to empty string
            const baseUrl = window.BASE_URL || '';

            // Send AJAX request to the dedicated complete appointment endpoint
            fetch(`${baseUrl}/receptionist/complete-appointment`, {
                method: "POST",
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(async response => {
                    console.log('Complete appointment API response status:', response.status);
                    if (!response.ok) {
                        const text = await response.text();
                        console.error("Error response from complete API:", text);
                        throw new Error(text);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Complete appointment API response:', data);
                    if (data.success) {
                        // Close the modal
                        closeCompletedModalFunction();

                        // Show success message
                        showToast('success', 'Success', 'Appointment completed successfully');

                        // If follow-up is needed, schedule it
                        if (needsFollowUp) {
                            console.log('Proceeding to schedule follow-up...');
                            scheduleFollowUpAppointment(formData);
                        } else {
                            console.log('No follow-up needed, reloading page...');
                            // Reload the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    } else {
                        console.error('Appointment completion failed:', data.message);
                        // Show error message
                        showToast('error', 'Error', data.message || "Failed to complete appointment");
                    }
                })
                .catch(error => {
                    console.error("Error in appointment completion:", error);
                    showToast('error', 'Error', "An error occurred. Please try again.");
                })
                .finally(() => {
                    // Reset button state
                    confirmCompletedBtn.disabled = false;
                    confirmCompletedBtn.innerHTML = 'Complete Appointment';
                });
        });
    }
});

// Function to schedule a follow-up appointment
function scheduleFollowUpAppointment(formData) {
    const baseUrl = window.BASE_URL || '';

    // Show loading toast for follow-up scheduling with a more distinct processing style
    showToast('processing', 'Processing', 'Scheduling follow-up appointment...', true);

    console.log('Starting follow-up scheduling process...');

    // More detailed logging of form data
    console.log('Form data entries:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Check for required follow-up fields
    const requiredFields = ['followUpDate', 'followUpTime', 'followUpType', 'followUpReason'];
    const missingFields = [];

    for (const field of requiredFields) {
        if (!formData.has(field) || !formData.get(field)) {
            missingFields.push(field);
            console.warn(`Missing required field for follow-up: ${field}`);
        }
    }

    if (missingFields.length > 0) {
        console.error('Follow-up scheduling may fail due to missing fields:', missingFields);
    }

    // Send AJAX request to schedule follow-up appointment
    fetch(`${baseUrl}/receptionist/schedule-follow-up`, {
        method: "POST",
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(async response => {
            console.log('Follow-up API response status:', response.status);

            // Capture the raw response text for debugging
            const rawText = await response.text();
            console.log('Raw response text:', rawText);

            // Try to parse as JSON, but handle non-JSON responses
            let jsonData;
            try {
                jsonData = JSON.parse(rawText);
                return jsonData;
            } catch (e) {
                console.error('Failed to parse response as JSON:', e);
                throw new Error('Invalid JSON response: ' + rawText);
            }
        })
        .then(data => {
            console.log('Follow-up API response data:', data);
            if (data.success) {
                console.log('Follow-up scheduled successfully with ID:', data.followUpId);
                // Show success message
                showToast('success', 'Success', 'Follow-up appointment scheduled successfully');

                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                console.error('Follow-up scheduling failed:', data.message);
                // Show error message
                showToast('error', 'Error', data.message || "Failed to schedule follow-up appointment");
            }
        })
        .catch(error => {
            console.error("Error in follow-up scheduling:", error);
            showToast('error', 'Error', "An error occurred while scheduling the follow-up.");

            // Reload the page after a delay anyway since the appointment was completed
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        });
}

// Centralized Toast notification function
window.showToast = (type, title, message, stack = false) => {
    // Remove existing toast of the same type if not stacking
    if (!stack) {
        document.querySelectorAll(`.toast-notification.toast-${type}`).forEach(t => t.remove());
    }

    const toast = document.createElement('div');
    toast.className = `fixed z-50 flex items-start p-4 mb-4 w-full max-w-xs rounded-lg shadow-lg toast-notification toast-${type} ${type === 'success' ? 'bg-green-50 text-green-800' :
        type === 'processing' ? 'bg-indigo-50 text-indigo-800' :
            type === 'info' ? 'bg-blue-50 text-blue-800' :
                'bg-red-50 text-red-800'
        } fade-in`;

    // Position toast based on existing toasts
    const existingToasts = document.querySelectorAll('.toast-notification');
    const topOffset = stack && existingToasts.length > 0
        ? (existingToasts.length * 5) + 4 // Increase offset for each toast
        : 4; // Default top position

    toast.style.top = `${topOffset}rem`;
    toast.style.right = '1rem';

    toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-500' :
            type === 'processing' ? 'bg-indigo-100 text-indigo-500' :
                type === 'info' ? 'bg-blue-100 text-blue-500' :
                    'bg-red-100 text-red-500'
        }">
            <i class="bx ${type === 'success' ? 'bx-check' :
            type === 'processing' ? 'bx-loader-alt bx-spin' :
                type === 'info' ? 'bx-info-circle' :
                    'bx-x'
        } text-xl"></i>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="mb-1 text-sm font-semibold">${title}</span>
            <div class="mb-2 text-sm">${message}</div>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ${type === 'success' ? 'text-green-500 hover:bg-green-100' :
            type === 'processing' ? 'text-indigo-500 hover:bg-indigo-100' :
                type === 'info' ? 'text-blue-500 hover:bg-blue-100' :
                    'text-red-500 hover:bg-red-100'
        }" aria-label="Close">
            <i class="bx bx-x text-lg"></i>
        </button>
    `;

    document.body.appendChild(toast);

    // Add click event to close button
    toast.querySelector('button').addEventListener('click', () => {
        removeToast(toast);
    });

    // Auto remove after 5 seconds for non-processing toasts
    // Processing toasts should remain until the process completes
    if (type !== 'processing') {
        setTimeout(() => {
            removeToast(toast);
        }, 5000);
    }

    return toast; // Return the toast element for potential future reference
};

// Helper function to remove toast with animation
function removeToast(toast) {
    if (document.body.contains(toast)) {
        toast.classList.add('fade-out');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                toast.remove();
                // Reposition remaining toasts
                repositionToasts();
            }
        }, 300);
    }
}

// Helper function to reposition toasts after one is removed
function repositionToasts() {
    const toasts = document.querySelectorAll('.toast-notification');
    toasts.forEach((toast, index) => {
        toast.style.top = `${(index * 5) + 4}rem`;
    });
}

// Function to directly schedule a follow-up appointment (for completed appointments)
window.scheduleFollowUp = (appointmentId) => {
    if (!appointmentId) return;

    const modal = document.getElementById("completedModal");
    const modalContent = document.getElementById("completedModalContent");

    if (!modal || !modalContent) return;

    // Set the appointment ID in the hidden field
    document.getElementById("completedAppointmentId").value = appointmentId;

    // Reset the form and check the follow-up checkbox
    document.getElementById("completedForm").reset();
    document.getElementById("scheduleFollowUp").checked = true;
    document.getElementById("followUpDetails").classList.remove("hidden");

    // Show the modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Animate in
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);

    // Prevent body scrolling
    document.body.style.overflow = "hidden";
};