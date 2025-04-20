<?php

namespace app\models;

use app\models\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'd.id',
            'd.patient_id',
            'd.doctor_id',
            'd.diagnosis',
            'd.diagnosed_at',
            'd.notes',
            'd.status',
            'd.created_at',
            'd.updated_at'
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} d";
        return $query;
    }



    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            id,
            patient_id,
            doctor_id,
            diagnosis,
            diagnosed_at,
            notes
        ) VALUES (
            NULL,
            :patient_id,
            :doctor_id,
            :diagnosis,
            :diagnosed_at,
            :notes
        )";

        $this->db->query($sql);


        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':diagnosed_at', $data['diagnosed_at']);
        $this->db->bind(':notes', $data['notes']);

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function getPatientDiagnoses($patientId)
    {
        $sql = "SELECT id, diagnosis, diagnosed_at, notes 
                FROM {$this->table} 
                WHERE patient_id = :patient_id 
                ORDER BY diagnosed_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getDoctorDiagnosisStats($doctorId)
    {
        $sql = "SELECT 
                    diagnosis, 
                    COUNT(*) as count,
                    MAX(diagnosed_at) as latest_date,
                    MIN(diagnosed_at) as first_date
                FROM {$this->table}
                WHERE doctor_id = :doctor_id
                GROUP BY diagnosis
                ORDER BY count DESC
                LIMIT 10";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        return $this->db->resultSet();
    }

}