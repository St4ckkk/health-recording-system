document.addEventListener("DOMContentLoaded", () => {
    // View elements
    const doctorListView = document.getElementById("doctorListView")
    const doctorScheduleView = document.getElementById("doctorScheduleView")
    const doctorFormView = document.getElementById("doctorFormView")

    // Buttons
    const viewScheduleButtons = document.querySelectorAll(".view-schedule-btn")
    const backToDoctorListButton = document.getElementById("backToDoctorList")
    const addDoctorButton = document.getElementById("addDoctorBtn")
    const editScheduleButton = document.getElementById("editScheduleBtn")
    const backFromFormButton = document.getElementById("backFromForm")
    const cancelFormButton = document.getElementById("cancelForm")
    const addTimeSlotButton = document.getElementById("addTimeSlot")

    // Form elements
    const doctorForm = document.getElementById("doctorForm")
    const formTitle = document.getElementById("formTitle")
    const formSubtitle = document.getElementById("formSubtitle")
    const backButtonText = document.getElementById("backButtonText")
    const timeSlots = document.getElementById("timeSlots")

    // Function to show doctor list view
    function showDoctorListView() {
        doctorListView.classList.remove("hidden-view")
        doctorListView.classList.add("visible-view")

        doctorScheduleView.classList.remove("visible-view")
        doctorScheduleView.classList.add("hidden-view")

        doctorFormView.classList.remove("visible-view")
        doctorFormView.classList.add("hidden-view")

        window.scrollTo(0, 0)
    }

    // Function to show doctor schedule view
    function showDoctorScheduleView(doctorId) {
        doctorScheduleView.classList.remove("hidden-view")
        doctorScheduleView.classList.add("visible-view")

        doctorListView.classList.remove("visible-view")
        doctorListView.classList.add("hidden-view")

        doctorFormView.classList.remove("visible-view")
        doctorFormView.classList.add("hidden-view")

        window.scrollTo(0, 0)

        // Fetch doctor details and appointments
        fetchDoctorSchedule(doctorId)
    }

    // Function to fetch doctor schedule data
    function fetchDoctorSchedule(doctorId) {
        const baseUrl = document.querySelector('meta[name="base-url"]').content

        // Show loading state
        const doctorScheduleTitle = document.getElementById("doctorScheduleTitle")
        doctorScheduleTitle.textContent = "Loading doctor schedule..."

        // Clear previous data
        document.getElementById("doctorInfoCard").innerHTML = `
              <div class="flex justify-center items-center h-40">
                  <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
              </div>
          `
        document.getElementById("scheduleTableBody").innerHTML = `
              <tr>
                  <td colspan="4" class="text-center py-4">
                      <div class="animate-spin inline-block w-6 h-6 border-b-2 border-primary rounded-full"></div>
                      <span class="ml-2">Loading schedule...</span>
                  </td>
              </tr>
          `
        document.getElementById("appointmentsTableBody").innerHTML = `
              <tr>
                  <td colspan="5" class="text-center py-4">
                      <div class="animate-spin inline-block w-6 h-6 border-b-2 border-primary rounded-full"></div>
                      <span class="ml-2">Loading appointments...</span>
                  </td>
              </tr>
          `

        // Change from URL parameter to query parameter
        fetch(`${baseUrl}/receptionist/get_doctor_schedule?id=${doctorId}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => {
                // Clone the response so we can both check it and use it
                const responseClone = response.clone()

                if (!response.ok) {
                    throw new Error("Network response was not ok")
                }

                // Check if the response is JSON
                const contentType = response.headers.get("content-type")

                // Debug: Log the content type
                console.log("Response content type:", contentType)

                // If not JSON, get the text and log it to help debugging
                if (!contentType || !contentType.includes("application/json")) {
                    responseClone.text().then(text => {
                        console.error("Server returned non-JSON response:", text.substring(0, 500) + "...")
                    })
                    throw new Error("Server returned non-JSON response. This might indicate a server error.")
                }

                return response.json()
            })
            .then((data) => {
                if (data.success) {
                    // Update doctor info
                    updateDoctorInfo(data.doctor)

                    // Update schedule table
                    updateScheduleTable(data.doctor)

                    // Update appointments table
                    updateAppointmentsTable(data.appointments)
                } else {
                    alert(data.message || "Failed to load doctor schedule")
                }
            })
            .catch((error) => {
                console.error("Error:", error)

                // Show a more user-friendly error message
                const errorMessage = document.getElementById("doctorScheduleTitle")
                errorMessage.textContent = "Error loading doctor schedule"

                // Clear loading indicators with error messages
                document.getElementById("doctorInfoCard").innerHTML = `
                    <div class="p-4 text-center">
                        <div class="text-red-500 mb-2"><i class="bx bx-error-circle text-2xl"></i></div>
                        <p class="text-red-500">Failed to load doctor information</p>
                        <p class="text-sm text-gray-500 mt-2">Please try again later or contact support</p>
                    </div>
                `
                document.getElementById("scheduleTableBody").innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-red-500">
                            <i class="bx bx-error-circle mr-2"></i>
                            Failed to load schedule
                        </td>
                    </tr>
                `
                document.getElementById("appointmentsTableBody").innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-4 text-red-500">
                            <i class="bx bx-error-circle mr-2"></i>
                            Failed to load appointments
                        </td>
                    </tr>
                `

                alert("An error occurred while loading the doctor schedule. This might be due to a server issue. Please try again later.")
            })
    }

    // Function to update doctor info card
    function updateDoctorInfo(doctor) {
        const doctorScheduleTitle = document.getElementById("doctorScheduleTitle")
        doctorScheduleTitle.textContent = `Dr. ${doctor.full_name}'s Schedule`

        const doctorInfoCard = document.getElementById("doctorInfoCard")

        // Get available days
        const availableDays = doctor.available_days || []
        const dayAbbreviations = {
            'Monday': { 'abbr': 'Mon', 'class': 'day-mon' },
            'Tuesday': { 'abbr': 'Tue', 'class': 'day-tue' },
            'Wednesday': { 'abbr': 'Wed', 'class': 'day-wed' },
            'Thursday': { 'abbr': 'Thu', 'class': 'day-thu' },
            'Friday': { 'abbr': 'Fri', 'class': 'day-fri' },
            'Saturday': { 'abbr': 'Sat', 'class': 'day-sat' },
            'Sunday': { 'abbr': 'Sun', 'class': 'day-sun' }
        }

        // Format work hours
        let workHoursHtml = '9:00 AM - 5:00 PM'
        if (doctor.work_hours_start && doctor.work_hours_end) {
            const start_time = formatTime(doctor.work_hours_start)
            const end_time = formatTime(doctor.work_hours_end)
            workHoursHtml = `${start_time} - ${end_time}`
        }

        // Prepare profile image HTML
        let profileHtml = `
            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 overflow-hidden flex-shrink-0">
                <i class="bx bx-user text-xl"></i>
            </div>`

        if (doctor.profile) {
            // Get base URL from meta tag
            const baseUrl = document.querySelector('meta[name="base-url"]').content
            profileHtml = `
                <div class="h-12 w-12 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                    <img src="${baseUrl}/${doctor.profile}" alt="Dr. ${doctor.full_name}" class="h-full w-full object-cover">
                </div>`
        }

        doctorInfoCard.innerHTML = `
            <div class="p-6">
                <div class="flex items-start mb-4">
                    ${profileHtml}
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">Dr. ${doctor.full_name}</h3>
                        <p class="text-primary font-medium capitalize">${doctor.specialization}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Available Days</h4>
                    <div>
                        ${availableDays.length > 0
                ? availableDays.map(day =>
                    `<span class="schedule-day ${dayAbbreviations[day].class}">${dayAbbreviations[day].abbr}</span>`
                ).join('')
                : '<span class="text-sm text-gray-500">Not available</span>'
            }
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Contact Information</h4>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">
                            <i class="bx bx-envelope text-gray-400 mr-2"></i> ${doctor.email || 'Not provided'}
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="bx bx-phone text-gray-400 mr-2"></i> ${doctor.contact_number || 'Not provided'}
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <span class="text-sm text-gray-500">
                        <i class="bx bx-time text-gray-400 mr-1"></i>
                        ${workHoursHtml}
                    </span>
                    <button id="editDoctorProfileBtn" class="px-3 py-1.5 bg-primary-light text-primary rounded-md hover:bg-primary hover:text-white transition-colors duration-fast" data-doctor-id="${doctor.id}">
                        Edit Profile
                    </button>
                </div>
            </div>
        `

        // Add event listener to the edit profile button
        const editDoctorProfileBtn = document.getElementById("editDoctorProfileBtn")
        if (editDoctorProfileBtn) {
            editDoctorProfileBtn.addEventListener("click", function () {
                // This will be implemented later to edit the doctor profile
                alert("Edit doctor profile functionality will be implemented soon.")
            })
        }
    }

    // Function to update schedule table
    function updateScheduleTable(doctor) {
        const scheduleTableBody = document.getElementById("scheduleTableBody")
        const availableDays = doctor.available_days || []
        const timeSlots = doctor.time_slots || []

        // Group time slots by day
        const timeSlotsByDay = {}
        timeSlots.forEach((slot) => {
            if (!timeSlotsByDay[slot.day]) {
                timeSlotsByDay[slot.day] = []
            }
            timeSlotsByDay[slot.day].push(slot)
        })

        // Days of the week in order
        const daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"]

        // Create rows for each day
        let tableHtml = ""
        daysOfWeek.forEach((day) => {
            const isAvailable = availableDays.includes(day)
            const dayTimeSlots = timeSlotsByDay[day] || []

            let timeSlotsHtml = "Not Available"
            let locationHtml = "-"
            let maxAppointmentsHtml = "-"

            if (isAvailable && dayTimeSlots.length > 0) {
                timeSlotsHtml = dayTimeSlots
                    .map((slot) => {
                        const startTime = formatTime(slot.start_time)
                        const endTime = formatTime(slot.end_time)
                        return `<span class="schedule-time">${startTime} - ${endTime}</span>`
                    })
                    .join("")

                locationHtml = doctor.default_location || "Not specified"
                maxAppointmentsHtml = doctor.max_appointments_per_day
            }

            tableHtml += `
                  <tr>
                      <td class="font-medium">${day}</td>
                      <td>${timeSlotsHtml}</td>
                      <td>${locationHtml}</td>
                      <td>${maxAppointmentsHtml}</td>
                  </tr>
              `
        })

        scheduleTableBody.innerHTML = tableHtml
    }

    // Function to update appointments table
    function updateAppointmentsTable(appointments) {
        const appointmentsTableBody = document.getElementById("appointmentsTableBody")

        if (!appointments || appointments.length === 0) {
            appointmentsTableBody.innerHTML = `
                  <tr>
                      <td colspan="5" class="py-4 text-center text-gray-500">No upcoming appointments</td>
                  </tr>
              `
            return
        }

        let tableHtml = ""
        appointments.forEach((appointment) => {
            // Determine status class
            let statusClass = "bg-blue-100 text-blue-800"
            if (appointment.status === "confirmed") {
                statusClass = "bg-green-100 text-green-800"
            } else if (appointment.status === "cancelled") {
                statusClass = "bg-red-100 text-red-800"
            } else if (appointment.status === "completed") {
                statusClass = "bg-purple-100 text-purple-800"
            }

            tableHtml += `
                  <tr>
                      <td class="py-3 px-4 border-b border-gray-200">${appointment.first_name} ${appointment.middle_name ? appointment.middle_name : ''} ${appointment.last_name} ${appointment.suffix ? appointment.suffix : ''}</td>
                      <td class="py-3 px-4 border-b border-gray-200">${appointment.formatted_date}</td>
                      <td class="py-3 px-4 border-b border-gray-200">${appointment.formatted_time}</td>
                      <td class="py-3 px-4 border-b border-gray-200">${appointment.reason || "Not specified"}</td>
                      <td class="py-3 px-4 border-b border-gray-200">
                          <span class="px-2 py-1 ${statusClass} rounded-full text-xs font-medium capitalize">${appointment.status}</span>
                      </td>
                  </tr>
              `
        })

        appointmentsTableBody.innerHTML = tableHtml
    }

    // Helper function to format time (HH:MM:SS to 12-hour format)
    function formatTime(timeString) {
        if (!timeString) return ""

        const [hours, minutes] = timeString.split(":")
        const hour = Number.parseInt(hours)
        const ampm = hour >= 12 ? "PM" : "AM"
        const hour12 = hour % 12 || 12

        return `${hour12}:${minutes} ${ampm}`
    }

    // Function to show doctor form view
    function showDoctorFormView() {
        doctorFormView.classList.remove("hidden-view")
        doctorFormView.classList.add("visible-view")

        doctorListView.classList.remove("visible-view")
        doctorListView.classList.add("hidden-view")

        doctorScheduleView.classList.remove("visible-view")
        doctorScheduleView.classList.add("hidden-view")

        window.scrollTo(0, 0)
    }

    // Add event listeners for view transitions
    if (viewScheduleButtons) {
        viewScheduleButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const doctorId = this.getAttribute("data-doctor-id")
                showDoctorScheduleView(doctorId)
            })
        })
    }

    if (backToDoctorListButton) {
        backToDoctorListButton.addEventListener("click", showDoctorListView)
    }

    if (addDoctorButton) {
        addDoctorButton.addEventListener("click", () => {
            // Reset form
            doctorForm.reset()

            // Reset profile image preview
            const profileImagePreview = document.getElementById("profileImagePreview")
            const profileIcon = document.querySelector(".doctor-profile-preview .profile-icon")
            if (profileImagePreview && profileIcon) {
                profileImagePreview.classList.add("hidden")
                profileIcon.style.display = ""
            }

            // Set form title and subtitle
            formTitle.textContent = "Add New Doctor"
            formSubtitle.textContent = "Enter doctor details and schedule"
            backButtonText.textContent = "Back to Doctor List"

            showDoctorFormView()
        })
    }

    if (backFromFormButton) {
        backFromFormButton.addEventListener("click", showDoctorListView)
    }

    if (cancelFormButton) {
        cancelFormButton.addEventListener("click", showDoctorListView)
    }

    // Add time slot functionality
    if (addTimeSlotButton) {
        addTimeSlotButton.addEventListener("click", () => {
            const timeSlotTemplate = `
                  <div class="time-slot">
                      <input type="time" class="time-slot-input" required>
                      <span class="time-slot-separator">to</span>
                      <input type="time" class="time-slot-input" required>
                      <span class="time-slot-remove">
                          <i class="bx bx-x"></i>
                      </span>
                  </div>
              `

            timeSlots.insertAdjacentHTML("beforeend", timeSlotTemplate)

            // Add event listener to the new remove button
            const newTimeSlot = timeSlots.lastElementChild
            const removeButton = newTimeSlot.querySelector(".time-slot-remove")

            removeButton.addEventListener("click", function () {
                this.closest(".time-slot").remove()
            })
        })
    }

    // Add event listeners to existing time slot remove buttons
    document.querySelectorAll(".time-slot-remove").forEach((button) => {
        button.addEventListener("click", function () {
            this.closest(".time-slot").remove()
        })
    })

    // Form submission
    if (doctorForm) {
        doctorForm.addEventListener("submit", (e) => {
            e.preventDefault()

            // Validate form
            if (!validateDoctorForm()) {
                return
            }

            // Create FormData object
            const formData = new FormData(doctorForm)

            // Get selected days
            const selectedDays = []
            document.querySelectorAll('input[name="availableDays"]:checked').forEach((checkbox) => {
                selectedDays.push(checkbox.value)
                // Make sure each day is properly added to formData
                formData.append("availableDays[]", checkbox.value)
            })
            console.log("Selected days:", selectedDays)

            // Add time slots to form data
            const startTimes = []
            const endTimes = []

            document.querySelectorAll(".time-slot").forEach((slot) => {
                const inputs = slot.querySelectorAll('input[type="time"]')
                if (inputs.length === 2) {
                    startTimes.push(inputs[0].value)
                    endTimes.push(inputs[1].value)
                }
            })

            // Add start and end times to form data
            startTimes.forEach((time) => {
                formData.append("startTimes[]", time)
            })

            endTimes.forEach((time) => {
                formData.append("endTimes[]", time)
            })

            // Debug log
            console.log("Submitting form with time slots:", { startTimes, endTimes })

            // Get base URL from meta tag
            const baseUrl = document.querySelector('meta[name="base-url"]').content

            // Send AJAX request
            fetch(baseUrl + "/receptionist/add_doctor", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok")
                    }
                    return response.json()
                })
                .then((data) => {
                    if (data.success) {
                        // Show success message
                        alert(data.message)

                        // Reload page to show new doctor
                        window.location.reload()
                    } else {
                        // Show error message
                        alert(data.message || "Failed to add doctor")
                    }
                })
                .catch((error) => {
                    console.error("Error:", error)
                    alert("An error occurred while adding the doctor: " + error.message)
                })
        })
    }

    // Function to validate doctor form
    function validateDoctorForm() {
        // Get required fields
        const firstName = document.getElementById("firstname").value.trim()
        const lastName = document.getElementById("lastname").value.trim()
        const specialty = document.getElementById("specialty").value.trim()
        const email = document.getElementById("email").value.trim()
        const phone = document.getElementById("phone").value.trim()

        // Check required fields
        if (!firstName || !lastName || !specialty || !email || !phone) {
            alert("Please fill in all required fields")
            return false
        }

        // Check if at least one day is selected
        const availableDays = document.querySelectorAll('input[name="availableDays"]:checked')
        if (availableDays.length === 0) {
            alert("Please select at least one available day")
            return false
        }

        // Check if at least one time slot is added
        const timeSlots = document.querySelectorAll(".time-slot")
        if (timeSlots.length === 0) {
            alert("Please add at least one time slot")
            return false
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address")
            return false
        }

        return true
    }

    // Profile image preview functionality
    const profileImageInput = document.getElementById("profileImage")
    const profileImagePreview = document.getElementById("profileImagePreview")
    const profileIcon = document.querySelector(".doctor-profile-preview .profile-icon")

    if (profileImageInput && profileImagePreview) {
        profileImageInput.addEventListener("change", (e) => {
            if (e.target.files && e.target.files[0]) {
                const file = e.target.files[0]

                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert("File size exceeds 2MB. Please choose a smaller image.")
                    return
                }

                const reader = new FileReader()

                reader.onload = (event) => {
                    // Create a new image to check dimensions
                    const img = new Image()
                    img.onload = () => {
                        profileImagePreview.src = event.target.result
                        profileImagePreview.classList.remove("hidden")
                        if (profileIcon) {
                            profileIcon.style.display = "none"
                        }
                    }
                    img.src = event.target.result
                }

                reader.readAsDataURL(file)
            }
        })
    }
})

