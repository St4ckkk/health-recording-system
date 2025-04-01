<?php

namespace app\models;

use app\models\Model;

class Medications extends Model
{
    protected $table = 'medications';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
            'm.id',
            'm.patient_id',
            'm.medication_name',
            'm.dosage',
            'm.frequency',
            'm.start_date',
            'm.prescribed_by',
            'm.purpose',
            'm.created_at',
            'm.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table m";
    }

    public function getCurrentMedicationsByPatientId($patientId) {
        $sql = "SELECT 
                m.*,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name
            FROM {$this->table} m
            LEFT JOIN doctors d ON m.prescribed_by = d.id
            LEFT JOIN patients p ON m.patient_id = p.id
            WHERE m.patient_id = :patient_id
            ORDER BY m.start_date DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }
}