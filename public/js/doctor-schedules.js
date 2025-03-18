
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

        // Here you would load the specific doctor's data based on doctorId
        console.log('Viewing schedule for doctor:', doctorId);

        window.scrollTo(0, 0);
    }

    // Function to show doctor form view
    function showDoctorFormView(isEdit = false, doctorId = null) {
        doctorFormView.classList.remove('hidden-view');
        doctorFormView.classList.add('visible-view');

        doctorListView.classList.remove('visible-view');
        doctorListView.classList.add('hidden-view');

        doctorScheduleView.classList.remove('visible-view');
        doctorScheduleView.classList.add('hidden-view');

        if (isEdit) {
            formTitle.textContent = 'Edit Doctor Schedule';
            formSubtitle.textContent = 'Update doctor details and schedule';
            backButtonText.textContent = 'Back to Schedule';
            // Here you would load the doctor's data into the form
            console.log('Editing doctor:', doctorId);
        } else {
            formTitle.textContent = 'Add New Doctor';
            formSubtitle.textContent = 'Enter doctor details and schedule';
            backButtonText.textContent = 'Back to Doctor List';
            // Reset form
            doctorForm.reset();
        }

        window.scrollTo(0, 0);
    }

    // Add event listeners for view schedule buttons
    viewScheduleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const doctorId = this.getAttribute('data-doctor-id');
            showDoctorScheduleView(doctorId);
        });
    });

    // Add event listener for back to doctor list button
    backToDoctorListButton.addEventListener('click', showDoctorListView);

    // Add event listener for add doctor button
    addDoctorButton.addEventListener('click', function () {
        showDoctorFormView(false);
    });

    // Add event listener for edit schedule button
    editScheduleButton.addEventListener('click', function () {
        // Get the doctor ID from the current view
        const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
        showDoctorFormView(true, doctorId);
    });

    // Add event listener for back from form button
    backFromFormButton.addEventListener('click', function () {
        if (backButtonText.textContent === 'Back to Schedule') {
            // Get the doctor ID from the current view
            const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
            showDoctorScheduleView(doctorId);
        } else {
            showDoctorListView();
        }
    });

    // Add event listener for cancel form button
    cancelFormButton.addEventListener('click', function () {
        if (backButtonText.textContent === 'Back to Schedule') {
            // Get the doctor ID from the current view
            const doctorId = document.querySelector('.view-schedule-btn').getAttribute('data-doctor-id');
            showDoctorScheduleView(doctorId);
        } else {
            showDoctorListView();
        }
    });

    // Add event listener for add time slot button
    addTimeSlotButton.addEventListener('click', function () {
        const timeSlot = document.createElement('div');
        timeSlot.className = 'time-slot';
        timeSlot.innerHTML = `
            <input type="time" class="time-slot-input" value="09:00">
            <span class="time-slot-separator">to</span>
            <input type="time" class="time-slot-input" value="17:00">
            <span class="time-slot-remove">
                <i class="bx bx-x"></i>
            </span>
        `;
        timeSlots.appendChild(timeSlot);

        // Add event listener for remove button
        const removeButton = timeSlot.querySelector('.time-slot-remove');
        removeButton.addEventListener('click', function () {
            timeSlot.remove();
        });
    });

    // Add event listeners for existing time slot remove buttons
    document.querySelectorAll('.time-slot-remove').forEach(button => {
        button.addEventListener('click', function () {
            this.closest('.time-slot').remove();
        });
    });

    // Add event listener for form submission
    doctorForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Here you would handle form submission, validation, and saving data
        console.log('Form submitted');

        // For demo purposes, just go back to the list view
        showDoctorListView();
    });

    // Function to clear filters
    window.clearFilters = function () {
        document.getElementById('specialtyFilter').value = 'All Specialties';
        document.getElementById('availabilityFilter').value = 'Any Day';
        document.querySelector('input[placeholder="Search by doctor name or specialty..."]').value = '';
    };
});
