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

    // Add event listeners for reschedule modals
    setupRescheduleModals();
})

// Define approveReschedule in the global scope
window.approveReschedule = (appointmentId) => {
    const modal = document.getElementById("approveRescheduleModal")
    const modalContent = document.getElementById("approveRescheduleModalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("approveRescheduleAppointmentId").value = appointmentId

    // Reset the form
    document.getElementById("approveRescheduleForm").reset()

    // Fetch the appointment details to get the requested date and time
    // This is a placeholder - you would typically fetch this from your server
    // For now, we'll just set some example values
    document.getElementById("requested_date").value = "2023-06-15" // Example date
    document.getElementById("requested_time").value = "14:30:00" // Example time

    // Initialize date and time pickers
    if (typeof flatpickr === "function") {
        flatpickr("#new_date", {
            dateFormat: "Y-m-d",
            allowInput: true,
            disableMobile: "true",
            altInput: true,
            altFormat: "F j, Y",
            minDate: "today",
            nextArrow: '<i class="bx bx-chevron-right"></i>',
            prevArrow: '<i class="bx bx-chevron-left"></i>',
        })

        flatpickr("#new_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            allowInput: true,
            disableMobile: "true",
            altInput: true,
            altFormat: "h:i K",
            minuteIncrement: 15,
        })
    }

    // Handle the "use requested date/time" checkbox
    const useRequestedCheckbox = document.getElementById("use_requested_datetime")
    const newDateInput = document.getElementById("new_date")
    const newTimeInput = document.getElementById("new_time")

    const updateDateTimeFields = () => {
        const useRequested = useRequestedCheckbox.checked
        newDateInput.disabled = useRequested
        newTimeInput.disabled = useRequested

        if (useRequested) {
            newDateInput.classList.add("bg-gray-100")
            newTimeInput.classList.add("bg-gray-100")
        } else {
            newDateInput.classList.remove("bg-gray-100")
            newTimeInput.classList.remove("bg-gray-100")
        }
    }

    useRequestedCheckbox.addEventListener("change", updateDateTimeFields)

    // Initial state
    updateDateTimeFields()

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

// Define denyReschedule in the global scope
window.denyReschedule = (appointmentId) => {
    const modal = document.getElementById("denyRescheduleModal")
    const modalContent = document.getElementById("denyRescheduleModalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("denyRescheduleAppointmentId").value = appointmentId

    // Reset the form
    document.getElementById("denyRescheduleForm").reset()

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

// Setup event listeners for reschedule modals
function setupRescheduleModals() {
    // Approve Reschedule Modal Functionality
    const approveRescheduleModal = document.getElementById("approveRescheduleModal")
    const approveRescheduleModalContent = document.getElementById("approveRescheduleModalContent")
    if (approveRescheduleModal && approveRescheduleModalContent) {
        const closeBtn = document.getElementById("closeApproveRescheduleModal")
        const cancelBtn = document.getElementById("cancelApproveRescheduleBtn")
        const confirmBtn = document.getElementById("confirmApproveRescheduleBtn")

        // Function to close the modal with smooth animation
        function closeApproveRescheduleModal() {
            // Animate out
            approveRescheduleModalContent.classList.remove("scale-100", "opacity-100")
            approveRescheduleModalContent.classList.add("scale-95", "opacity-0")
            approveRescheduleModal.classList.remove("opacity-100")

            // Wait for animation to complete
            setTimeout(() => {
                approveRescheduleModal.classList.remove("flex")
                approveRescheduleModal.classList.add("hidden")

                // Restore body scrolling
                document.body.style.overflow = ""
            }, 300)
        }

        // Close the modal when clicking the close button
        if (closeBtn) {
            closeBtn.addEventListener("click", closeApproveRescheduleModal)
        }

        // Close the modal when clicking the cancel button
        if (cancelBtn) {
            cancelBtn.addEventListener("click", closeApproveRescheduleModal)
        }

        // Close the modal when clicking outside of it
        approveRescheduleModal.addEventListener("click", (event) => {
            if (event.target === approveRescheduleModal) {
                closeApproveRescheduleModal()
            }
        })

        // Handle form submission
        if (confirmBtn) {
            confirmBtn.addEventListener("click", () => {
                const appointmentId = document.getElementById("approveRescheduleAppointmentId").value
                const useRequestedDateTime = document.getElementById("use_requested_datetime").checked
                const newDate = document.getElementById("new_date").value
                const newTime = document.getElementById("new_time").value
                const sendNotification = document.querySelector('input[name="send_reschedule_confirmation"]').checked
                const notes = document.getElementById("reschedule_notes").value

                // Show loading state
                confirmBtn.disabled = true
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...'

                // Log what we're sending for debugging
                console.log("Approving reschedule:")
                console.log("Appointment ID:", appointmentId)
                console.log("Use Requested Date/Time:", useRequestedDateTime)
                console.log("New Date:", newDate)
                console.log("New Time:", newTime)
                console.log("Send Notification:", sendNotification)
                console.log("Notes:", notes)

                // Here you would typically send an AJAX request to your server
                // For example:
                fetch(`${BASE_URL}/appointments/approve-reschedule`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        appointmentId,
                        useRequestedDateTime,
                        newDate: useRequestedDateTime ? null : newDate,
                        newTime: useRequestedDateTime ? null : newTime,
                        sendNotification,
                        notes
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showToast('Reschedule request approved successfully!', 'success');

                            // Close the modal
                            closeApproveRescheduleModal();

                            // Reload the page to reflect the changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            // Show error message
                            showToast(data.message || 'Failed to approve reschedule request.', 'error');

                            // Reset button state
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = 'Approve Reschedule';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');

                        // Reset button state
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = 'Approve Reschedule';
                    });
            })
        }
    }

    // Deny Reschedule Modal Functionality
    const denyRescheduleModal = document.getElementById("denyRescheduleModal")
    const denyRescheduleModalContent = document.getElementById("denyRescheduleModalContent")
    if (denyRescheduleModal && denyRescheduleModalContent) {
        const closeBtn = document.getElementById("closeDenyRescheduleModal")
        const cancelBtn = document.getElementById("cancelRescheduleDenialBtn")
        const confirmBtn = document.getElementById("confirmRescheduleDenialBtn")

        // Function to close the modal with smooth animation
        function closeDenyRescheduleModal() {
            // Animate out
            denyRescheduleModalContent.classList.remove("scale-100", "opacity-100")
            denyRescheduleModalContent.classList.add("scale-95", "opacity-0")
            denyRescheduleModal.classList.remove("opacity-100")

            // Wait for animation to complete
            setTimeout(() => {
                denyRescheduleModal.classList.remove("flex")
                denyRescheduleModal.classList.add("hidden")

                // Restore body scrolling
                document.body.style.overflow = ""
            }, 300)
        }

        // Close the modal when clicking the close button
        if (closeBtn) {
            closeBtn.addEventListener("click", closeDenyRescheduleModal)
        }

        // Close the modal when clicking the cancel button
        if (cancelBtn) {
            cancelBtn.addEventListener("click", closeDenyRescheduleModal)
        }

        // Close the modal when clicking outside of it
        denyRescheduleModal.addEventListener("click", (event) => {
            if (event.target === denyRescheduleModal) {
                closeDenyRescheduleModal()
            }
        })

        // Enable/disable the confirm button based on form validity
        const denialReasonInputs = document.querySelectorAll('input[name="reschedule_denial_reason"]')
        denialReasonInputs.forEach(input => {
            input.addEventListener('change', () => {
                confirmBtn.disabled = !document.querySelector('input[name="reschedule_denial_reason"]:checked')
            })
        })

        // Handle form submission
        if (confirmBtn) {
            confirmBtn.addEventListener("click", () => {
                const appointmentId = document.getElementById("denyRescheduleAppointmentId").value
                const denialReason = document.querySelector('input[name="reschedule_denial_reason"]:checked')?.value
                const sendNotification = document.querySelector('input[name="send_reschedule_denial_notification"]').checked
                const details = document.getElementById("reschedule_denial_details").value

                // Show loading state
                confirmBtn.disabled = true
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...'

                // Log what we're sending for debugging
                console.log("Denying reschedule:")
                console.log("Appointment ID:", appointmentId)
                console.log("Denial Reason:", denialReason)
                console.log("Send Notification:", sendNotification)
                console.log("Details:", details)

                // Here you would typically send an AJAX request to your server
                // For example:
                fetch(`${BASE_URL}/appointments/deny-reschedule`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        appointmentId,
                        denialReason,
                        sendNotification,
                        details
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showToast('Reschedule request denied successfully!', 'success');

                            // Close the modal
                            closeDenyRescheduleModal();

                            // Reload the page to reflect the changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            // Show error message
                            showToast(data.message || 'Failed to deny reschedule request.', 'error');

                            // Reset button state
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = 'Confirm Denial';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');

                        // Reset button state
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = 'Confirm Denial';
                    });
            })
        }
    }
}

// Helper function to show toast notifications
function showToast(message, type = 'info') {
    // Check if we have a toast container, if not create one
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `px-4 py-3 rounded-lg shadow-md flex items-center justify-between max-w-xs transform transition-all duration-300 translate-x-full opacity-0`;

    // Set background color based on type
    switch (type) {
        case 'success':
            toast.classList.add('bg-success', 'text-white');
            break;
        case 'error':
            toast.classList.add('bg-danger', 'text-white');
            break;
        case 'warning':
            toast.classList.add('bg-warning', 'text-white');
            break;
        default:
            toast.classList.add('bg-primary', 'text-white');
    }

    // Set content
    toast.innerHTML = `
        <span>${message}</span>
        <button class="ml-4 text-white focus:outline-none">
            <i class="bx bx-x"></i>
        </button>
    `;

    // Add to container
    toastContainer.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
    }, 10);

    // Add close button functionality
    const closeBtn = toast.querySelector('button');
    closeBtn.addEventListener('click', () => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            toast.remove();
        }, 300);
    });

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }
    }, 5000);
}

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




