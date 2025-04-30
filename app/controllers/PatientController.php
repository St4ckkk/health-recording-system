<?php

namespace app\controllers;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
use app\helpers\email\MonitoringEmail;
use app\models\Patient;
use app\models\Doctor;
use app\models\PatientMonitoringLog;
use app\models\PatientWellnessResponse;
use app\models\MonitoringRequest;
use app\helpers\email\EmailTemplate;
require_once dirname(dirname(__DIR__)) . '/public/vendor/autoload.php';



class PatientController extends Controller
{
    private $monitoringEmailHelper;
    private $patientWellnessResponseModel;
    private $patientMonitoringLogModel;
    private $monitoringRequestModel;
    private $patientModel;
    private $doctorModel;

    public function __construct()
    {
        $this->monitoringEmailHelper = new MonitoringEmail();
        $this->patientModel = new Patient();
        $this->doctorModel = new Doctor();
        $this->monitoringRequestModel = new MonitoringRequest();
        $this->patientMonitoringLogModel = new PatientMonitoringLog();
        $this->patientWellnessResponseModel = new PatientWellnessResponse();
    }

    public function dashboard()
    {
        $this->view('pages/patient/dashboard.view', [
            'title' => 'Dashboard',
        ]);
    }

    public function symptomsChecker()
    {
        $this->view('symptom-checker.view', [
            'title' => 'TB Symptoms Checker'
        ]);
    }


