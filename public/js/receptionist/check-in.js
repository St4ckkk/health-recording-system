// Check-in functionality for receptionist dashboard
document.addEventListener("DOMContentLoaded", () => {
    setupCheckInModal();
    setupStartAppointmentFunctionality();
});

function setupCheckInModal() {
    const modal = document.getElementById("checkInModal");
    const modalContent = document.getElementById("checkInModalContent");
    const closeBtn = document.getElementById("closeCheckInModal");
    const cancelBtn = document.getElementById("cancelCheckInBtn");
    const confirmBtn = document.getElementById("confirmCheckInBtn");

    if (!modal || !modalContent) return;

    // Close modal when clicking the close button
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            closeCheckInModal();
        });
    }

    // Close modal when clicking the cancel button
    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            closeCheckInModal();
        });
    }

    // Handle form submission
    if (confirmBtn) {
        confirmBtn.addEventListener("click", () => {
            submitCheckInForm();
        });
    }

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeCheckInModal();
        }
    });

    // Update current time display
    function updateCurrentTime() {
        const currentTimeElement = document.getElementById("currentCheckInTime");
        if (currentTimeElement) {
            const now = new Date();
            const formattedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            currentTimeElement.textContent = formattedTime;
        }
    }

    // Update time every second
    setInterval(updateCurrentTime, 1000);
}


// Open check-in modal
window.checkInPatient = (appointmentId) => {
    const modal = document.getElementById("checkInModal");
    const modalContent = document.getElementById("checkInModalContent");

    if (!modal || !modalContent) return;

    // Set the appointment ID in the hidden field
    document.getElementById("checkInAppointmentId").value = appointmentId;

    // Reset the form
    document.getElementById("checkInForm").reset();

    // Update current time
    const currentTimeElement = document.getElementById("currentCheckInTime");
    if (currentTimeElement) {
        const now = new Date();
        const formattedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        currentTimeElement.textContent = formattedTime;
    }

    // Show the modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Animate the modal content
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0");
        modalContent.classList.add("scale-100", "opacity-100");
    }, 10);
}

// Close check-in modal
function closeCheckInModal() {
    const modal = document.getElementById("checkInModal");
    const modalContent = document.getElementById("checkInModalContent");

    if (!modal || !modalContent) return;

    // Animate the modal content
    modalContent.classList.remove("scale-100", "opacity-100");
    modalContent.classList.add("scale-95", "opacity-0");

    // Hide the modal after animation
    setTimeout(() => {
        modal.classList.remove("flex");
        modal.classList.add("hidden");
    }, 300);
}

// Submit check-in form
function submitCheckInForm() {
    const form = document.getElementById("checkInForm");
    const appointmentId = document.getElementById("checkInAppointmentId").value;

    if (!form || !appointmentId) return;

    // Get form data
    const formData = new FormData(form);

    // Use window.BASE_URL if defined, otherwise fallback to empty string
    const baseUrl = window.BASE_URL || '';

    // Send AJAX request to the dedicated check-in endpoint
    fetch(`${baseUrl}/receptionist/check-in-patient`, {
        method: "POST",
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(async response => {
            if (!response.ok) {
                const text = await response.text();
                console.error("Error response:", text);
                throw new Error(text);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Close the modal
                closeCheckInModal();

                // Show success message using showToast instead of showNotification
                showToast('success', 'Success', 'Patient checked in successfully');

                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Show error message
                const message = data.message || "Failed to check in patient";
                showToast('error', 'Error', message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showToast('error', 'Error', "An error occurred. Please try again.");
        });
}





// Toast notification function (similar to reminder.js)
window.showToast = (type, title, message) => {
    const toast = document.createElement('div')
    toast.className = `fixed top-4 right-4 z-50 flex items-start p-4 mb-4 w-full max-w-xs rounded-lg shadow-lg ${type === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'
        } fade-in`

    toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-500'
        }">
            <i class="bx ${type === 'success' ? 'bx-check' : 'bx-x'} text-xl"></i>
        </div>
        <div class="ml-3 text-sm font-normal">
            <span class="mb-1 text-sm font-semibold">${title}</span>
            <div class="mb-2 text-sm">${message}</div>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ${type === 'success' ? 'text-green-500 hover:bg-green-100' : 'text-red-500 hover:bg-red-100'
        }" aria-label="Close">
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