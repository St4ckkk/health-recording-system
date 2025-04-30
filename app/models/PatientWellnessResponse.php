<?php

namespace app\models;

class PatientWellnessResponse extends Model
{
    protected $table = 'patient_wellness_responses';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (
            monitoring_log_id,
            sleep_quality,
            stress_level,
            mood,
            appetite,
            medication_adherence
        ) VALUES (
            :monitoring_log_id,
            :sleep_quality,
            :stress_level,
            :mood,
            :appetite,
            :medication_adherence
        )";

        try {
            $this->db->query($sql);
            $this->db->bind(':monitoring_log_id', $data['monitoring_log_id']);
            $this->db->bind(':sleep_quality', $data['sleep_quality']);
            $this->db->bind(':stress_level', $data['stress_level']);
            $this->db->bind(':mood', $data['mood']);
            $this->db->bind(':appetite', $data['appetite']);
            $this->db->bind(':medication_adherence', $data['medication_adherence']);

            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            error_log('PatientWellnessResponse create error: ' . $e->getMessage());
            return false;
        }
    }

    public function getByLogId($logId)
    {
        $query = "SELECT * FROM {$this->table} WHERE monitoring_log_id = :log_id";
        $this->db->query($query);
        $this->db->bind(':log_id', $logId);
        return $this->db->single();
    }

    public function getWellnessTrends($patientId, $days = 7)
    {
        $query = "SELECT 
                    pwr.*,
                    pml.log_date
                 FROM {$this->table} pwr
                 JOIN patient_monitoring_logs pml ON pwr.monitoring_log_id = pml.id
                 WHERE pml.patient_id = :patient_id
                 AND pml.log_date >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)
                 ORDER BY pml.log_date ASC";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':days', $days);
        return $this->db->resultSet();
    }
}