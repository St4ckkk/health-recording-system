// Add these new functions to the medications.js file

// Function to load medicine categories
function loadMedicineCategories() {
    fetch('/doctor/get-medicine-categories', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const categorySelect = document.getElementById('medicine_category');
                if (categorySelect) {
                    // Clear existing options except the first one
                    while (categorySelect.options.length > 1) {
                        categorySelect.remove(1);
                    }

                    // Add new options
                    data.categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category;
                        option.textContent = category;
                        categorySelect.appendChild(option);
                    });
                }
            } else {
                console.error('Error loading medicine categories:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching medicine categories:', error);
        });
}

// Function to search medicines
function searchMedicines() {
    const category = document.getElementById('medicine_category').value;
    const searchTerm = document.getElementById('medicine_search').value;

    // Show loading state
    const medicineSelect = document.getElementById('medicine_select');
    if (medicineSelect) {
        medicineSelect.innerHTML = '<option value="">Loading medicines...</option>';
    }

    fetch(`/doctor/search-medicines?category=${encodeURIComponent(category)}&search=${encodeURIComponent(searchTerm)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (medicineSelect) {
                    // Clear existing options
                    medicineSelect.innerHTML = '<option value="">Select a medicine</option>';

                    // Add new options
                    data.medicines.forEach(medicine => {
                        const option = document.createElement('option');
                        option.value = medicine.id;
                        option.textContent = `${medicine.name} (${medicine.dosage}) - ${medicine.form}`;
                        option.dataset.name = medicine.name;
                        option.dataset.dosage = medicine.dosage;
                        option.dataset.form = medicine.form;
                        medicineSelect.appendChild(option);
                    });

                    // Show message if no medicines found
                    if (data.medicines.length === 0) {
                        medicineSelect.innerHTML = '<option value="">No medicines found</option>';
                    }
                }
            } else {
                console.error('Error searching medicines:', data.message);
                if (medicineSelect) {
                    medicineSelect.innerHTML = '<option value="">Error loading medicines</option>';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching medicines:', error);
            if (medicineSelect) {
                medicineSelect.innerHTML = '<option value="">Error loading medicines</option>';
            }
        });
}

// Function to handle medicine selection
function handleMedicineSelection() {
    const medicineSelect = document.getElementById('medicine_select');
    const medicineNameInput = document.getElementById('medicine_name');
    const medicineInventoryIdInput = document.getElementById('medicine_inventory_id');
    const dosageInput = document.getElementById('dosage');

    if (medicineSelect && medicineNameInput && medicineInventoryIdInput) {
        medicineSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                medicineInventoryIdInput.value = selectedOption.value;
                medicineNameInput.value = selectedOption.dataset.name;

                // Pre-fill dosage with the medicine's standard dosage if available
                if (selectedOption.dataset.dosage) {
                    dosageInput.value = selectedOption.dataset.dosage + ' ' + selectedOption.dataset.form;
                }
            } else {
                medicineInventoryIdInput.value = '';
                medicineNameInput.value = '';
                dosageInput.value = '';
            }
        });
    }
}

// Update the handleMedicationSubmit function to include medicine_inventory_id
function handleMedicationSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get values from form
    const medicationId = formData.get('medication_id') || generateUniqueId();
    const medicineInventoryId = formData.get('medicine_inventory_id') || '';
    const medicineName = formData.get('medicine_name') || '';
    const dosage = formData.get('dosage') || '';
    const frequency = formData.get('frequency') || '';
    const startDate = formData.get('start_date') || new Date().toISOString().split('T')[0];
    const purpose = formData.get('purpose') || '';

    // Validate that a medicine is selected
    if (!medicineName) {
        showToast('error', 'Error', 'Please select a medicine from the dropdown.', 'medications-toast-container');
        return;
    }

    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create medication data object
    const medicationData = {
        id: medicationId,
        medicine_inventory_id: medicineInventoryId,
        medicine_name: medicineName,
        dosage: dosage,
        frequency: frequency,
        start_date: startDate,
        purpose: purpose,
        quantity: 1, // Add quantity
        created_at: new Date().toISOString()
    };

    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get existing medications or create new array
    let pendingMedications = [];
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            pendingMedications = JSON.parse(savedMedications);

            // If editing, update the existing medication
            const existingIndex = pendingMedications.findIndex(med => med.id === medicationId);
            if (existingIndex !== -1) {
                pendingMedications[existingIndex] = medicationData;
            } else {
                // Otherwise add new medication
                pendingMedications.push(medicationData);
            }
        } catch (e) {
            console.error('Error parsing saved medications:', e);
            pendingMedications = [medicationData];
        }
    } else {
        pendingMedications = [medicationData];
    }

    // Save to localStorage
    localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(pendingMedications));

    // Display all medications
    displayMedicationCards(pendingMedications);

    // Close the modal and reset form
    closeModal('add-medication-modal');
    form.reset();
    document.getElementById('medication_id').value = '';
    document.getElementById('medicine_inventory_id').value = '';
    document.getElementById('medication-modal-title').textContent = 'Add Medication';

    // Show toast notification
    showToast('success', 'Medication Saved', 'Medication saved successfully! These will be stored when you complete the checkup.', 'medications-toast-container');
}

// Update the editMedication function to handle medicine_inventory_id
function editMedication(id) {
    // Get patient ID from the page
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

    // Get the stored medications data
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
    if (!savedMedications) {
        alert('Cannot edit this medication. Please refresh the page and try again.');
        return;
    }

    try {
        const medicationsData = JSON.parse(savedMedications);
        const medication = medicationsData.find(med => med.id === id);

        if (!medication) {
            alert('Medication not found.');
            return;
        }

        // Open the modal
        openModal('add-medication-modal');

        // Change modal title
        document.getElementById('medication-modal-title').textContent = 'Edit Medication';

        // Pre-fill the form with the stored data
        const form = document.getElementById('medicationForm');

        form.elements['medication_id'].value = medication.id;
        form.elements['medicine_inventory_id'].value = medication.medicine_inventory_id || '';
        form.elements['medicine_name'].value = medication.medicine_name;

        // Set the select dropdown if possible
        const medicineSelect = form.elements['medicine_select'];
        if (medicineSelect && medication.medicine_inventory_id) {
            // We need to search for this medicine to populate the dropdown
            fetch(`/doctor/search-medicines?search=${encodeURIComponent(medication.medicine_name)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.medicines.length > 0) {
                        // Clear existing options
                        medicineSelect.innerHTML = '<option value="">Select a medicine</option>';

                        // Add options from search results
                        data.medicines.forEach(medicine => {
                            const option = document.createElement('option');
                            option.value = medicine.id;
                            option.textContent = `${medicine.name} (${medicine.dosage}) - ${medicine.form}`;
                            option.dataset.name = medicine.name;
                            option.dataset.dosage = medicine.dosage;
                            option.dataset.form = medicine.form;
                            medicineSelect.appendChild(option);

                            // Select the matching medicine
                            if (medicine.id == medication.medicine_inventory_id) {
                                option.selected = true;
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching medicine for edit:', error);
                });
        }

        form.elements['dosage'].value = medication.dosage;
        form.elements['frequency'].value = medication.frequency;
        form.elements['start_date'].value = medication.start_date;
        form.elements['purpose'].value = medication.purpose || '';

    } catch (e) {
        console.error('Error loading medication for edit:', e);
        alert('Error loading medication data. Please try again.');
    }
}

function deleteMedication(id) {
    if (confirm('Are you sure you want to delete this medication?')) {
        // Get patient ID from the page
        const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';

        // Get the stored medications data
        const savedMedications = localStorage.getItem('pendingMedications_' + patientId);
        if (!savedMedications) return;

        try {
            let medicationsData = JSON.parse(savedMedications);

            // Filter out the medication to delete
            medicationsData = medicationsData.filter(med => med.id !== id);

            // Save the updated medications back to localStorage
            localStorage.setItem('pendingMedications_' + patientId, JSON.stringify(medicationsData));

            // Update the display
            if (medicationsData.length === 0) {
                const medicationsContainer = document.getElementById('medications-container');
                medicationsContainer.innerHTML = `
                    <div class="col-span-12 text-center py-6 text-gray-500" id="no-medications-message">
                        No medications prescribed yet.
                    </div>
                `;
            } else {
                displayMedicationCards(medicationsData);
            }

            // Show toast notification
            showToast('success', 'Medication Deleted', 'Medication has been removed successfully.', 'medications-toast-container');

        } catch (e) {
            console.error('Error deleting medication:', e);
            alert('Error deleting medication. Please try again.');
        }
    }
}

function loadSavedMedications() {
    const patientId = document.querySelector('input[name="patient_id"]')?.value || '0';
    const savedMedications = localStorage.getItem('pendingMedications_' + patientId);

    if (savedMedications) {
        try {
            const medicationsData = JSON.parse(savedMedications);
            if (medicationsData.length > 0) {
                displayMedicationCards(medicationsData);
            }
        } catch (e) {
            console.error('Error loading saved medications:', e);
        }
    }
}

function displayMedicationCards(medicationsData) {
    // Get the medications container
    const medicationsContainer = document.getElementById('medications-container');
    if (!medicationsContainer) return;

    // Remove the "no medications" message if it exists
    const noMedicationsMessage = document.getElementById('no-medications-message');
    if (noMedicationsMessage) {
        noMedicationsMessage.remove();
    }

    // Create HTML for medication cards
    let medicationsHTML = '';

    medicationsData.forEach(medication => {
        medicationsHTML += `
            <div class="col-span-4">
                <div class="medication-card">
                    <div class="medication-header">
                        <div class="medication-title">${medication.medicine_name}</div>
                        <div class="medication-actions">
                            <button class="action-icon edit" onclick="editMedication('${medication.id}')">
                                <i class="bx bx-edit"></i>
                            </button>
                            <button class="action-icon delete" onclick="deleteMedication('${medication.id}')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="medication-details">
                        <div class="medication-dosage">
                            <i class="bx bx-capsule"></i>
                            <span>${medication.dosage}</span>
                        </div>
                        <div class="medication-frequency">
                            <i class="bx bx-time"></i>
                            <span>${medication.frequency}</span>
                        </div>
                        ${medication.purpose ? `
                            <div class="medication-purpose">
                                <i class="bx bx-info-circle"></i>
                                <span>${medication.purpose}</span>
                            </div>
                        ` : ''}
                        <div class="medication-date">
                            <i class="bx bx-calendar"></i>
                            <span>Started: ${formatDate(medication.start_date)}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Update the medications container
    medicationsContainer.innerHTML = medicationsHTML;
}


// Update the initialization function to include the new functionality
document.addEventListener('DOMContentLoaded', function () {
    // Load medicine categories
    loadMedicineCategories();

    // Set up medicine selection handler
    handleMedicineSelection();

    // Add event listener for category change
    const categorySelect = document.getElementById('medicine_category');
    if (categorySelect) {
        categorySelect.addEventListener('change', searchMedicines);
    }

    // Add event listener for search input
    const searchInput = document.getElementById('medicine_search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                searchMedicines();
            }
        });
    }

    // Load saved medications on page load
    loadSavedMedications();

    // Add event listener to medication form if it exists
    const medicationForm = document.getElementById('medicationForm');
    if (medicationForm) {
        medicationForm.addEventListener('submit', handleMedicationSubmit);
    }
});