<?php

namespace app\models;

use app\models\Model;

class TreatmentRecords extends Model
{
    protected $table = 'treatment_records';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'tr.id',
            'tr.patient_id',
            'tr.doctor_id',
            'tr.treatment_type',
            'tr.regimen_summary',
            'tr.start_date',
            'tr.end_date',
            'tr.adherence_status',
            'tr.outcome',
            'tr.follow_up_notes',
            'tr.status',
            'tr.created_at',
            'tr.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table im";
    }

    public function getPatientTreatmentRecords($patientId)
    {
        $sql = "SELECT tr.*, 
                           d.first_name as doctor_first_name, 
                           d.last_name as doctor_last_name,
                           d.specialization as doctor_specialization
                        FROM {$this->table} tr
                        LEFT JOIN doctors d ON tr.doctor_id = d.id
                        WHERE tr.patient_id = :patient_id
                        ORDER BY tr.created_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getTreatmentById($treatmentId)
    {
        $sql = "SELECT tr.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization
                FROM {$this->table} tr
                LEFT JOIN doctors d ON tr.doctor_id = d.id
                WHERE tr.id = :treatment_id";

        $this->db->query($sql);
        $this->db->bind(':treatment_id', $treatmentId);

        return $this->db->single();
    }

    public function insert($data)
    {
        $this->db->query("INSERT INTO {$this->table} (patient_id, doctor_id, treatment_type, regimen_summary, 
                          start_date, end_date, adherence_status, outcome, follow_up_notes, status, created_at, updated_at) 
                          VALUES (:patient_id, :doctor_id, :treatment_type, :regimen_summary, 
                          :start_date, :end_date, :adherence_status, :outcome, :follow_up_notes, :status, NOW(), NOW())");

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':treatment_type', $data['treatment_type']);
        $this->db->bind(':regimen_summary', $data['regimen_summary']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date'] ?? null);
        $this->db->bind(':adherence_status', $data['adherence_status'] ?? null);
        $this->db->bind(':outcome', $data['outcome'] ?? null);
        $this->db->bind(':follow_up_notes', $data['follow_up_notes'] ?? null);
        $this->db->bind(':status', $data['status']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function updateTreatment($data)
    {
        try {
            // Validate treatment exists
            $exists = $this->getTreatmentById($data['treatment_id']);
            if (!$exists) {
                throw new \Exception('Treatment record not found');
            }

            $sql = "UPDATE {$this->table} SET 
                    treatment_type = :treatment_type,
                    regimen_summary = :regimen_summary,
                    start_date = :start_date,
                    end_date = :end_date,
                    status = :status,
                    outcome = :outcome,
                    adherence_status = :adherence_status,
                    follow_up_notes = :follow_up_notes,
                    updated_at = NOW()
                    WHERE id = :id";

            $this->db->query($sql);

            $this->db->bind(':id', $data['treatment_id']);
            $this->db->bind(':treatment_type', $data['treatment_type']);
            $this->db->bind(':regimen_summary', $data['regimen_summary']);
            $this->db->bind(':start_date', $data['start_date']);
            $this->db->bind(':end_date', $data['end_date']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':outcome', $data['outcome']);
            $this->db->bind(':adherence_status', $data['adherence_status']);
            $this->db->bind(':follow_up_notes', $data['follow_up_notes']);

            return $this->db->execute();

        } catch (\PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            throw new \Exception('Database error occurred');
        }
    }
    
    public function getTreatmentOutcomeStats($doctorId)
    {
        $sql = "SELECT 
                    treatment_type as type,
                    COUNT(*) as total_count,
                    SUM(CASE WHEN outcome = 'Success' THEN 1 ELSE 0 END) as success_count,
                    SUM(CASE WHEN outcome = 'Partial' THEN 1 ELSE 0 END) as partial_count,
                    SUM(CASE WHEN outcome = 'Failure' THEN 1 ELSE 0 END) as failure_count,
                    ROUND(SUM(CASE WHEN outcome = 'Success' THEN 1 ELSE 0 END) / COUNT(*) * 100, 1) as success_rate,
                    ROUND(AVG(DATEDIFF(IFNULL(end_date, CURDATE()), start_date)), 0) as avg_duration,
                    (SELECT diagnosis FROM diagnosis d 
                     WHERE d.patient_id = tr.patient_id 
                     ORDER BY d.diagnosed_at DESC LIMIT 1) as common_diagnosis
                FROM {$this->table} tr
                WHERE doctor_id = :doctor_id
                GROUP BY treatment_type
                ORDER BY total_count DESC";
                
        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);
        
        return $this->db->resultSet();
    }
}