<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Referral Form</title>
    <!-- Load Tailwind output first -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <!-- Then load other CSS files -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/referral.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="logo">
                <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
            </div>
            <div class="form-header-text">
                <h1>TEST CLINIC</h1>
                <p>Specialized Care Referral System</p>
            </div>
        </div>

        <div class="form-body">
            <div class="form-title">Patient Referral Form</div>

            <div class="form-grid">
                <!-- Left Column -->
                <div>
                    <div class="section">
                        <div class="section-header">PATIENT INFORMATION</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>First name:</label>
                                <input type="text" placeholder="Enter first name">
                            </div>
                            <div class="form-group">
                                <label>Last name:</label>
                                <input type="text" placeholder="Enter last name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>DOB (mm/dd/yyyy):</label>
                                <input type="text" placeholder="MM/DD/YYYY">
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="tel" placeholder="(xxx) xxx-xxxx">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label>Address:</label>
                                <input type="text" placeholder="Street address, city, state, zip">
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-header">REASON FOR CONSULTATION:</div>
                        <textarea placeholder="Please provide detailed information about the reason for this referral, including relevant symptoms, duration, and any previous treatments."></textarea>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="section">
                        <div class="section-header">REFERRING PHYSICIAN</div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" placeholder="Physician's full name">
                            </div>
                            <div class="form-group">
                                <label>Billing #:</label>
                                <input type="text" placeholder="Enter billing number">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="tel" placeholder="(xxx) xxx-xxxx">
                            </div>
                            <div class="form-group">
                                <label>Fax:</label>
                                <input type="tel" placeholder="(xxx) xxx-xxxx">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label>Address:</label>
                                <input type="text" placeholder="Clinic/hospital address">
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-header">MEDICAL REPORT ATTACHED</div>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="xray">
                                <label for="xray">X-ray</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="ct">
                                <label for="ct">CT Scan</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="micro">
                                <label for="micro">Microbiological Tests</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="allergy">
                                <label for="allergy">Allergy</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="medical">
                                <label for="medical">Medical Notes</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="blood">
                                <label for="blood">Immunological & Blood Tests</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="bronch">
                                <label for="bronch">Bronchoscopy with BAL</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="oral">
                                <label for="oral">Oral Test</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="lumbar">
                                <label for="lumbar">Lumbar Puncture</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="other">
                                <label for="other">Other</label>
                            </div>
                        </div>

                        <div class="additional-question">
                            <p>Is the patient booked for consultation with another specialist?</p>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="yes" name="otherConsult" value="yes">
                                    <label for="yes">Yes</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="no" name="otherConsult" value="no">
                                    <label for="no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button class="btn btn-reset">Reset Form</button>
                <button class="btn btn-submit">Submit Referral</button>
            </div>
        </div>
    </div>
</body>
</html>