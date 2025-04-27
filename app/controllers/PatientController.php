<?php

namespace app\controllers;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\CrossValidation\Metrics\Accuracy;
require_once dirname(dirname(__DIR__)) . '/public/vendor/autoload.php';



class PatientController extends Controller
{

    public function __construct()
    {

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

}