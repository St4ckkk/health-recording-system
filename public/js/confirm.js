window.confirmAppointment = (appointmentId) => {
    const modal = document.getElementById("confirmationModal");
    const modalContent = document.getElementById("confirmModalContent");

    if (!modal || !modalContent) return;

    // Set the appointment ID in the hidden field
    document.getElementById("confirmAppointmentId").value = appointmentId;

    // Reset the form
    document.getElementById("confirmationForm").reset();

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
    // Confirmation Modal Functionality
    const confirmationModal = document.getElementById("confirmationModal");
    const confirmModalContent = document.getElementById("confirmModalContent");

    if (confirmationModal && confirmModalContent) {
        const closeBtn = document.getElementById("closeConfirmModal");
        const cancelBtn = document.getElementById("cancelConfirmBtn");
        const confirmBtn = document.getElementById("confirmAppointmentBtn");

        // Function to close the modal with smooth animation
        function closeConfirmModal() {
            // Animate out
            confirmModalContent.classList.remove("scale-100", "opacity-100");
            confirmModalContent.classList.add("scale-95", "opacity-0");
            confirmationModal.classList.remove("opacity-100");

            // Wait for animation to complete
            setTimeout(() => {
                confirmationModal.classList.remove("flex");
                confirmationModal.classList.add("hidden");

                // Restore body scrolling
                document.body.style.overflow = "";
            }, 300);
        }

        // Close the modal when clicking the close button
        if (closeBtn) {
            closeBtn.addEventListener("click", closeConfirmModal);
        }

        // Close the modal when clicking the cancel button
        if (cancelBtn) {
            cancelBtn.addEventListener("click", closeConfirmModal);
        }

        // Close the modal when clicking outside of it
        confirmationModal.addEventListener("click", (event) => {
            if (event.target === confirmationModal) {
                closeConfirmModal();
            }
        });

        // Handle form submission
        if (confirmBtn) {
            confirmBtn.addEventListener("click", () => {
                const appointmentId = document.getElementById("confirmAppointmentId").value;
                const sendConfirmation = document.querySelector('input[name="send_confirmation"]').checked;
                const notes = document.getElementById("confirmation_notes").value;

                // Show loading state
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Processing...';

                // Get the BASE_URL from the HTML
                let baseUrl = "";
                const baseUrlMeta = document.querySelector('meta[name="base-url"]');
                if (baseUrlMeta) {
                    baseUrl = baseUrlMeta.getAttribute("content");
                } else {
                    // Fallback: try to get it from the script tag
                    const scriptTags = document.querySelectorAll("script");
                    for (const script of scriptTags) {
                        const src = script.getAttribute("src");
                        if (src && src.includes("/js/reception.js")) {
                            baseUrl = src.split("/js/reception.js")[0];
                            break;
                        }
                    }
                }

                // Log what we're sending for debugging
                console.log("Confirming appointment:");
                console.log("Appointment ID:", appointmentId);
                console.log("Send Confirmation:", sendConfirmation);
                console.log("Notes:", notes);

                // Send AJAX request to confirm the appointment
                fetch(baseUrl + "/receptionist/confirm-appointment", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify({
                        appointmentId: appointmentId,
                        send_confirmation: sendConfirmation,
                        special_instructions: notes,
                    }),
                })
                    .then((response) => {
                        console.log("Response status:", response.status);

                        // Check if response is ok before trying to parse JSON
                        if (!response.ok) {
                            throw new Error("Network response was not ok: " + response.status);
                        }

                        // Get the raw text first for debugging
                        return response.text().then((text) => {
                            console.log("Raw response:", text);

                            try {
                                // Try to parse as JSON
                                return JSON.parse(text);
                            } catch (e) {
                                console.error("JSON parse error:", e);
                                throw new Error("Invalid JSON response: " + text);
                            }
                        });
                    })
                    .then((data) => {
                        console.log("Parsed response:", data);

                        if (data.success) {
                            // Close the modal
                            closeConfirmModal();

                            // Update the UI to reflect the confirmed appointment
                            const appointmentElement = document.querySelector(`[data-patient="patient-${appointmentId}"]`);
                            if (appointmentElement) {
                                const statusBadge = appointmentElement.querySelector(".status-badge");
                                if (statusBadge) {
                                    statusBadge.className = "status-badge confirmed";
                                    statusBadge.innerHTML = '<i class="bx bx-calendar-check mr-1"></i><span class="text-xs">Confirmed</span>';
                                }
                            }

                            // Show success message
                            if (typeof showToast === 'function') {
                                showToast("Appointment confirmed successfully", "success");
                            } else {
                                alert("Appointment confirmed successfully");
                            }

                            // Reload the page to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            if (typeof showToast === 'function') {
                                showToast("Failed to confirm appointment: " + (data.message || "Unknown error"), "error");
                            } else {
                                alert("Failed to confirm appointment: " + (data.message || "Unknown error"));
                            }
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        if (typeof showToast === 'function') {
                            showToast("Request failed: " + error.message, "error");
                        } else {
                            alert("Request failed: " + error.message);
                        }
                    })
                    .finally(() => {
                        // Reset button state
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = "Confirm Appointment";
                    });
            });
        }
    }
});