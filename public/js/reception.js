// Initialize flatpickr when the DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    if (typeof flatpickr === "function") {
        flatpickr("#dateFilter", {
            dateFormat: "d/m/Y",
            allowInput: true,
            disableMobile: "true",
            altInput: true,
            altFormat: "F j, Y",
            nextArrow: '<i class="bx bx-chevron-right"></i>',
            prevArrow: '<i class="bx bx-chevron-left"></i>',
            onChange: (selectedDates, dateStr) => {
                console.log("Selected date:", dateStr)
            },
        })
    }
})

// Define cancelAppointment in the global scope
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

// Make sure other functions used by cancelAppointment are also in global scope
window.updateConfirmButton = () => {
    const confirmBtn = document.getElementById("confirmCancelBtn")
    const reasonInputs = document.querySelectorAll('input[name="cancellation_reason"]')

    let isReasonSelected = false
    reasonInputs.forEach((input) => {
        if (input.checked) {
            isReasonSelected = true
        }
    })

    confirmBtn.disabled = !isReasonSelected
}

// Make clearFilters available globally too
window.clearFilters = () => {
    document.getElementById("dateFilter").value = ""
    const dateFilterInstance = document.getElementById("dateFilter")._flatpickr
    if (dateFilterInstance) {
        dateFilterInstance.clear()
    }
    document.getElementById("typeFilter").value = ""
}

document.addEventListener("DOMContentLoaded", () => {
    // Clear filters functionality
    const clearFiltersBtn = document.querySelector('button[onclick="clearFilters()"]')
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", () => {
            document.getElementById("dateFilter").value = ""
            document.getElementById("typeFilter").selectedIndex = 0
        })
    }

    // Tab switching functionality
    const tabButtons = document.querySelectorAll(".tab-button")
    tabButtons.forEach((button) => {
        button.addEventListener("click", function () {
            tabButtons.forEach((btn) => btn.classList.remove("active"))
            this.classList.add("active")
        })
    })

    // Appointment selection functionality
    const appointmentItems = document.querySelectorAll(".appointment-item")
    const patientDetails = document.querySelectorAll(".patient-details")

    appointmentItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Remove active class from all items
            appointmentItems.forEach((i) => i.classList.remove("active"))

            // Add active class to clicked item
            this.classList.add("active")

            // Get patient identifier
            const patientId = this.getAttribute("data-patient")

            // Hide all patient details
            patientDetails.forEach((detail) => detail.classList.add("hidden"))

            // Show selected patient details
            const selectedDetails = document.getElementById(`${patientId}-details`)
            if (selectedDetails) {
                selectedDetails.classList.remove("hidden")

                // Add fade-in animation
                selectedDetails.classList.add("fade-in")

                // Remove animation class after animation completes
                setTimeout(() => {
                    selectedDetails.classList.remove("fade-in")
                }, 300)
            }
        })
    })
})

document.addEventListener("DOMContentLoaded", () => {
    // Get all appointment items
    const appointmentItems = document.querySelectorAll(".appointment-item")

    // Add click event to each appointment item
    appointmentItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Remove active class from all items
            appointmentItems.forEach((i) => i.classList.remove("active"))

            // Add active class to clicked item
            this.classList.add("active")

            // Get patient ID from data attribute
            const patientId = this.getAttribute("data-patient")

            // Hide all patient details
            document.querySelectorAll(".patient-details").forEach((detail) => {
                detail.classList.add("hidden")
            })

            // Show selected patient details
            const detailElement = document.getElementById(patientId + "-details")
            if (detailElement) {
                detailElement.classList.remove("hidden")
            }
        })
    })
})

// Cancellation Modal Functionality
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
                if (src && src.includes("/js/reception.js")) {
                    baseUrl = src.split("/js/reception.js")[0]
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

                    // Show success message
                    alert("Appointment cancelled successfully")

                    // Reload the page to reflect changes
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                } else {
                    alert("Failed to cancel appointment: " + (data.message || "Unknown error"))
                }
            })
            .catch((error) => {
                console.error("Error:", error)
                alert("Request failed: " + error.message)
            })
            .finally(() => {
                // Reset button state
                confirmBtn.disabled = false
                confirmBtn.innerHTML = "Confirm Cancellation"
            })
    })
})

