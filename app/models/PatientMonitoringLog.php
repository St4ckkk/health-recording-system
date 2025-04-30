<?php

namespace app\models;

class PatientMonitoringLog extends Model
{
    protected $table = 'patient_monitoring_logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (
            monitoring_request_id,
            patient_id,
            log_date,
            log_time,
            temperature,
            blood_pressure,
            heart_rate,
            fatigue_level,
            cough_severity,
            pain_level,
            additional_symptoms,
            notes
        ) VALUES (
            :monitoring_request_id,
            :patient_id,
            :log_date,
            :log_time,
            :temperature,
            :blood_pressure,
            :heart_rate,
            :fatigue_level,
            :cough_severity,
            :pain_level,
            :additional_symptoms,
            :notes
        )";

        try {
            $this->db->query($sql);
            $this->db->bind(':monitoring_request_id', $data['monitoring_request_id']);
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':log_date', $data['log_date']);
            $this->db->bind(':log_time', $data['log_time']);
            $this->db->bind(':temperature', $data['temperature'] ?? null);
            $this->db->bind(':blood_pressure', $data['blood_pressure'] ?? null);
            $this->db->bind(':heart_rate', $data['heart_rate'] ?? null);
            $this->db->bind(':fatigue_level', $data['fatigue_level'] ?? null);
            $this->db->bind(':cough_severity', $data['cough_severity'] ?? null);
            $this->db->bind(':pain_level', $data['pain_level'] ?? null);
            $this->db->bind(':additional_symptoms', $data['additional_symptoms'] ?? null);
            $this->db->bind(':notes', $data['notes'] ?? null);

            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            error_log('PatientMonitoringLog create error: ' . $e->getMessage());
            return false;
        }
    }

    public function getPatientLogs($patientId, $requestId = null)
    {
        $query = "SELECT * FROM {$this->table} 
                 WHERE patient_id = :patient_id" .
            ($requestId ? " AND monitoring_request_id = :request_id" : "") .
            " ORDER BY log_date DESC, log_time DESC";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        if ($requestId) {
            $this->db->bind(':request_id', $requestId);
        }
        return $this->db->resultSet();
    }

    public function getDailyLog($patientId, $requestId, $date)
    {
        $query = "SELECT * FROM {$this->table} 
                 WHERE patient_id = :patient_id 
                 AND monitoring_request_id = :request_id 
                 AND log_date = :log_date";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':request_id', $requestId);
        $this->db->bind(':log_date', $date);
        return $this->db->single();
    }
}