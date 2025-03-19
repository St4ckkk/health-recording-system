
document.addEventListener('DOMContentLoaded', function () {
    // View elements
    const doctorListView = document.getElementById('doctorListView');
    const doctorScheduleView = document.getElementById('doctorScheduleView');
    const doctorFormView = document.getElementById('doctorFormView');

    // Buttons
    const viewScheduleButtons = document.querySelectorAll('.view-schedule-btn');
    const backToDoctorListButton = document.getElementById('backToDoctorList');
    const addDoctorButton = document.getElementById('addDoctorBtn');
    const editScheduleButton = document.getElementById('editScheduleBtn');
    const backFromFormButton = document.getElementById('backFromForm');
    const cancelFormButton = document.getElementById('cancelForm');
    const addTimeSlotButton = document.getElementById('addTimeSlot');

    // Form elements
    const doctorForm = document.getElementById('doctorForm');
    const formTitle = document.getElementById('formTitle');
    const formSubtitle = document.getElementById('formSubtitle');
    const backButtonText = document.getElementById('backButtonText');
    const timeSlots = document.getElementById('timeSlots');

    // Function to show doctor list view
    function showDoctorListView() {
        doctorListView.classList.remove('hidden-view');
        doctorListView.classList.add('visible-view');

        doctorScheduleView.classList.remove('visible-view');
        doctorScheduleView.classList.add('hidden-view');

        doctorFormView.classList.remove('visible-view');
        doctorFormView.classList.add('hidden-view');

        window.scrollTo(0, 0);
    }

    // Function to show doctor schedule view
    function showDoctorScheduleView(doctorId) {
        doctorScheduleView.classList.remove('hidden-view');
        doctorScheduleView.classList.add('visible-view');

        doctorListView.classList.remove('visible-view');
        doctorListView.classList.add('hidden-view');

        doctorFormView.classList.remove('visible-view');
        doctorFormView.classList.add('hidden-view');

        window.scrollTo(0, 0);

        // Here you would typically fetch the doctor's schedule data
        // and populate the view with it
    }

    // Function to show doctor form view
    function showDoctorFormView() {
        doctorFormView.classList.remove('hidden-view');
        doctorFormView.classList.add('visible-view');

        doctorListView.classList.remove('visible-view');
        doctorListView.classList.add('hidden-view');

        doctorScheduleView.classList.remove('visible-view');
        doctorScheduleView.classList.add('hidden-view');

        window.scrollTo(0, 0);
    }

    // Add event listeners for view transitions
    if (viewScheduleButtons) {
        viewScheduleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const doctorId = this.getAttribute('data-doctor-id');
                showDoctorScheduleView(doctorId);
            });
        });
    }

    if (backToDoctorListButton) {
        backToDoctorListButton.addEventListener('click', showDoctorListView);
    }

    if (addDoctorButton) {
        addDoctorButton.addEventListener('click', function () {
            // Reset form
            doctorForm.reset();

            // Reset profile image preview
            const profileImagePreview = document.getElementById('profileImagePreview');
            const profileIcon = document.querySelector('.profile-icon');
            if (profileImagePreview && profileIcon) {
                profileImagePreview.classList.add('hidden');
                profileIcon.classList.remove('hidden');
            }

            // Set form title and subtitle
            formTitle.textContent = 'Add New Doctor';
            formSubtitle.textContent = 'Enter doctor details and schedule';
            backButtonText.textContent = 'Back to Doctor List';

            showDoctorFormView();
        });
    }

    if (backFromFormButton) {
        backFromFormButton.addEventListener('click', showDoctorListView);
    }

    if (cancelFormButton) {
        cancelFormButton.addEventListener('click', showDoctorListView);
    }

    // Add time slot functionality
    if (addTimeSlotButton) {
        addTimeSlotButton.addEventListener('click', function () {
            const timeSlotTemplate = `
                <div class="time-slot">
                    <input type="time" class="time-slot-input" required>
                    <span class="time-slot-separator">to</span>
                    <input type="time" class="time-slot-input" required>
                    <span class="time-slot-remove">
                        <i class="bx bx-x"></i>
                    </span>
                </div>
            `;

            timeSlots.insertAdjacentHTML('beforeend', timeSlotTemplate);

            // Add event listener to the new remove button
            const newTimeSlot = timeSlots.lastElementChild;
            const removeButton = newTimeSlot.querySelector('.time-slot-remove');

            removeButton.addEventListener('click', function () {
                this.closest('.time-slot').remove();
            });
        });
    }

    // Add event listeners to existing time slot remove buttons
    document.querySelectorAll('.time-slot-remove').forEach(button => {
        button.addEventListener('click', function () {
            this.closest('.time-slot').remove();
        });
    });

    // Form submission
    if (doctorForm) {
        doctorForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate form
            if (!validateDoctorForm()) {
                return;
            }

            // Create FormData object
            const formData = new FormData(doctorForm);

            // Add time slots to form data
            const startTimes = [];
            const endTimes = [];

            document.querySelectorAll('.time-slot').forEach(slot => {
                const inputs = slot.querySelectorAll('input[type="time"]');
                if (inputs.length === 2) {
                    startTimes.push(inputs[0].value);
                    endTimes.push(inputs[1].value);
                }
            });

            // Add start and end times to form data
            startTimes.forEach(time => {
                formData.append('startTimes[]', time);
            });

            endTimes.forEach(time => {
                formData.append('endTimes[]', time);
            });

            // Send AJAX request
            fetch(BASE_URL + '/receptionist/add_doctor', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(data.message);

                        // Reload page to show new doctor
                        window.location.reload();
                    } else {
                        // Show error message
                        alert(data.message || 'Failed to add doctor');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding the doctor');
                });
        });
    }

    // Function to validate doctor form
    function validateDoctorForm() {
        // Get required fields
        const firstName = document.getElementById('firstname').value.trim();
        const lastName = document.getElementById('lastname').value.trim();
        const specialty = document.getElementById('specialty').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        // Check required fields
        if (!firstName || !lastName || !specialty || !email || !phone) {
            alert('Please fill in all required fields');
            return false;
        }

        // Check if at least one day is selected
        const availableDays = document.querySelectorAll('input[name="availableDays"]:checked');
        if (availableDays.length === 0) {
            alert('Please select at least one available day');
            return false;
        }

        // Check if at least one time slot is added
        const timeSlots = document.querySelectorAll('.time-slot');
        if (timeSlots.length === 0) {
            alert('Please add at least one time slot');
            return false;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address');
            return false;
        }

        return true;
    }
    
    // Remove this line as it's causing the error
    // const BASE_URL = "<?= BASE_URL ?>";
});


document.addEventListener('DOMContentLoaded', function () {
    const profileImageInput = document.getElementById('profileImage');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const profileIcon = document.querySelector('.profile-icon');

    if (profileImageInput) {
        profileImageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    profileImagePreview.src = e.target.result;
                    profileImagePreview.classList.remove('hidden');
                    profileIcon.classList.add('hidden');
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});