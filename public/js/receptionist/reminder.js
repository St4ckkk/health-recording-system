// Define sendReminder in the global scope
window.sendReminder = (appointmentId) => {
    const modal = document.getElementById("reminderModal")
    const modalContent = document.getElementById("reminderModalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("reminderAppointmentId").value = appointmentId

    // Reset the form
    document.getElementById("reminderForm").reset()

    // Show the modal
    modal.classList.remove("hidden")
    modal.classList.add("flex")

    // Animate in
    setTimeout(() => {
        modalContent.classList.remove("scale-95", "opacity-0")
        modalContent.classList.add("scale-100", "opacity-100")
    }, 10)

    // Prevent body scrolling
    document.body.style.overflow = "hidden"
}

document.addEventListener("DOMContentLoaded", () => {
    // Reminder Modal Functionality
    const reminderModal = document.getElementById("reminderModal")
    const reminderModalContent = document.getElementById("reminderModalContent")
    const closeReminderModal = document.getElementById("closeReminderModal")
    const cancelReminderBtn = document.getElementById("cancelReminderBtn")
    const sendReminderBtn = document.getElementById("sendReminderBtn")
    const reminderForm = document.getElementById("reminderForm")

    // Close modal functions
    const closeReminderModalFunction = () => {
        if (!reminderModal || !reminderModalContent) return

        // Animate out
        reminderModalContent.classList.remove("scale-100", "opacity-100")
        reminderModalContent.classList.add("scale-95", "opacity-0")

        // Hide after animation
        setTimeout(() => {
            reminderModal.classList.remove("flex")
            reminderModal.classList.add("hidden")
            // Allow body scrolling again
            document.body.style.overflow = ""
        }, 300)
    }

    // Close on X button click
    if (closeReminderModal) {
        closeReminderModal.addEventListener("click", closeReminderModalFunction)
    }

    // Close on Cancel button click
    if (cancelReminderBtn) {
        cancelReminderBtn.addEventListener("click", closeReminderModalFunction)
    }

    // Close on outside click
    if (reminderModal) {
        reminderModal.addEventListener("click", (e) => {
            if (e.target === reminderModal) {
                closeReminderModalFunction()
            }
        })
    }

    // Handle form submission
    if (sendReminderBtn && reminderForm) {
        sendReminderBtn.addEventListener("click", () => {
            // Get form data
            const formData = new FormData(reminderForm)

            // Show loading state
            sendReminderBtn.disabled = true
            sendReminderBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Sending...'

            // Get the BASE_URL from the HTML
            let baseUrl = ""
            const baseUrlMeta = document.querySelector('meta[name="base-url"]')
            if (baseUrlMeta) {
                baseUrl = baseUrlMeta.getAttribute("content")
            } else {
                // Fallback: try to get it from the script tag
                const scriptTags = document.querySelectorAll("script")
                for (const script of scriptTags) {
                    const src = script.getAttribute("src")
                    if (src && src.includes("/js/receptionist/reminder.js")) {
                        baseUrl = src.split("/js/receptionist/reminder.js")[0]
                        break
                    }
                }
            }

            // Log what we're sending for debugging
            console.log("Sending reminder:")
            console.log("Form data:", Object.fromEntries(formData))

            // Send AJAX request
            fetch(baseUrl + "/receptionist/send-reminder", {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
                .then(response => {
                    console.log("Response status:", response.status)

                    // Check if response is ok before trying to parse JSON
                    if (!response.ok) {
                        throw new Error("Network response was not ok: " + response.status)
                    }

                    // Get the raw text first for debugging
                    return response.text().then(text => {
                        console.log("Raw response:", text)

                        try {
                            // Try to parse as JSON
                            return JSON.parse(text)
                        } catch (e) {
                            console.error("JSON parse error:", e)
                            throw new Error("Invalid JSON response: " + text)
                        }
                    })
                })
                .then(data => {
                    console.log("Parsed response:", data)

                    // Close modal
                    closeReminderModalFunction()

                    // Show toast notification
                    if (data.success) {
                        showToast('success', 'Reminder sent successfully!', 'The patient has been notified about their appointment.')
                    } else {
                        showToast('error', 'Failed to send reminder', data.message || 'Please try again later.')
                    }
                })
                .catch(error => {
                    console.error('Error:', error)
                    showToast('error', 'Failed to send reminder', 'An unexpected error occurred. Please try again.')
                })
                .finally(() => {
                    // Reset button state
                    sendReminderBtn.disabled = false
                    sendReminderBtn.innerHTML = 'Send'
                })
        })
    }

    // Toast notification function (similar to confirm.js)
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
})