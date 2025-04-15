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
});


document.addEventListener('DOMContentLoaded', function() {
    flatpickr("input[placeholder='Pick a date']", {
        dateFormat: "d-M-Y",
    });
    
    flatpickr("input[value='27-Apr-2023']", {
        dateFormat: "d-M-Y",
        defaultDate: "27-Apr-2023"
    });

 
    const medicationsContainer = document.getElementById('medicationsContainer');
    const addMedicationBtn = document.getElementById('addMedication');
    let medicationCount = 0;

    function createMedicationCard() {
        medicationCount++;
        const card = document.createElement('div');
        card.className = 'border rounded-md p-4';
        card.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-medium text-gray-800">Medication #${medicationCount}</h3>
                <button type="button" class="text-red-500 hover:text-red-700 delete-medication">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                    <input type="text" name="medications[${medicationCount}][name]" placeholder="TAB. DEMO MEDICINE ${medicationCount}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Quantity</label>
                    <input type="text" name="medications[${medicationCount}][quantity]" placeholder="20" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosage Instructions</label>
                    <input type="text" name="medications[${medicationCount}][dosage]" placeholder="1 Morning, 1 Night (Before Food)" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                    <input type="text" name="medications[${medicationCount}][duration]" placeholder="10 Days" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Special Instructions</label>
                    <textarea name="medications[${medicationCount}][instructions]" placeholder="Take with food, avoid alcohol, etc." rows="2" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
            </div>
        `;

        medicationsContainer.appendChild(card);

        // Add delete functionality
        card.querySelector('.delete-medication').addEventListener('click', function() {
            card.remove();
        });
    }

    addMedicationBtn.addEventListener('click', createMedicationCard);

    // Add initial medication card
    createMedicationCard();
});