    public function analyzeSymptoms()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'symptom-checker.view');
            exit;
        }

        // Get the symptoms from the form
        $symptoms = [
            isset($_POST['fever_two_weeks']) ? 1 : 0,
            isset($_POST['coughing_blood']) ? 1 : 0,
            isset($_POST['sputum_blood']) ? 1 : 0,
            isset($_POST['night_sweats']) ? 1 : 0,
            isset($_POST['chest_pain']) ? 1 : 0,
            isset($_POST['back_pain']) ? 1 : 0,
            isset($_POST['shortness_breath']) ? 1 : 0,
            isset($_POST['weight_loss']) ? 1 : 0,
            isset($_POST['body_tired']) ? 1 : 0,
            isset($_POST['lumps']) ? 1 : 0,
            isset($_POST['cough_phlegm']) ? 1 : 0,
            isset($_POST['swollen_lymph']) ? 1 : 0,
            isset($_POST['loss_appetite']) ? 1 : 0
        ];

        // Simple prediction logic instead of using RubixML
        $symptomCount = array_sum($symptoms);
        $prediction = $symptomCount > 6 ? 'High Risk' : 'Low Risk';
        $probability = $this->calculateTbProbability($symptoms);

        // Calculate treatment recommendations and additional analytics
        $treatmentData = $this->calculateTreatmentRecommendations($symptoms, $probability);

        // Count symptoms for visualization
        $totalSymptoms = count($symptoms);

        // Prepare symptom names for chart
        $symptomNames = [
            'fever_two_weeks' => 'Fever for two weeks',
            'coughing_blood' => 'Coughing blood',
            'sputum_blood' => 'Sputum mixed with blood',
            'night_sweats' => 'Night sweats',
            'chest_pain' => 'Chest pain',
            'back_pain' => 'Back pain in certain parts',
            'shortness_breath' => 'Shortness of breath',
            'weight_loss' => 'Weight loss',
            'body_tired' => 'Body feels tired',
            'lumps' => 'Lumps around armpits/neck',
            'cough_phlegm' => 'Cough and phlegm (2-4 weeks)',
            'swollen_lymph' => 'Swollen lymph nodes',
            'loss_appetite' => 'Loss of appetite'
        ];

        // Create data for the chart
        $selectedSymptoms = [];
        foreach ($_POST as $key => $value) {
            if (isset($symptomNames[$key])) {
                $selectedSymptoms[$key] = $symptomNames[$key];
            }
        }

        // Calculate symptom categories for radar chart
        $symptomCategories = $this->calculateSymptomCategories($symptoms);

        // Pass all data to the view
        $this->view('symptoms-result.view', [
            'title' => 'TB Symptoms Analysis Results',
            'symptoms' => $symptoms,
            'prediction' => $prediction,
            'probability' => $probability,
            'symptomCount' => $symptomCount,
            'totalSymptoms' => $totalSymptoms,
            'selectedSymptoms' => $selectedSymptoms,
            'treatmentData' => $treatmentData,
            'symptomCategories' => $symptomCategories
        ]);
    }

    /**
     * Calculate treatment recommendations based on symptoms and probability
     */
    private function calculateTreatmentRecommendations($symptoms, $probability)
    {
        // Calculate symptom severity score (0-10)
        $severityScore = min(10, round(($probability / 10) + array_sum($symptoms) / 2));

        // Determine recommended tests based on probability and specific symptoms
        $recommendedTests = [];

        // Basic screening tests for all suspected TB cases
        if ($probability > 20) {
            $recommendedTests[] = "Tuberculin Skin Test (TST)";
            $recommendedTests[] = "Complete Blood Count (CBC)";
        }

        // Sputum tests for respiratory symptoms
        $hasRespiratorySymptoms = ($symptoms[1] || $symptoms[2] || $symptoms[6] || $symptoms[10]);
        if ($probability > 30 || $hasRespiratorySymptoms) {
            $recommendedTests[] = "Sputum Acid-Fast Bacilli (AFB) Smear";
            $recommendedTests[] = "Sputum Culture";
        }

        // Imaging for moderate to high probability
        if ($probability > 40 || $symptoms[4] || $symptoms[6]) {
            $recommendedTests[] = "Chest X-ray";
        }

        // Advanced molecular tests for higher probability
        if ($probability > 60 || ($symptoms[1] && $symptoms[7])) {
            $recommendedTests[] = "GeneXpert MTB/RIF";
        }

        // Comprehensive testing for high probability
        if ($probability > 80 || array_sum($symptoms) > 8) {
            $recommendedTests[] = "TB Culture and Drug Susceptibility Testing";
            $recommendedTests[] = "Interferon-Gamma Release Assay (IGRA)";
        }

        // Additional tests for extrapulmonary symptoms
        if ($symptoms[9] || $symptoms[11]) {
            $recommendedTests[] = "Lymph Node Biopsy";
        }

        // Determine if diagnosis is likely to be confirmed
        $diagnosisConfirmed = $probability > 75 ? 1 : 0;

        // Treatment regimen based on severity and symptom profile
        $treatmentRegimen = "";
        $treatmentDuration = 0;

        if ($probability < 25) {
            $treatmentRegimen = "Monitoring only";
            $treatmentDuration = 0;
        } else if ($probability < 50) {
            $treatmentRegimen = "Preventive therapy: Isoniazid (INH) monotherapy";
            $treatmentDuration = 12;
        } else if ($probability < 70) {
            $treatmentRegimen = "Standard first-line therapy: Isoniazid (INH), Rifampicin (RIF)";
            $treatmentDuration = 16;
        } else {
            $treatmentRegimen = "Intensive first-line therapy: Isoniazid (INH), Rifampicin (RIF), Pyrazinamide (PZA), Ethambutol (EMB)";
            $treatmentDuration = 24;
        }

        // Adjust treatment for severe cases
        if ($severityScore > 8 || ($symptoms[1] && $symptoms[2] && $symptoms[7])) {
            $treatmentRegimen .= " with close monitoring for adverse effects";
        }

        // Follow-up schedule based on severity and probability
        $followUpSchedule = "";
        if ($probability < 30) {
            $followUpSchedule = "Follow-up in 1 month, then quarterly if stable";
        } else if ($probability < 60) {
            $followUpSchedule = "Bi-weekly for first month, then monthly thereafter";
        } else {
            $followUpSchedule = "Weekly for first month, bi-weekly for second month, then monthly thereafter";
        }

        // Isolation and hospitalization requirements
        $isolationRequired = 0;
        if ($probability > 60 && ($symptoms[1] || $symptoms[2])) {
            $isolationRequired = 1; // Respiratory isolation for infectious cases
        }

        $hospitalizationNeeded = 0;
        if ($probability > 80 || $severityScore > 8 || ($symptoms[1] && $symptoms[6] && $symptoms[7])) {
            $hospitalizationNeeded = 1; // Hospitalization for severe cases
        }

        // Nutritional support based on symptoms and severity
        $nutritionalSupport = "";
        if ($probability < 40) {
            $nutritionalSupport = "Balanced diet with adequate protein and calories";
        } else if ($symptoms[7] || $symptoms[12]) {
            $nutritionalSupport = "High protein, high calorie diet with vitamin supplements (especially B6, D)";
        } else {
            $nutritionalSupport = "Protein-rich diet with micronutrient supplementation";
        }

        // Additional recommendations
        $additionalRecommendations = [];

        if ($symptoms[6]) {
            $additionalRecommendations[] = "Pulmonary rehabilitation exercises";
        }

        if ($symptoms[7] || $symptoms[12]) {
            $additionalRecommendations[] = "Nutritional counseling";
        }

        if ($probability > 50) {
            $additionalRecommendations[] = "Contact tracing for household members";
        }

        if ($isolationRequired) {
            $additionalRecommendations[] = "Respiratory hygiene education";
        }

        return [
            'tb_diagnosis_probability' => $probability,
            'recommended_tests' => $recommendedTests,
            'diagnosis_confirmed' => $diagnosisConfirmed,
            'treatment_regimen' => $treatmentRegimen,
            'treatment_duration_weeks' => $treatmentDuration,
            'follow_up_schedule' => $followUpSchedule,
            'isolation_required' => $isolationRequired,
            'hospitalization_needed' => $hospitalizationNeeded,
            'nutritional_support' => $nutritionalSupport,
            'symptom_severity_score' => $severityScore,
            'additional_recommendations' => $additionalRecommendations
        ];
    }

    /**
     * Calculate symptom categories for radar chart
     */
    private function calculateSymptomCategories($symptoms)
    {
        // Group symptoms into categories
        $respiratorySymptoms = [
            $symptoms[1], // coughing_blood
            $symptoms[2], // sputum_blood
            $symptoms[4], // chest_pain
            $symptoms[6], // shortness_breath
            $symptoms[10] // cough_phlegm
        ];

        $generalSymptoms = [
            $symptoms[0], // fever_two_weeks
            $symptoms[3], // night_sweats
            $symptoms[7], // weight_loss
            $symptoms[8], // body_tired
            $symptoms[12] // loss_appetite
        ];

        $otherSymptoms = [
            $symptoms[5], // back_pain
            $symptoms[9], // lumps
            $symptoms[11] // swollen_lymph
        ];

        return [
            'respiratory' => [
                'count' => array_sum($respiratorySymptoms),
                'total' => count($respiratorySymptoms),
                'percentage' => round((array_sum($respiratorySymptoms) / count($respiratorySymptoms)) * 100)
            ],
            'general' => [
                'count' => array_sum($generalSymptoms),
                'total' => count($generalSymptoms),
                'percentage' => round((array_sum($generalSymptoms) / count($generalSymptoms)) * 100)
            ],
            'other' => [
                'count' => array_sum($otherSymptoms),
                'total' => count($otherSymptoms),
                'percentage' => round((array_sum($otherSymptoms) / count($otherSymptoms)) * 100)
            ]
        ];
    }

    private function loadTbDataset()
    {
        $csvPath = __DIR__ . '/../../public/csv/tb.csv';
        $samples = [];
        $labels = [];

        if (($handle = fopen($csvPath, "r")) !== FALSE) {
            // Skip the header row
            fgetcsv($handle, 1000, ",", "\"", "\\");

            while (($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE) {
                // Extract features (symptoms) from columns 6-18
                $features = array_slice($data, 6, 13);
                $samples[] = array_map('intval', $features);

                // For simplicity, we'll use a binary classification:
                // If more than 6 symptoms are present, consider it high risk
                $symptomCount = array_sum($features);
                $labels[] = $symptomCount > 6 ? 'High Risk' : 'Low Risk';
            }
            fclose($handle);
        }

        // Return a simple array instead of using RubixML Labeled class
        return ['samples' => $samples, 'labels' => $labels];
    }

    private function calculateTbProbability($symptoms)
    {
        // Weight certain symptoms more heavily based on clinical significance
        $weights = [
            1.8, // fever_two_weeks - persistent fever is a strong indicator
            2.5, // coughing_blood - hemoptysis is a very significant symptom
            2.3, // sputum_blood - blood in sputum is highly indicative
            1.5, // night_sweats - classic TB symptom
            1.4, // chest_pain - moderate indicator
            0.8, // back_pain - less specific symptom
            1.7, // shortness_breath - significant respiratory symptom
            1.9, // weight_loss - classic constitutional symptom
            1.0, // body_tired - non-specific but relevant
            1.6, // lumps - lymphadenopathy is significant
            1.8, // cough_phlegm - productive cough is important
            1.5, // swollen_lymph - extrapulmonary sign
            1.2  // loss_appetite - constitutional symptom
        ];

        // Calculate weighted sum of symptoms
        $weightedSum = 0;
        $maxWeightedSum = array_sum($weights);

        foreach ($symptoms as $i => $symptom) {
            $weightedSum += $symptom * $weights[$i];
        }

        // Base probability on weighted symptoms
        $baseProbability = ($weightedSum / $maxWeightedSum) * 100;

        // Apply clinical adjustments
        $adjustedProbability = $baseProbability;

        // Adjust for key symptom combinations that increase likelihood
        // Combination of coughing blood, fever, and weight loss is highly indicative
        if ($symptoms[0] && $symptoms[1] && $symptoms[7]) {
            $adjustedProbability += 15;
        }

        // Combination of night sweats, weight loss, and persistent cough
        if ($symptoms[3] && $symptoms[7] && $symptoms[10]) {
            $adjustedProbability += 10;
        }

        // Respiratory symptoms with constitutional symptoms
        $respiratoryCount = $symptoms[1] + $symptoms[2] + $symptoms[4] + $symptoms[6] + $symptoms[10];
        $constitutionalCount = $symptoms[0] + $symptoms[3] + $symptoms[7] + $symptoms[8] + $symptoms[12];

        if ($respiratoryCount >= 3 && $constitutionalCount >= 2) {
            $adjustedProbability += 12;
        }

        // Cap the probability at 100%
        $finalProbability = min(round($adjustedProbability, 1), 100);

        return $finalProbability;
    }

    public function sendMonitoringRequest()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            // Generate a unique token
            $token = bin2hex(random_bytes(32));

            // Get patient and doctor details
            $patient = $this->patientModel->getPatientById($data['patient_id']);
            $doctor = $this->doctorModel->getDoctorById($_SESSION['doctor']['id']);

            if (!$patient || !$doctor) {
                throw new \Exception('Invalid patient or doctor data');
            }

            // Generate verification code once
            $verificationCode = $this->patientModel->generateVerificationCode($patient->id);
            if (!$verificationCode) {
                throw new \Exception('Failed to generate verification code');
            }

            // Save monitoring request to database
            $monitoringData = [
                'patient_id' => $data['patient_id'],
                'doctor_id' => $_SESSION['doctor']['id'],
                'token' => $token,
                'duration' => $data['duration'] ?? 7,
                'include_symptoms' => $data['include_symptoms'] ?? true,
                'include_wellness' => $data['include_wellness'] ?? true,
                'status' => 'pending',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+' . ($data['duration'] ?? 7) . ' days'))
            ];

            $requestId = $this->monitoringRequestModel->create($monitoringData);

            if (!$requestId) {
                throw new \Exception('Failed to create monitoring request');
            }

            // Use existing monitoringEmailHelper instance
            $emailSent = $this->monitoringEmailHelper->sendMonitoringRequest(
                $patient->email,
                $patient->first_name . ' ' . $patient->last_name,
                $token,
                $doctor->first_name . ' ' . $doctor->last_name,
                $data['duration'] ?? 7,
                $verificationCode
            );

            if (!$emailSent) {
                throw new \Exception('Failed to send email');
            }

            echo json_encode([
                'success' => true,
                'message' => 'Monitoring request sent successfully'
            ]);

        } catch (\Exception $e) {
            error_log('Error sending monitoring request: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to send monitoring request: ' . $e->getMessage()
            ]);
        }
    }

    public function monitoring()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            $_SESSION['flash_message'] = 'Invalid monitoring link.';
            $this->redirect('/');
            return;
        }

        try {
            // Get monitoring request by token
            $monitoringRequest = $this->monitoringRequestModel->getByToken($token);

            if (!$monitoringRequest || $monitoringRequest->status === 'expired') {
                $_SESSION['flash_message'] = 'This monitoring link has expired.';
                $this->redirect('/');
                return;
            }

            // Get patient and doctor details
            $patient = $this->patientModel->getPatientById($monitoringRequest->patient_id);
            $doctor = $this->doctorModel->getDoctorById($monitoringRequest->doctor_id);

            if (!$patient || !$doctor) {
                throw new \Exception('Invalid patient or doctor data');
            }

            // Generate verification code
            $verificationCode = $this->patientModel->generateVerificationCode($patient->id);

            if (!$verificationCode) {
                throw new \Exception('Failed to generate verification code');
            }

            // Send verification code via email
            $emailSent = $this->monitoringEmailHelper->sendMonitoringRequest(
                $patient->email,
                $patient->first_name . ' ' . $patient->last_name,
                $token,
                $doctor->first_name . ' ' . $doctor->last_name,
                $monitoringRequest->duration,
                $verificationCode
            );

            if (!$emailSent) {
                throw new \Exception('Failed to send verification code');
            }

            // Store temporary data
            $_SESSION['temp_monitoring'] = [
                'token' => $token,
                'patient_id' => $patient->id,
                'request_id' => $monitoringRequest->id
            ];

            // Show verification page
            $this->view('pages/patient/verify-code', [
                'title' => 'Verify Access - TeleCure',
                'patient_email' => $patient->email
            ]);

        } catch (\Exception $e) {
            error_log('Monitoring access error: ' . $e->getMessage());
            $_SESSION['flash_message'] = 'An error occurred while accessing monitoring.';
            $this->redirect('/');
        }
    }

    public function showVerification($params)
    {
        $token = $params[0] ?? ''; // Get the token from the parameters array

        try {
            // Get monitoring request by token
            $monitoringRequest = $this->monitoringRequestModel->getByToken($token);

            if (!$monitoringRequest || $monitoringRequest->status === 'expired') {
                $_SESSION['flash_message'] = 'This monitoring link has expired.';
                $this->redirect('/');
                return;
            }

            // Get patient details
            $patient = $this->patientModel->getPatientById($monitoringRequest->patient_id);
            if (!$patient) {
                throw new \Exception('Patient not found');
            }

            $_SESSION['verify_token'] = $token;

            $this->view('pages/patient/verify', [
                'title' => 'Verify Access - TeleCure',
                'patient_email' => $patient->email,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            error_log('Verification page error: ' . $e->getMessage());
            $_SESSION['flash_message'] = 'An error occurred while accessing verification.';
            $this->redirect('/');
        }
    }

    public function verifyCode($params)
    {
        $token = $params[0] ?? '';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/patient/verify/' . $token);
            return;
        }

        try {
            $code = $_POST['verification_code'] ?? '';

            if (!$code || !$token || $token !== $_SESSION['verify_token']) {
                throw new \Exception('Invalid verification attempt');
            }

            $monitoringRequest = $this->monitoringRequestModel->getByToken($token);
            if (!$monitoringRequest) {
                throw new \Exception('Invalid monitoring request');
            }

            // Get patient details
            $patient = $this->patientModel->getPatientById($monitoringRequest->patient_id);
            if (!$patient) {
                throw new \Exception('Patient not found');
            }

            $verified = $this->patientModel->verifyCode($monitoringRequest->patient_id, $code);

            if (!$verified) {
                $_SESSION['flash_message'] = 'Invalid or expired verification code';
                $this->redirect('/patient/verify/' . $token);
                return;
            }

            $this->patientModel->clearVerificationCode($monitoringRequest->patient_id);

            // Create complete patient session
            $_SESSION['patient'] = [
                'id' => $patient->id,
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
                'email' => $patient->email,
                'profile' => $patient->profile ?? null,
                'type' => 'monitoring_patient',
                'request_id' => $monitoringRequest->id,
                'expires_at' => $monitoringRequest->expires_at
            ];

            unset($_SESSION['verify_token']);
            $this->redirect('/patient/monitoring/dashboard');

        } catch (\Exception $e) {
            error_log('Code verification error: ' . $e->getMessage());
            $_SESSION['flash_message'] = 'An error occurred during verification';
            $this->redirect('/patient/verify/' . $token);
        }
    }


    public function monitoringDashboard()
    {
        if (!isset($_SESSION['patient']) || $_SESSION['patient']['type'] !== 'monitoring_patient') {
            $_SESSION['flash_message'] = 'Please verify your access first';
            $this->redirect('/');
            return;
        }

        // Get monitoring data
        $monitoringData = [
            'logs' => $this->patientMonitoringLogModel->getPatientLogs(
                $_SESSION['patient']['id'],
                $_SESSION['patient']['request_id']
            ),
            'request' => $this->monitoringRequestModel->getById($_SESSION['patient']['request_id']),
            'patient' => $this->patientModel->getPatientById($_SESSION['patient']['id'])
        ];

        $this->view('pages/patient/dashboard.view', [
            'title' => 'TeleCure - Patient Monitoring Dashboard',
            'monitoring_data' => $monitoringData
        ]);
    }

    private function checkMonitoringSession()
    {
        if (!isset($_SESSION['monitoring_patient'])) {
            if (isset($_GET['token'])) {
                $this->monitoring();
                return;
            }
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            exit;
        }

        if (strtotime($_SESSION['monitoring_patient']['expires_at']) < time()) {
            $this->monitoringRequestModel->updateStatus(
                $_SESSION['monitoring_patient']['request_id'],
                'expired'
            );
            unset($_SESSION['monitoring_patient']);
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Monitoring session has expired']);
            exit;
        }
    }

    // Update saveMonitoringLog to use the middleware
    public function saveMonitoringLog()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        // Check monitoring session before proceeding
        $this->checkMonitoringSession();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $logData = [
                'monitoring_request_id' => $_SESSION['monitoring_patient']['request_id'],
                'patient_id' => $_SESSION['monitoring_patient']['id'],
                'log_date' => date('Y-m-d'),
                'log_time' => date('H:i:s'),
                'temperature' => $data['temperature'] ?? null,
                'blood_pressure' => $data['blood_pressure'] ?? null,
                'heart_rate' => $data['heart_rate'] ?? null,
                'fatigue_level' => $data['fatigue_level'] ?? null,
                'additional_symptoms' => $data['additional_symptoms'] ?? null,
                'notes' => $data['notes'] ?? null
            ];

            $logId = $this->patientMonitoringLogModel->create($logData);

            if (!$logId) {
                throw new \Exception('Failed to save monitoring log');
            }

            // Save wellness data if included
            if (isset($data['wellness_data'])) {
                $wellnessData = array_merge(['monitoring_log_id' => $logId], $data['wellness_data']);
                $this->patientWellnessResponseModel->create($wellnessData);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Monitoring log saved successfully',
                'log_id' => $logId
            ]);
        } catch (\Exception $e) {
            error_log('Error saving monitoring log: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to save monitoring log']);
        }
    }
}