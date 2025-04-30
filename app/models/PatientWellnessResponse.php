<?php
namespace app\models;

use app\models\Model;


class PatientWellnessResponse extends Model
{
    protected $table = 'patient_wellness_responses';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get latest wellness response for a patient
     * @param int $patientId
     * @return object|false
     */
    public function getLatestResponse($patientId)
    {
        $query = "SELECT pwr.* 
              FROM {$this->table} pwr
              JOIN patient_monitoring_logs pml ON pwr.monitoring_log_id = pml.id
              WHERE pml.patient_id = :patient_id
              ORDER BY pml.log_date DESC, pml.log_time DESC
              LIMIT 1";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->single();
    }

    /**
     * Get wellness survey data for dashboard
     * @param int $patientId
     * @return array
     */
    public function getWellnessSurveyData($patientId)
    {
        // Get latest wellness data
        $latestQuery = "SELECT pwr.* 
                   FROM {$this->table} pwr
                   JOIN patient_monitoring_logs pml ON pwr.monitoring_log_id = pml.id
                   WHERE pml.patient_id = :patient_id
                   ORDER BY pml.log_date DESC, pml.log_time DESC
                   LIMIT 1";

        $this->db->query($latestQuery);
        $this->db->bind(':patient_id', $patientId);
        $latestData = $this->db->single();

        // Get survey completion status
        $todayQuery = "SELECT COUNT(*) as count
                  FROM {$this->table} pwr
                  JOIN patient_monitoring_logs pml ON pwr.monitoring_log_id = pml.id
                  WHERE pml.patient_id = :patient_id
                  AND pml.log_date = CURRENT_DATE";

        $this->db->query($todayQuery);
        $this->db->bind(':patient_id', $patientId);
        $todayData = $this->db->single();

        $surveyStatus = ($todayData && $todayData->count > 0) ? 'completed' : 'due';

        return [
            'latest_data' => $latestData,
            'survey_status' => $surveyStatus
        ];
    }
}
