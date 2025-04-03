window.cancelAppointment = (appointmentId) => {
    const modal = document.getElementById("cancellationModal")
    const modalContent = document.getElementById("modalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("appointmentId").value = appointmentId

    // Reset the form
    document.getElementById("cancellationForm").reset()

    // Enable/disable the confirm button based on selection
    updateConfirmButton()

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
    const modal = document.getElementById("cancellationModal")
    const modalContent = document.getElementById("modalContent")
    if (!modal || !modalContent) return // Exit if modal doesn't exist

    const closeBtn = document.getElementById("closeModal")
    const cancelBtn = document.getElementById("cancelModalBtn")
    const form = document.getElementById("cancellationForm")
    const confirmBtn = document.getElementById("confirmCancelBtn")
    const reasonInputs = form.querySelectorAll('input[name="cancellation_reason"]')

    // Helper function for the cancel button
    function updateConfirmButton() {
        const confirmBtn = document.getElementById("confirmCancelBtn")
        const reasonInputs = document.querySelectorAll('input[name="cancellation_reason"]')

        let isReasonSelected = false
        reasonInputs.forEach((input) => {
            if (input.checked) {
                isReasonSelected = true
            }
        })

        confirmBtn.disabled = !isReasonSelected

        // Update button styling based on state
        if (isReasonSelected) {
            confirmBtn.classList.remove("opacity-50", "cursor-not-allowed")
        } else {
            confirmBtn.classList.add("opacity-50", "cursor-not-allowed")
        }
    }

    // Function to close the modal with smooth animation
    function closeModal() {
        // Animate out
        modalContent.classList.remove("scale-100", "opacity-100")
        modalContent.classList.add("scale-95", "opacity-0")
        modal.classList.remove("opacity-100")

        // Wait for animation to complete
        setTimeout(() => {
            modal.classList.remove("flex")
            modal.classList.add("hidden")

            // Restore body scrolling
            document.body.style.overflow = ""
        }, 300)
    }

    // Close the modal when clicking the close button
    closeBtn.addEventListener("click", closeModal)

    // Close the modal when clicking the cancel button
    cancelBtn.addEventListener("click", closeModal)

    // Close the modal when clicking outside of it
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeModal()
        }
    })

    // Add event listeners to radio buttons
    reasonInputs.forEach((input) => {
        input.addEventListener("change", updateConfirmButton)
    })

    // Handle form submission
    confirmBtn.addEventListener("click", () => {
        const appointmentId = document.getElementById("appointmentId").value
        let reason = ""
        reasonInputs.forEach((input) => {
            if (input.checked) {
                reason = input.value
            }
        })
        const details = document.getElementById("cancellation_details").value
        const sendCancellation = document.getElementById("send_cancellation").checked

        // Show loading state
        confirmBtn.disabled = true
        confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...'

        // Get the BASE_URL from the HTML
        // We'll look for a meta tag with name="base-url" or data attribute
        let baseUrl = ""
        const baseUrlMeta = document.querySelector('meta[name="base-url"]')
        if (baseUrlMeta) {
            baseUrl = baseUrlMeta.getAttribute("content")
        } else {
            // Fallback: try to get it from the script tag
            const scriptTags = document.querySelectorAll("script")
            for (const script of scriptTags) {
                const src = script.getAttribute("src")
                if (src && src.includes("/js/receptionist/reception.js")) {
                    baseUrl = src.split("/js/receptionist/reception.js")[0]
                    break
                }
            }
        }

        // Log what we're sending for debugging
        console.log("Sending cancellation request:")
        console.log("Base URL:", baseUrl)
        console.log("URL:", baseUrl + "/receptionist/cancel-appointment")
        console.log("Data:", {
            appointmentId: appointmentId,
            reason: reason,
            details: details,
            send_cancellation: sendCancellation
        })

        // Send AJAX request to cancel the appointment
        fetch(baseUrl + "/receptionist/cancel-appointment", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: JSON.stringify({
                appointmentId: appointmentId,
                reason: reason,
                details: details,
                send_cancellation: sendCancellation
            }),
        })
            .then((response) => {
                console.log("Response status:", response.status)
                console.log("Response headers:", response.headers)

                // Check if response is ok before trying to parse JSON
                if (!response.ok) {
                    throw new Error("Network response was not ok: " + response.status)
                }

                // Get the raw text first for debugging
                return response.text().then((text) => {
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
            .then((data) => {
                console.log("Parsed response:", data)

                if (data.success) {
                    // Close the modal
                    closeModal()

                    // Update the UI to reflect the cancelled appointment
                    const appointmentElement = document.querySelector(`[data-patient="patient-${appointmentId}"]`)
                    if (appointmentElement) {
                        const statusBadge = appointmentElement.querySelector(".status-badge")
                        if (statusBadge) {
                            statusBadge.className = "status-badge cancelled"
                            statusBadge.innerHTML = '<i class="bx bx-x-circle mr-1"></i><span class="text-xs">Cancelled</span>'
                        }
                    }

                    // Show success toast instead of alert
                    showToast('success', 'Appointment Cancelled', 'The appointment has been cancelled successfully.')

                    // Reload the page to reflect changes
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                } else {
                    // Show error toast instead of alert
                    showToast('error', 'Cancellation Failed', data.message || 'Failed to cancel appointment.')
                }
            })
            .catch((error) => {
                console.error("Error:", error)
                showToast('error', 'Error', 'An unexpected error occurred. Please try again.')
            })
            .finally(() => {
                // Reset button state
                confirmBtn.disabled = false
                confirmBtn.innerHTML = "Confirm Cancellation"
            })
    })
})

// Move showToast function outside as a global function
window.showToast = (type, title, message) => {
    const toast = document.createElement('div')
    toast.className = `fixed top-4 right-4 z-50 flex items-start p-4 mb-4 w-full max-w-xs rounded-lg shadow-lg ${type === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'} fade-in`

    toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-500'}">
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
