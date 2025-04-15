document.addEventListener('DOMContentLoaded', function() {
    // Initialize signature pad
    const canvas = document.getElementById('signaturePad');
    
    // Set canvas width
    canvas.width = canvas.offsetWidth;
    
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
        minWidth: 1,
        maxWidth: 2.5
    });

    // Handle window resize
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.height * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }

    window.onresize = resizeCanvas;
    resizeCanvas();

    // Clear signature
    document.getElementById('clearSignature').addEventListener('click', () => {
        signaturePad.clear();
    });

    // Handle signature image upload
                const uploadBtn = document.getElementById('uploadSignature');
                const fileInput = document.getElementById('signatureImage');
                
                uploadBtn.addEventListener('click', () => {
                    fileInput.click();
                });

                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = new Image();
                            img.onload = function() {
                                const canvas = document.getElementById('signaturePad');
                                const ctx = canvas.getContext('2d');
                                ctx.clearRect(0, 0, canvas.width, canvas.height);
                                
                                // Calculate aspect ratio to fit image within canvas
                                const scale = Math.min(
                                    canvas.width / img.width,
                                    canvas.height / img.height
                                );
                                const x = (canvas.width - img.width * scale) / 2;
                                const y = (canvas.height - img.height * scale) / 2;
                                
                                ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
                                document.getElementById('signatureData').value = canvas.toDataURL();
                            };
                            img.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const signatureData = document.getElementById('signatureData').value;
        if (signaturePad.isEmpty() && !signatureData) {
            e.preventDefault();
            showToast('error', 'Signature Required', 'Please provide a signature before submitting the prescription.');
            return;
        }
        
        // If signature pad is empty but we have uploaded image data, use that
        if (signaturePad.isEmpty() && signatureData) {
            document.getElementById('signatureData').value = signatureData;
        } else {
            document.getElementById('signatureData').value = signaturePad.toDataURL();
        }
    });

    // Initialize flatpickr
    flatpickr("input[placeholder='Pick a date']", {
        dateFormat: "d-M-Y",
    });
    
    flatpickr("input[value='27-Apr-2023']", {
        dateFormat: "d-M-Y",
        defaultDate: "27-Apr-2023"
    });

    // Medications functionality
    const medicationsContainer = document.getElementById('medicationsContainer');
    const addMedicationBtn = document.getElementById('addMedication');
    let medicationCount = 0;

    if (medicationsContainer && addMedicationBtn) {
        // Add grid class to container
        medicationsContainer.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';

        function createMedicationCard() {
            medicationCount++;
            const card = document.createElement('div');
            // Remove margin classes as we're using grid gap
            card.className = 'bg-white border rounded-md p-4 shadow-sm';
            
            // Rest of the createMedicationCard function remains the same
            card.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-medium text-gray-800">Medication #${medicationCount}</h3>
                    <button type="button" class="text-red-500 hover:text-red-700 delete-medication">
                        <i class="bx bx-trash text-xl"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                        <input type="text" name="medications[${medicationCount}][name]" required placeholder="Enter medication name" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Quantity</label>
                        <input type="text" name="medications[${medicationCount}][quantity]" required placeholder="e.g., 20 tablets" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosage Instructions</label>
                        <input type="text" name="medications[${medicationCount}][dosage]" required placeholder="e.g., 1 tablet twice daily" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                        <input type="text" name="medications[${medicationCount}][duration]" required placeholder="e.g., 7 days" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Special Instructions</label>
                        <textarea name="medications[${medicationCount}][instructions]" rows="2" placeholder="Any special instructions" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                    </div>
                </div>
            `;

            medicationsContainer.appendChild(card);

            // Add delete functionality
            const deleteBtn = card.querySelector('.delete-medication');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    card.remove();
                });
            }
        }

        // Add click event listener to the Add Medication button
        addMedicationBtn.addEventListener('click', createMedicationCard);

        // Create initial medication card
        createMedicationCard();
    }
});