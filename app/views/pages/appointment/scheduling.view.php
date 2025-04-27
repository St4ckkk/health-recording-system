<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .day-button {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .day-button.available {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .day-button.available:hover {
            background-color: var(--primary);
            color: white;
        }

        .day-button.selected {
            background-color: var(--primary);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
        }

        .time-slot {
            transition: all 0.2s ease;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .time-slot:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .time-slot.selected {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .form-input {
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .avatar {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Scrollable time slots container */
        .time-slots-container {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 8px;
            margin-right: -8px;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-light) var(--gray-100);
        }

        .time-slots-container::-webkit-scrollbar {
            width: 6px;
        }

        .time-slots-container::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 10px;
        }

        .time-slots-container::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }

        .time-slots-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Profile image upload styles */
        .profile-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            border-radius: 0.75rem;
            background-color: #f9fafb;
            border: 1px dashed var(--gray-300);
            transition: all 0.2s ease;
        }

        .profile-upload-container:hover {
            border-color: var(--primary);
            background-color: rgba(var(--primary-rgb), 0.05);
        }

        .profile-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 1rem;
            border: 3px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .profile-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: white;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .upload-instructions {
            font-size: 0.875rem;
            color: var(--gray-500);
            text-align: center;
            margin-top: 0.5rem;
        }

        .remove-image-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #ef4444;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .profile-preview:hover .remove-image-btn {
            opacity: 1;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row w-full bg-white max-w-6xl card">
        <!-- Left panel - Company info -->
        <div class="w-full md:w-2/5 p-8 border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50">
            <div class="mb-8">
                <div class="w-64 h-16 mb-12">
                    <div class="inline-flex items-center">
                        <div class="mr-3">
                            <div class="w-24 h-24">
                                <img src="<?= BASE_URL ?>/images/logo.png" alt="Test Clinic Logo"
                                    class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16">
                    <div class="flex items-center mb-4">
                        <div class="avatar w-16 h-16 mr-4 shrink-0">
                            <?php if (!empty($doctor->profile)): ?>
                                <img src="<?= BASE_URL . '/' . $doctor->profile ?>"
                                    class="w-full h-full object-cover rounded-full" alt="Dr. <?= $doctor->full_name ?>">
                            <?php else: ?>
                                <i class="bx bx-user text-2xl"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Dr. <?= $doctor->full_name ?></h2>
                            <h1 class="text-gray-500 text-sm capitalize"><?= $doctor->specialization ?></h1>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Available Days</h3>
                        <div class="flex flex-wrap gap-1">
                            <?php foreach ($doctor->available_days as $day): ?>
                                <span
                                    class="inline-block px-2 py-1 bg-primary-light text-primary text-xs rounded-full"><?= $day ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Add selected appointment time display -->
                <div id="selectedAppointmentTime"
                    class="hidden mt-8 p-4 rounded-lg bg-primary-light border border-primary/10">
                    <div class="flex items-start">
                        <i class="bx bx-calendar-alt text-xl mt-1 mr-3 text-primary"></i>
                        <div>
                            <span id="appointmentTimeRange" class="block font-medium text-gray-800"></span>
                            <span id="appointmentFullDate" class="block text-gray-600"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel - Calendar and Form -->
        <div class="w-full md:w-3/5 p-8 relative border border-gray-200">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 fade-in">
                    <p><?= $_SESSION['error'] ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Step 1: Calendar View -->
            <div id="calendarView" class="block fade-in">
                <div class="flex flex-col md:flex-row md:space-x-8">
                    <!-- Calendar Column -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Select a Date & Time</h2>

                        <div class="flex items-center justify-between mb-6">
                            <button id="prevMonth"
                                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                <i class="bx bx-chevron-left text-2xl"></i>
                            </button>

                            <span id="currentMonthYear" class="text-lg font-medium"></span>

                            <button id="nextMonth"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-light text-primary transition-colors">
                                <i class="bx bx-chevron-right text-2xl"></i>
                            </button>
                        </div>

                        <!-- Calendar grid - Will be generated dynamically -->
                        <div class="mb-4">
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                <div class="text-center text-sm font-medium text-gray-600">SUN</div>
                                <div class="text-center text-sm font-medium text-gray-600">MON</div>
                                <div class="text-center text-sm font-medium text-gray-600">TUE</div>
                                <div class="text-center text-sm font-medium text-gray-600">WED</div>
                                <div class="text-center text-sm font-medium text-gray-600">THU</div>
                                <div class="text-center text-sm font-medium text-gray-600">FRI</div>
                                <div class="text-center text-sm font-medium text-gray-600">SAT</div>
                            </div>

                            <div id="calendarGrid" class="grid grid-cols-7 gap-2">
                                <!-- Calendar days will be generated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots Column - Initially hidden -->
                    <div id="timeSlotContainer" class="hidden md:w-64 mt-8 md:mt-16 fade-in">
                        <h3 id="selectedDate" class="text-lg font-semibold text-gray-800 mb-4"></h3>

                        <div id="timeSlots" class="time-slots-container">
                            <!-- Time slots will be dynamically populated -->
                            <div class="text-center py-4 text-gray-500">
                                <i class="bx bx-time-five text-2xl mb-2"></i>
                                <p>Select a date to view available time slots</p>
                            </div>
                        </div>

                        <!-- Next button - Initially hidden -->
                        <button id="nextButton" class="hidden w-full mt-6 btn-primary py-3 px-6 rounded-lg">
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Patient Information Form (Initially Hidden) -->
            <div id="patientFormView" class="hidden fade-in">
                <div class="flex items-center mb-6">
                    <button id="backToCalendar"
                        class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="bx bx-arrow-back mr-2"></i>
                        Back
                    </button>
                </div>
                <form id="patientForm" action="<?= BASE_URL ?>/appointment/book" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    <!-- Hidden fields for appointment data -->
                    <input type="hidden" id="doctor_id" name="doctor_id" value="<?= $doctor->id ?>">
                    <input type="hidden" id="appointment_date" name="appointment_date">
                    <input type="hidden" id="appointment_time" name="appointment_time">

                    <!-- Profile Upload Section - Moved to top for better visibility -->
                    <h3 class="section-title">Patient Information</h3>
                    <div class="profile-upload-container">
                        <div class="profile-preview" id="profilePreview">
                            <i class="bx bx-user text-4xl text-gray-400"></i>
                            <div class="remove-image-btn" id="removeImageBtn" style="display: none;">
                                <i class="bx bx-x"></i>
                            </div>
                        </div>
                        <label class="upload-btn">
                            <i class="bx bx-upload"></i>
                            <span>Upload Profile Photo</span>
                            <input type="file" id="profileImage" name="profileImage" accept="image/*" class="hidden"
                                onchange="previewImage(this)">
                        </label>
                        <p class="upload-instructions">Optional: Upload a clear photo for yours</p>
                    </div>


                    <!-- Patient Name Section -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First
                                    Name*</label>
                                <input type="text" id="firstName" name="firstName" required class="form-input w-full">
                            </div>
                            <div>
                                <label for="middleName" class="block text-sm font-medium text-gray-700 mb-1">Middle
                                    Name</label>
                                <input type="text" id="middleName" name="middleName" class="form-input w-full">
                            </div>
                            <div>
                                <label for="surname"
                                    class="block text-sm font-medium text-gray-700 mb-1">Surname*</label>
                                <input type="text" id="surname" name="surname" required class="form-input w-full">
                            </div>
                            <div>
                                <label for="suffix" class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                                <select id="suffix" name="suffix" class="form-input w-full">
                                    <option value="">None</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                    Birth*</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" required
                                    class="form-input w-full" onchange="calculateAge()">
                            </div>
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age*</label>
                                <input type="number" id="age" name="age" required class="form-input w-full" min="0"
                                    max="120">
                            </div>
                            <div>
                                <label for="legalSex" class="block text-sm font-medium text-gray-700 mb-1">Legal
                                    Sex*</label>
                                <select id="legalSex" name="legalSex" required class="form-input w-full">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address*</label>
                                <input type="email" id="email" name="email" required class="form-input w-full"
                                    placeholder="example@email.com">
                            </div>
                            <div>
                                <label for="contactNumber" class="block text-sm font-medium text-gray-700 mb-1">Contact
                                    Number*</label>
                                <input type="tel" id="contactNumber" name="contactNumber" required
                                    class="form-input w-full" placeholder="e.g., 0123456789">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                                <textarea id="address" name="address" required rows="3"
                                    class="form-input w-full"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="space-y-4">
                        <h3 class="section-title">Appointment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="appointmentType"
                                    class="block text-sm font-medium text-gray-700 mb-1">Appointment Type*</label>
                                <select id="appointmentType" name="appointmentType" required class="form-input w-full">
                                    <option value="">Select Type</option>
                                    <option value="checkup">Checkup</option>
                                    <option value="follow_up">Follow-up</option>
                                    <option value="consultation">Consultation</option>
                                    <option value="treatment">Treatment</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="specialist">Specialist</option>
                                    <option value="vaccination">Vaccination</option>
                                    <option value="laboratory_test">Laboratory Test</option>
                                    <option value="medical_clearance">Medical Clearance</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="appointmentReason"
                                    class="block text-sm font-medium text-gray-700 mb-1">Reason for Appointment*</label>
                                <textarea id="appointmentReason" name="appointmentReason" required rows="3"
                                    class="form-input w-full"></textarea>
                            </div>
                        </div>
                    </div>



                    <!-- Guardian Information -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="isGuardian" name="isGuardian"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="isGuardian" class="ml-2 block text-sm text-gray-700">I am not the patient
                                (booking for someone else)</label>
                        </div>

                        <div id="guardianFields" class="hidden space-y-4 fade-in">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="guardianName"
                                        class="block text-sm font-medium text-gray-700 mb-1">Guardian Name*</label>
                                    <input type="text" id="guardianName" name="guardianName" class="form-input w-full">
                                </div>
                                <div>
                                    <label for="relationship"
                                        class="block text-sm font-medium text-gray-700 mb-1">Relationship to
                                        Patient*</label>
                                    <select id="relationship" name="relationship" class="form-input w-full">
                                        <option value="">Select</option>
                                        <option value="Parent">Parent</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Child">Child</option>
                                        <option value="Sibling">Sibling</option>
                                        <option value="Caregiver">Caregiver</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full btn-primary py-3 px-6 rounded-lg">
                            Submit Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/appointment/appointment.js"></script>
    <script type="application/json" id="doctor-available-days">
        <?= json_encode($doctor->available_days) ?>
    </script>
</body>

</html>