// Helper function to show toast notifications if not already defined
if (typeof showToast !== 'function') {
    function showToast(message, type = 'info') {
        // Check if we have a toast container, if not create one
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.className = `px-4 py-3 rounded-lg shadow-md flex items-center justify-between max-w-xs transform transition-all duration-300 translate-x-full opacity-0`;

        // Set background color based on type
        switch (type) {
            case 'success':
                toast.classList.add('bg-success', 'text-white');
                break;
            case 'error':
                toast.classList.add('bg-danger', 'text-white');
                break;
            case 'warning':
                toast.classList.add('bg-warning', 'text-white');
                break;
            default:
                toast.classList.add('bg-primary', 'text-white');
        }

        // Set content
        toast.innerHTML = `
            <span>${message}</span>
            <button class="ml-4 text-white focus:outline-none">
                <i class="bx bx-x"></i>
            </button>
        `;

        // Add to container
        toastContainer.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 10);

        // Add close button functionality
        const closeBtn = toast.querySelector('button');
        closeBtn.addEventListener('click', () => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 5000);
    }

    // Make showToast available globally
    window.showToast = showToast;
}

// Approve Cancellation function
window.approveCancellation = (appointmentId) => {
    const modal = document.getElementById("approveCancellationModal")
    const modalContent = document.getElementById("approveCancellationModalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("approveCancellationAppointmentId").value = appointmentId

    // Reset the form
    document.getElementById("approveCancellationForm").reset()

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

// Deny Cancellation function
window.denyCancellation = (appointmentId) => {
    const modal = document.getElementById("denyCancellationModal")
    const modalContent = document.getElementById("denyCancellationModalContent")

    if (!modal || !modalContent) return

    // Set the appointment ID in the hidden field
    document.getElementById("denyCancellationAppointmentId").value = appointmentId

    // Reset the form
    document.getElementById("denyCancellationForm").reset()

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

// Add this to your existing DOMContentLoaded event listener
document.addEventListener("DOMContentLoaded", () => {
    // Existing code...

    // Approve Reschedule Modal Functionality
    const approveRescheduleModal = document.getElementById("approveRescheduleModal")
    const approveRescheduleModalContent = document.getElementById("approveRescheduleModalContent")
    if (approveRescheduleModal && approveRescheduleModalContent) {
        const closeBtn = document.getElementById("closeApproveRescheduleModal")
        const cancelBtn = document.getElementById("cancelApproveRescheduleBtn")
        const confirmBtn = document.getElementById("confirmApproveRescheduleBtn")

        // Function to close the modal with smooth animation
        function closeApproveRescheduleModal() {
            // Animate out
            approveRescheduleModalContent.classList.remove("scale-100", "opacity-100")
            approveRescheduleModalContent.classList.add("scale-95", "opacity-0")
            approveRescheduleModal.classList.remove("opacity-100")

            // Wait for animation to complete
            setTimeout(() => {
                approveRescheduleModal.classList.remove("flex")
                approveRescheduleModal.classList.add("hidden")

                // Restore body scrolling
                document.body.style.overflow = ""
            }, 300)
        }

        // Close the modal when clicking the close button
        closeBtn.addEventListener("click", closeApproveRescheduleModal)

        // Close the modal when clicking the cancel button
        cancelBtn.addEventListener("click", closeApproveRescheduleModal)

        // Close the modal when clicking outside of it
        approveRescheduleModal.addEventListener("click", (event) => {
            if (event.target === approveRescheduleModal) {
                closeApproveRescheduleModal()
            }
        })

        // Handle form submission
        confirmBtn.addEventListener("click", () => {
            const appointmentId = document.getElementById("approveRescheduleAppointmentId").value
            const useRequestedDateTime = document.getElementById("use_requested_datetime").checked
            const newDate = document.getElementById("new_date").value
            const newTime = document.getElementById("new_time").value
            const sendNotification = document.querySelector('input[name="send_reschedule_confirmation"]').checked
            const notes = document.getElementById("reschedule_notes").value

            // Show loading state
            confirmBtn.disabled = true
            confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...'

            // Log what we're sending for debugging
            console.log("Approving reschedule:")
            console.log("Appointment ID:", appointmentId)
            console.log("Use Requested Date/Time:", useRequestedDateTime)
            console.log("New Date:", newDate)
            console.log("New Time:", newTime)
            console.log("Send Notification:", sendNotification)
            console.log("Notes:", notes)

            // Here you would typically send an AJAX request to your server
            // For now, we'll just simulate a successful response after a delay
            setTimeout(() => {
                // Simulate successful approval
                closeApproveRescheduleModal()

                // Show success message
                alert("Reschedule request approved successfully!")

                // Reload the page to reflect the changes
                window.location.reload()
            }, 1500)
        })
    }

    // Deny Reschedule Modal Functionality
    const denyRescheduleModal = document.getElementById("denyRescheduleModal")
    const denyRescheduleModalContent = document.getElementById("denyRescheduleModalContent")
    if (denyRescheduleModal && denyRescheduleModalContent) {
        const closeBtn = document.getElementById("closeDenyRescheduleModal")
        const cancelBtn = document.getElementById("cancelRescheduleDenialBtn")
        const confirmBtn = document.getElementById("confirmRescheduleDenialBtn")

        // Function to close the modal with smooth animation
        function closeDenyRescheduleModal() {
            // Animate out
            denyRescheduleModalContent.classList.remove("scale-100", "opacity-100")
            denyRescheduleModalContent.classList.add("scale-95", "opacity-0")
            denyRescheduleModal.classList.remove("opacity-100")

            // Wait for animation to complete
            setTimeout(() => {
                denyRescheduleModal.classList.remove("flex")
                denyRescheduleModal.classList.add("hidden")

                // Restore body scrolling
                document.body.style.overflow = ""
            }, 300)
        }

        // Close the modal when clicking the close button
        closeBtn.addEventListener("click", closeDenyRescheduleModal)

        // Close the modal when clicking the cancel button
        cancelBtn.addEventListener("click", closeDenyRescheduleModal)

        // Close the modal when clicking outside of it
        denyRescheduleModal.addEventListener("click", (event) => {
            if (event.target === denyRescheduleModal) {
                closeDenyRescheduleModal()
            }
        })

        // Enable/disable the confirm button based on form validity
        const denialReasonInputs = document.querySelectorAll('input[name="reschedule_denial_reason"]')
        denialReasonInputs.forEach(input => {
            input.addEventListener('change', () => {
                confirmBtn.disabled = !document.querySelector('input[name="reschedule_denial_reason"]:checked')
            })
        })

        // Handle form submission
        confirmBtn.addEventListener("click", () => {
            const appointmentId = document.getElementById("denyRescheduleAppointmentId").value
            const denialReason = document.querySelector('input[name="reschedule_denial_reason"]:checked')?.value
            const sendNotification = document.querySelector('input[name="send_reschedule_denial_notification"]').checked
            const details = document.getElementById("reschedule_denial_details").value

            // Show loading state
            confirmBtn.disabled = true
            confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...'

            // Log what we're sending for debugging
            console.log("Denying reschedule:")
            console.log("Appointment ID:", appointmentId)
            console.log("Denial Reason:", denialReason)
            console.log("Send Notification:", sendNotification)
            console.log("Details:", details)

            // Here you would typically send an AJAX request to your server
            // For now, we'll just simulate a successful response after a delay
            setTimeout(() => {
                // Simulate successful denial
                closeDenyRescheduleModal()

                // Show success message
                alert("Reschedule request denied successfully!")

                // Reload the page to reflect the changes
                window.location.reload()
            }, 1500)
        })
    }
})

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

// Add this to your existing DOMContentLoaded event listener
document.addEventListener("DOMContentLoaded", () => {
    // Reminder Modal Functionality
    const reminderModal = document.getElementById("reminderModal")
    const reminderModalContent = document.getElementById("reminderModalContent")
    if (reminderModal && reminderModalContent) {
        const closeBtn = document.getElementById("closeReminderModal")
        const cancelBtn = document.getElementById("cancelReminderBtn")
        const sendBtn = document.getElementById("sendReminderBtn")

        // Function to close the modal with smooth animation
        function closeReminderModal() {
            // Animate out
            reminderModalContent.classList.remove("scale-100", "opacity-100")
            reminderModalContent.classList.add("scale-95", "opacity-0")
            reminderModal.classList.remove("opacity-100")

            // Wait for animation to complete
            setTimeout(() => {
                reminderModal.classList.remove("flex")
                reminderModal.classList.add("hidden")

                // Restore body scrolling
                document.body.style.overflow = ""
            }, 300)
        }

        // Close the modal when clicking the close button
        closeBtn.addEventListener("click", closeReminderModal)

        // Close the modal when clicking the cancel button
        cancelBtn.addEventListener("click", closeReminderModal)

        // Close the modal when clicking outside of it
        reminderModal.addEventListener("click", (event) => {
            if (event.target === reminderModal) {
                closeReminderModal()
            }
        })

        // Handle form submission
        sendBtn.addEventListener("click", () => {
            const appointmentId = document.getElementById("reminderAppointmentId").value
            const reminderType = document.querySelector('input[name="reminder_type"]:checked')?.value
            const customMessage = document.getElementById("reminder_message").value

            // Validate form
            if (!reminderType) {
                alert("Please select a reminder type");
                return;
            }

            // Show loading state
            sendBtn.disabled = true
            sendBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Sending...'

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
                    if (src && src.includes("/js/reception.js")) {
                        baseUrl = src.split("/js/reception.js")[0]
                        break
                    }
                }
            }

            // Log what we're sending for debugging
            console.log("Sending reminder:")
            console.log("Appointment ID:", appointmentId)
            console.log("Reminder Type:", reminderType)
            console.log("Custom Message:", customMessage)

            // Here you would typically send an AJAX request to your server
            // For now, we'll just simulate a successful response after a delay
            setTimeout(() => {
                // Simulate successful reminder
                closeReminderModal()

                // Show success message
                alert("Reminder sent successfully!")

                // Update UI to show reminder was sent (optional)
                const appointmentElement = document.querySelector(`[data-patient="patient-${appointmentId}"]`)
                if (appointmentElement) {
                    // You could add a small indicator that a reminder was sent
                    // For example, add a small badge or icon
                }
            }, 1500)
        })
    }


    window.checkInPatient = (appointmentId) => {
        const modal = document.getElementById("checkInModal");
        const modalContent = document.getElementById("checkInModalContent");

        if (!modal || !modalContent) return;

        // Set the appointment ID in the hidden field
        document.getElementById("checkInAppointmentId").value = appointmentId;

        // Reset the form
        document.getElementById("checkInForm").reset();

        // Set current time
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        document.getElementById("currentCheckInTime").textContent = timeString;

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

    // Define startAppointment in the global scope
    window.startAppointment = (appointmentId) => {
        const modal = document.getElementById("startAppointmentModal");
        const modalContent = document.getElementById("startAppointmentModalContent");

        if (!modal || !modalContent) return;

        // Set the appointment ID in the hidden field
        document.getElementById("startAppointmentId").value = appointmentId;

        // Reset the form
        document.getElementById("startAppointmentForm").reset();

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

    // Add this to your existing DOMContentLoaded event listener
    document.addEventListener("DOMContentLoaded", () => {
        // Existing code...

        // Check-In Modal Functionality
        setupCheckInModal();

        // Start Appointment Modal Functionality
        setupStartAppointmentModal();
    });

    // Setup Check-In Modal
    function setupCheckInModal() {
        const checkInModal = document.getElementById("checkInModal");
        const checkInModalContent = document.getElementById("checkInModalContent");

        if (checkInModal && checkInModalContent) {
            const closeBtn = document.getElementById("closeCheckInModal");
            const cancelBtn = document.getElementById("cancelCheckInBtn");
            const confirmBtn = document.getElementById("confirmCheckInBtn");

            // Function to close the modal with smooth animation
            function closeCheckInModal() {
                // Animate out
                checkInModalContent.classList.remove("scale-100", "opacity-100");
                checkInModalContent.classList.add("scale-95", "opacity-0");
                checkInModal.classList.remove("opacity-100");

                // Wait for animation to complete
                setTimeout(() => {
                    checkInModal.classList.remove("flex");
                    checkInModal.classList.add("hidden");

                    // Restore body scrolling
                    document.body.style.overflow = "";
                }, 300);
            }

            // Close the modal when clicking the close button
            if (closeBtn) {
                closeBtn.addEventListener("click", closeCheckInModal);
            }

            // Close the modal when clicking the cancel button
            if (cancelBtn) {
                cancelBtn.addEventListener("click", closeCheckInModal);
            }

            // Close the modal when clicking outside of it
            checkInModal.addEventListener("click", (event) => {
                if (event.target === checkInModal) {
                    closeCheckInModal();
                }
            });

            // Handle form submission
            if (confirmBtn) {
                confirmBtn.addEventListener("click", () => {
                    const appointmentId = document.getElementById("checkInAppointmentId").value;
                    const verifyInsurance = document.getElementById("verify_insurance").checked;
                    const verifyId = document.getElementById("verify_id").checked;
                    const formsCompleted = document.getElementById("forms_completed").checked;
                    const notifyProvider = document.getElementById("notify_provider").checked;
                    const notes = document.getElementById("check_in_notes").value;

                    // Show loading state
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...';

                    // Log what we're sending for debugging
                    console.log("Checking in patient:");
                    console.log("Appointment ID:", appointmentId);
                    console.log("Verify Insurance:", verifyInsurance);
                    console.log("Verify ID:", verifyId);
                    console.log("Forms Completed:", formsCompleted);
                    console.log("Notify Provider:", notifyProvider);
                    console.log("Notes:", notes);

                    // Here you would typically send an AJAX request to your server
                    fetch(`${BASE_URL}/appointments/check-in`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            appointmentId,
                            verifyInsurance,
                            verifyId,
                            formsCompleted,
                            notifyProvider,
                            notes
                        }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showToast('Patient checked in successfully!', 'success');

                                // Close the modal
                                closeCheckInModal();

                                // Reload the page to reflect the changes
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                // Show error message
                                showToast(data.message || 'Failed to check in patient.', 'error');

                                // Reset button state
                                confirmBtn.disabled = false;
                                confirmBtn.innerHTML = 'Complete Check-In';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred. Please try again.', 'error');

                            // Reset button state
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = 'Complete Check-In';
                        });
                });
            }
        }
    }

    // Setup Start Appointment Modal
    function setupStartAppointmentModal() {
        const startAppointmentModal = document.getElementById("startAppointmentModal");
        const startAppointmentModalContent = document.getElementById("startAppointmentModalContent");

        if (startAppointmentModal && startAppointmentModalContent) {
            const closeBtn = document.getElementById("closeStartAppointmentModal");
            const cancelBtn = document.getElementById("cancelStartAppointmentBtn");
            const confirmBtn = document.getElementById("confirmStartAppointmentBtn");

            // Function to close the modal with smooth animation
            function closeStartAppointmentModal() {
                // Animate out
                startAppointmentModalContent.classList.remove("scale-100", "opacity-100");
                startAppointmentModalContent.classList.add("scale-95", "opacity-0");
                startAppointmentModal.classList.remove("opacity-100");

                // Wait for animation to complete
                setTimeout(() => {
                    startAppointmentModal.classList.remove("flex");
                    startAppointmentModal.classList.add("hidden");

                    // Restore body scrolling
                    document.body.style.overflow = "";
                }, 300);
            }

            // Close the modal when clicking the close button
            if (closeBtn) {
                closeBtn.addEventListener("click", closeStartAppointmentModal);
            }

            // Close the modal when clicking the cancel button
            if (cancelBtn) {
                cancelBtn.addEventListener("click", closeStartAppointmentModal);
            }

            // Close the modal when clicking outside of it
            startAppointmentModal.addEventListener("click", (event) => {
                if (event.target === startAppointmentModal) {
                    closeStartAppointmentModal();
                }
            });

            // Handle form submission
            if (confirmBtn) {
                confirmBtn.addEventListener("click", () => {
                    const appointmentId = document.getElementById("startAppointmentId").value;
                    const vitalsRecorded = document.getElementById("vitals_recorded").checked;
                    const roomPrepared = document.getElementById("room_prepared").checked;
                    const providerNotified = document.getElementById("provider_notified").checked;
                    const roomNumber = document.getElementById("room_number").value;
                    const notes = document.getElementById("start_appointment_notes").value;

                    // Validate room number
                    if (!roomNumber) {
                        showToast('Please select a room number', 'warning');
                        return;
                    }

                    // Show loading state
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...';

                    // Log what we're sending for debugging
                    console.log("Starting appointment:");
                    console.log("Appointment ID:", appointmentId);
                    console.log("Vitals Recorded:", vitalsRecorded);
                    console.log("Room Prepared:", roomPrepared);
                    console.log("Provider Notified:", providerNotified);
                    console.log("Room Number:", roomNumber);
                    console.log("Notes:", notes);

                    // Here you would typically send an AJAX request to your server
                    fetch(`${BASE_URL}/appointments/start`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            appointmentId,
                            vitalsRecorded,
                            roomPrepared,
                            providerNotified,
                            roomNumber,
                            notes
                        }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                showToast('Appointment started successfully!', 'success');

                                // Close the modal
                                closeStartAppointmentModal();

                                // Reload the page to reflect the changes
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                // Show error message
                                showToast(data.message || 'Failed to start appointment.', 'error');

                                // Reset button state
                                confirmBtn.disabled = false;
                                confirmBtn.innerHTML = 'Start Appointment';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred. Please try again.', 'error');

                            // Reset button state
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = 'Start Appointment';
                        });
                });
            }
        }
    }
})