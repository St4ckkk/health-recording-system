<?php

namespace app\models;

use app\models\Model;
class PatientMonitoringLog extends Model
{

    protected $table = 'patient_monitoring_logs';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get all logs
     * @return array
     */
    public function getAllLogs()
    {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    /**
     * Get log by ID
     * @param int $id
     * @return mixed
     */
    public function getLogById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Add a new log
     * @param array $data
     * @return bool
     */
    public function addLog($data)
    {
        $this->db->query("INSERT INTO {$this->table} (patient_id, log_date, log_time, temperature, blood_pressure, heart_rate, oxygen_saturation, pain_level, fatigue_level, cough_severity, shortness_of_breath, dizziness, other_symptoms, notes) VALUES (:patient_id, :log_date, :log_time, :temperature, :blood_pressure, :heart_rate, :oxygen_saturation, :pain_level, :fatigue_level, :cough_severity, :shortness_of_breath, :dizziness, :other_symptoms, :notes)");
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':log_date', $data['log_date']);
        $this->db->bind(':log_time', $data['log_time']);
        $this->db->bind(':temperature', $data['temperature']);
        $this->db->bind(':blood_pressure', $data['blood_pressure']);
        $this->db->bind(':heart_rate', $data['heart_rate']);
        $this->db->bind(':oxygen_saturation', $data['oxygen_saturation']);
        $this->db->bind(':pain_level', $data['pain_level']);
        $this->db->bind(':fatigue_level', $data['fatigue_level']);
        $this->db->bind(':cough_severity', $data['cough_severity']);
        $this->db->bind(':shortness_of_breath', $data['shortness_of_breath']);
        $this->db->bind(':dizziness', $data['dizziness']);
        $this->db->bind(':other_symptoms', $data['other_symptoms']);
        $this->db->bind(':notes', $data['notes']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update an existing log
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateLog($id, $data)
    {
        $this->db->query("UPDATE {$this->table} SET patient_id = :patient_id, log_date = :log_date, log_time = :log_time, temperature = :temperature, blood_pressure = :blood_pressure, heart_rate = :heart_rate, oxygen_saturation = :oxygen_saturation, pain_level = :pain_level, fatigue_level = :fatigue_level, cough_severity = :cough_severity, shortness_of_breath = :shortness_of_breath, dizziness = :dizziness, other_symptoms = :other_symptoms, notes = :notes WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':log_date', $data['log_date']);
        $this->db->bind(':log_time', $data['log_time']);
        $this->db->bind(':temperature', $data['temperature']);
        $this->db->bind(':blood_pressure', $data['blood_pressure']);
        $this->db->bind(':heart_rate', $data['heart_rate']);
        $this->db->bind(':oxygen_saturation', $data['oxygen_saturation']);
        $this->db->bind(':pain_level', $data['pain_level']);
        $this->db->bind(':fatigue_level', $data['fatigue_level']);
        $this->db->bind(':cough_severity', $data['cough_severity']);
        $this->db->bind(':shortness_of_breath', $data['shortness_of_breath']);
        $this->db->bind(':dizziness', $data['dizziness']);
        $this->db->bind(':other_symptoms', $data['other_symptoms']);
        $this->db->bind(':notes', $data['notes']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a log
     * @param int $id
     * @return bool
     */
    public function deleteLog($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Add these new methods to fetch dashboard data

    /**
     * Get recent logs for a patient
     * @param int $patientId
     * @param int $days Number of days to retrieve
     * @return array
     */
    public function getRecentLogs($patientId, $days = 7)
    {
        $query = "SELECT * FROM {$this->table} 
             WHERE patient_id = :patient_id
             AND log_date >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)
             ORDER BY log_date DESC, log_time DESC";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':days', $days);
        return $this->db->resultSet();
    }

    /**
     * Get symptom chart data for a patient
     * @param int $patientId
     * @param int $days Number of days to retrieve
     * @return array
     */
    public function getSymptomChartData($patientId, $days = 7)
    {
        $query = "SELECT 
                log_date, 
                fatigue_level, 
                cough_severity, 
                temperature,
                pain_level
             FROM {$this->table} 
             WHERE patient_id = :patient_id
             AND log_date >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)
             ORDER BY log_date ASC";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':days', $days);

        $results = $this->db->resultSet();

        // Format data for chart
        $dates = [];
        $fatigueData = [];
        $coughData = [];
        $temperatureData = [];
        $painData = [];

        foreach ($results as $row) {
            $dates[] = date('M d', strtotime($row->log_date));
            $fatigueData[] = $row->fatigue_level ?? 0;
            $coughData[] = $row->cough_severity ?? 0;
            $temperatureData[] = $row->temperature ?? 98.6;
            $painData[] = $row->pain_level ?? 0;
        }

        return [
            'dates' => $dates,
            'fatigue' => $fatigueData,
            'cough' => $coughData,
            'temperature' => $temperatureData,
            'pain' => $painData
        ];
    }

    /**
     * Get quick stats for dashboard
     * @param int $patientId
     * @return array
     */
    public function getQuickStats($patientId)
    {
        // Get medication adherence
        $adherenceQuery = "SELECT 
                        COUNT(CASE WHEN medication_adherence = 'taken' THEN 1 END) as taken_count,
                        COUNT(*) as total_count
                      FROM patient_wellness_responses pwr
                      JOIN {$this->table} pml ON pwr.monitoring_log_id = pml.id
                      WHERE pml.patient_id = :patient_id
                      AND pml.log_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";

        $this->db->query($adherenceQuery);
        $this->db->bind(':patient_id', $patientId);
        $adherenceData = $this->db->single();

        $medicationAdherence = 0;
        if ($adherenceData && $adherenceData->total_count > 0) {
            $medicationAdherence = round(($adherenceData->taken_count / $adherenceData->total_count) * 100);
        }

        // Get symptom status
        $symptomQuery = "SELECT 
                      AVG(fatigue_level) as avg_fatigue,
                      AVG(cough_severity) as avg_cough,
                      AVG(pain_level) as avg_pain
                    FROM {$this->table}
                    WHERE patient_id = :patient_id
                    AND log_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";

        $this->db->query($symptomQuery);
        $this->db->bind(':patient_id', $patientId);
        $symptomData = $this->db->single();

        $symptomStatus = 'Stable';
        $symptomTrend = 'Stable';

        if ($symptomData) {
            $avgSymptomScore = ($symptomData->avg_fatigue + $symptomData->avg_cough + $symptomData->avg_pain) / 3;
            if ($avgSymptomScore < 1) {
                $symptomStatus = 'Excellent';
                $symptomTrend = 'Improving';
            } else if ($avgSymptomScore < 2) {
                $symptomStatus = 'Good';
                $symptomTrend = 'Improving';
            } else if ($avgSymptomScore < 3) {
                $symptomStatus = 'Stable';
                $symptomTrend = 'Stable';
            } else {
                $symptomStatus = 'Concerning';
                $symptomTrend = 'Worsening';
            }
        }

        // Get wellness score
        $wellnessQuery = "SELECT 
                      AVG(sleep_quality) as avg_sleep,
                      AVG(5 - stress_level) as avg_stress, -- Invert stress level for scoring
                      AVG(CASE WHEN mood = 'happy' THEN 5 
                               WHEN mood = 'neutral' THEN 3
                               ELSE 1 END) as avg_mood,
                      AVG(CASE WHEN appetite = 'normal' THEN 5
                               WHEN appetite = 'reduced' THEN 3
                               ELSE 1 END) as avg_appetite
                    FROM patient_wellness_responses pwr
                    JOIN {$this->table} pml ON pwr.monitoring_log_id = pml.id
                    WHERE pml.patient_id = :patient_id
                    AND pml.log_date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";

        $this->db->query($wellnessQuery);
        $this->db->bind(':patient_id', $patientId);
        $wellnessData = $this->db->single();

        $wellnessScore = 0;
        if ($wellnessData) {
            $wellnessScore = round(($wellnessData->avg_sleep + $wellnessData->avg_stress +
                $wellnessData->avg_mood + $wellnessData->avg_appetite) / 4, 1);
        }

        // Get next appointment (placeholder - would need appointment table)
        $nextAppointment = [
            'days' => 3,
            'date' => date('M d, Y', strtotime('+3 days'))
        ];

        return [
            'medication_adherence' => [
                'value' => $medicationAdherence,
                'trend' => $medicationAdherence > 90 ? 'up' : 'down',
                'change' => '3%'
            ],
            'symptom_status' => [
                'value' => $symptomStatus,
                'trend' => $symptomTrend
            ],
            'wellness_score' => [
                'value' => $wellnessScore,
                'trend' => $wellnessScore > 3.5 ? 'up' : 'down',
                'change' => '0.3'
            ],
            'next_appointment' => $nextAppointment
        ];
    }
}
