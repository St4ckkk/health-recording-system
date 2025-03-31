document.addEventListener("DOMContentLoaded", () => {
    setupStartAppointmentFunctionality();
});


function setupStartAppointmentFunctionality() {
    const startAppointmentBtns = document.querySelectorAll("[onclick^='startAppointment']");

    startAppointmentBtns.forEach(btn => {
        const originalOnClick = btn.getAttribute("onclick");
        const appointmentId = originalOnClick.match(/\d+/)[0];

        btn.setAttribute("onclick", `startAppointmentProcess(${appointmentId})`);
    });
}

// Start appointment process
window.startAppointmentProcess = (appointmentId) => {
    if (!appointmentId) return;

    // Create form data
    const formData = new FormData();
    formData.append("appointmentId", appointmentId);

    // Use window.BASE_URL if defined, otherwise fallback to empty string
    const baseUrl = window.BASE_URL || '';

    // Send AJAX request to the dedicated start appointment endpoint
    fetch(`${baseUrl}/receptionist/start-appointment`, {
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
                // Show success message
                showToast('success', 'Success', 'Appointment started successfully');

                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Show error message
                showToast('error', 'Error', data.message || "Failed to start appointment");
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